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
            // Проверка на уникальность логина
            $existingUser = User::where('login', $data['login'])->first();
            if ($existingUser) {
                return new View('site.signup', ['error' => 'Пользователь с таким логином уже существует!']);
            }
            $data['id_role'] = 1; // По умолчанию sysadmin
            $data['password'] = md5($data['password']); // Хешируем пароль
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

    // Проверка, является ли пользователь системным администратором (role = sysadmin, id_role = 1)
    private function isSysAdmin(): bool
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return $user->id_role == 1;
    }

    // Проверка, является ли пользователь администратором (role = admin, id_role = 2)
    private function isAdmin(): bool
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        return $user->id_role == 2;
    }

    // ==================== ДОСТУПНО ТОЛЬКО ДЛЯ СИСАДМИНА ====================

    // Список абонентов с фильтром по подразделению
    public function subscribers(Request $request): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $query = Subscriber::with('subdivision', 'phones');

        // Фильтр по подразделению
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

    // Форма добавления нового абонента
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

    // Привязка телефона к абоненту
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

    // Отчет: количество абонентов по подразделениям
    public function reportBySubdivision(): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $subdivisions = Subdivision::withCount('subscribers')->get();
        return new View('site.report_subdivision', ['subdivisions' => $subdivisions]);
    }

    // Отчет: количество телефонов по помещениям
    public function reportByRoom(): string
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $rooms = Room::withCount('phones')->get();
        return new View('site.report_room', ['rooms' => $rooms]);
    }

    // Управление подразделениями
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
        $types = TypeOfUnit::all(); // Нужно добавить эту модель

        return new View('site.subdivisions', [
            'subdivisions' => $subdivisions,
            'types' => $types
        ]);
    }

// Управление помещениями
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
    // Управление телефонами
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

    // ==================== ДОСТУПНО ТОЛЬКО ДЛЯ АДМИНИСТРАТОРА ====================

    // Создание нового сисадмина (только для администратора)
    public function createSysAdmin(Request $request): string
    {
        if (!$this->isAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен. Требуются права администратора.');
        }

        if ($request->method === 'POST') {
            // Проверка на уникальность логина
            $existingUser = User::where('login', $request->get('login'))->first();
            if ($existingUser) {
                return new View('site.create_sysadmin', ['error' => 'Пользователь с таким логином уже существует!']);
            }

            $data = $request->all();
            $data['id_role'] = 1; // id_role = 1 для sysadmin
            $data['password'] = md5($data['password']); // Хешируем пароль

            if (User::create($data)) {
                app()->route->redirect('/hello?message=Системный администратор создан. Логин: ' . $data['login']);
            }
        }
        return new View('site.create_sysadmin');
    }
// Удаление подразделения
    public function deleteSubdivision($id): void
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $subdivision = Subdivision::find($id);
        if ($subdivision) {
            $subdivision->delete();
            app()->route->redirect('/subdivisions?message=Подразделение удалено');
        } else {
            app()->route->redirect('/subdivisions?message=Подразделение не найдено');
        }
    }

// Удаление помещения
    public function deleteRoom($id): void
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $room = Room::find($id);
        if ($room) {
            // Сначала удаляем связанные телефоны
            foreach ($room->phones as $phone) {
                $phone->subscribers()->detach();
                $phone->delete();
            }
            $room->delete();
            app()->route->redirect('/rooms?message=Помещение удалено');
        } else {
            app()->route->redirect('/rooms?message=Помещение не найдено');
        }
    }

// Удаление телефона
    public function deletePhone($id): void
    {
        if (!$this->isSysAdmin()) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }

        $phone = Phone::find($id);
        if ($phone) {
            // Отвязываем от абонентов
            $phone->subscribers()->detach();
            $phone->delete();
            app()->route->redirect('/phones?message=Телефон удален');
        } else {
            app()->route->redirect('/phones?message=Телефон не найден');
        }
    }
}