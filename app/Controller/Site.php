<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Subscriber;
use Model\Subdivision;
use Model\Phone;
use Model\Room;
use Src\Auth\Auth;
use Model\TypeOfUnit;

class Site
{
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Добро пожаловать в систему учета абонентов']);
    }

    // Главная страница после входа
    public function dashboard(): string
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }

        $user = Auth::user();
        return new View('site.dashboard', ['user' => $user]);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();
            $existingUser = User::where('login', $data['login'])->first();
            if ($existingUser) {
                return new View('site.signup', ['error' => 'Пользователь с таким логином уже существует!']);
            }
            $data['id_role'] = 1;
            $data['password'] = md5($data['password']);
            if (User::create($data)) {
                app()->route->redirect('/hello');
            }
        }
        return new View('site.signup');
    }

    public function login(Request $request): string
    {
        if ($request->method === 'GET') {
            return new View('site.login');
        }

        if (Auth::attempt($request->all())) {
            app()->route->redirect('/');
        }

        return new View('site.login', ['message' => 'Ошибка: Неверный логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }

    private function isSysAdmin(): bool
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return $user->id_role == 1;
    }

    private function isAdmin(): bool
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return $user->id_role == 2;
    }

    // ==================== ДОСТУПНО ТОЛЬКО ДЛЯ СИСАДМИНА ====================

    public function subscribers(Request $request): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $query = Subscriber::with('subdivision', 'phones');
        $subdivisionId = $request->get('subdivision_id');
        if ($subdivisionId && $subdivisionId !== '') {
            $query->where('subdivision_id', $subdivisionId);
        }

        $subscribers = $query->get();
        $subdivisions = Subdivision::all();

        return new View('site.subscribers', [
            'subscribers' => $subscribers,
            'subdivisions' => $subdivisions,
            'selectedSubdivision' => $subdivisionId
        ]);
    }

    public function createSubscriber(Request $request): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($request->method === 'POST') {
            $data = $request->all();
            $data['created_by'] = Auth::user()->id_user;
            if (Subscriber::create($data)) {
                app()->route->redirect('/subscribers?message=Абонент добавлен');
            }
        }

        return new View('site.create_subscriber', [
            'subdivisions' => Subdivision::all()
        ]);
    }

    public function attachPhone(Request $request): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($request->method === 'POST') {
            $subscriber = Subscriber::find($request->get('subscriber_id'));
            if ($subscriber && $request->get('phone_id')) {
                $subscriber->phones()->attach($request->get('phone_id'));
                app()->route->redirect('/subscribers?message=Телефон привязан');
            }
        }

        return new View('site.attach_phone', [
            'subscribers' => Subscriber::all(),
            'phones' => Phone::all()
        ]);
    }

    public function reportBySubdivision(): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $subdivisions = Subdivision::withCount('subscribers')->get();
        return new View('site.report_subdivision', ['subdivisions' => $subdivisions]);
    }

    public function reportByRoom(): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $rooms = Room::withCount('phones')->get();
        return new View('site.report_room', ['rooms' => $rooms]);
    }

    public function subdivisions(Request $request): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($request->method === 'POST') {
            $data = $request->all();
            Subdivision::create($data);
            app()->route->redirect('/subdivisions?message=Подразделение добавлено');
        }

        $subdivisions = Subdivision::with('type')->get();
        $types = TypeOfUnit::all();

        return new View('site.subdivisions', [
            'subdivisions' => $subdivisions,
            'types' => $types
        ]);
    }

    public function rooms(Request $request): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($request->method === 'POST') {
            Room::create($request->all());
            app()->route->redirect('/rooms?message=Помещение добавлено');
        }

        $rooms = Room::with('subdivision')->get();
        $subdivisions = Subdivision::all();
        return new View('site.rooms', [
            'rooms' => $rooms,
            'subdivisions' => $subdivisions
        ]);
    }

    public function phones(Request $request): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($request->method === 'POST') {
            Phone::create($request->all());
            app()->route->redirect('/phones?message=Телефон добавлен');
        }

        $phones = Phone::with('room', 'subscribers')->get();
        $rooms = Room::all();
        return new View('site.phones', [
            'phones' => $phones,
            'rooms' => $rooms
        ]);
    }

    public function deleteSubdivision($id): void
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $subdivision = Subdivision::find($id);
        if (!$subdivision) {
            app()->route->redirect('/subdivisions?message=Подразделение не найдено');
        }

        if ($subdivision->rooms()->count() > 0) {
            app()->route->redirect('/subdivisions?message=❌ Нельзя удалить: сначала удалите все помещения');
            return;
        }

        if ($subdivision->subscribers()->count() > 0) {
            app()->route->redirect('/subdivisions?message=❌ Нельзя удалить: сначала удалите всех абонентов');
            return;
        }

        $subdivision->delete();
        app()->route->redirect('/subdivisions?message=Подразделение удалено');
    }

    public function deleteRoom($id): void
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $room = Room::find($id);
        if (!$room) {
            app()->route->redirect('/rooms?message=Помещение не найдено');
        }

        if ($room->phones()->count() > 0) {
            app()->route->redirect('/rooms?message=❌ Нельзя удалить: сначала удалите все телефоны');
            return;
        }

        $room->delete();
        app()->route->redirect('/rooms?message=Помещение удалено');
    }

    public function deletePhone($id): void
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $phone = Phone::find($id);
        if ($phone) {
            $phone->delete();
            app()->route->redirect('/phones?message=Телефон удален');
        } else {
            app()->route->redirect('/phones?message=Телефон не найден');
        }
    }

    public function deleteSubscriber($id): void
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $subscriber = Subscriber::find($id);
        if ($subscriber) {
            $subscriber->delete();
            app()->route->redirect('/subscribers?message=Абонент удален');
        } else {
            app()->route->redirect('/subscribers?message=Абонент не найден');
        }
    }

    // ==================== ДОСТУПНО ТОЛЬКО ДЛЯ АДМИНИСТРАТОРА ====================

    public function createSysAdmin(Request $request): string
    {
        if (!$this->isAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен. Требуются права администратора.');
        }

        if ($request->method === 'POST') {
            $existingUser = User::where('login', $request->get('login'))->first();
            if ($existingUser) {
                return new View('site.create_sysadmin', ['error' => 'Пользователь с таким логином уже существует!']);
            }

            $data = $request->all();
            $data['id_role'] = 1;
            $data['password'] = md5($data['password']);

            if (User::create($data)) {
                app()->route->redirect('/admin/sysadmins?message=Системный администратор создан');
            }
        }
        return new View('site.create_sysadmin');
    }

    public function listSysAdmins(): string
    {
        if (!$this->isAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $sysAdmins = User::where('id_role', 1)->get();
        return new View('site.list_sysadmins', ['sysAdmins' => $sysAdmins]);
    }

    // Редактирование системного администратора
    public function editSysAdmin($id, Request $request): string
    {
        if (!$this->isAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $sysAdmin = User::where('id_role', 1)->where('id_user', $id)->first();

        if (!$sysAdmin) {
            app()->route->redirect('/?message=Системный администратор не найден');
        }

        if ($request->method === 'POST') {
            $data = $request->all();

            if ($data['login'] !== $sysAdmin->login) {
                $existingUser = User::where('login', $data['login'])->first();
                if ($existingUser) {
                    return new View('site.edit_sysadmin', [
                        'sysAdmin' => $sysAdmin,
                        'error' => 'Пользователь с таким логином уже существует!'
                    ]);
                }
            }

            $sysAdmin->name = $data['name'];
            $sysAdmin->login = $data['login'];

            if (!empty($data['password'])) {
                $sysAdmin->password = md5($data['password']);
            }

            $sysAdmin->save();
            app()->route->redirect('/?message=Системный администратор обновлён');
        }

        return new View('site.edit_sysadmin', ['sysAdmin' => $sysAdmin]);
    }

    public function deleteSysAdmin($id): void
    {
        if (!$this->isAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        if ($id == Auth::user()->id_user) {
            app()->route->redirect('/?message=❌ Нельзя удалить самого себя');
            return;
        }

        $sysAdmin = User::where('id_role', 1)->where('id_user', $id)->first();

        if ($sysAdmin) {
            $sysAdmin->delete();
            app()->route->redirect('/?message=Системный администратор удалён');
        } else {
            app()->route->redirect('/?message=Системный администратор не найден');
        }
    }
}