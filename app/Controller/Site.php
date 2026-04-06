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

class Site
{
    public function hello(): string
    {
        return new View('site.hello', ['message' => 'Добро пожаловать в систему учета абонентов']);
    }

    public function signup(Request $request): string
    {
        if ($request->method === 'POST') {
            $data = $request->all();
            // По умолчанию создаем пользователя с ролью sysadmin (id_role = 1)
            $data['id_role'] = 1;
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
            app()->route->redirect('/hello');
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
        // В вашей БД: id_role = 1 -> sysadmin
        return $user->id_role == 1;
    }

    // Проверка, является ли пользователь администратором (role = admin, id_role = 2)
    private function isAdmin(): bool
    {
        if (!Auth::check()) return false;
        $user = Auth::user();
        // В вашей БД: id_role = 2 -> admin
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
        if ($request->subdivision_id && $request->subdivision_id !== '') {
            $query->where('subdivision_id', $request->subdivision_id);
        }

        $subscribers = $query->get();
        $subdivisions = Subdivision::all();

        return new View('site.subscribers', [
            'subscribers' => $subscribers,
            'subdivisions' => $subdivisions,
            'selectedSubdivision' => $request->subdivision_id
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
            $data['created_by'] = Auth::user()->id_user; // Кто создал
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
            $subscriber = Subscriber::find($request->subscriber_id);
            if ($subscriber && $request->phone_id) {
                $subscriber->phones()->attach($request->phone_id);
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
            Subdivision::create($request->all());
            app()->route->redirect('/subdivisions?message=Подразделение добавлено');
        }

        $subdivisions = Subdivision::all();
        return new View('site.subdivisions', ['subdivisions' => $subdivisions]);
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

        $phones = Phone::with('room')->get();
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
            $data = $request->all();
            $data['id_role'] = 1; // id_role = 1 для sysadmin
            if (User::create($data)) {
                app()->route->redirect('/hello?message=Системный администратор создан');
            }
        }
        return new View('site.create_sysadmin');
    }

    // ==================== ДОСТУПНО ВСЕМ АВТОРИЗОВАННЫМ ====================

    // Главная страница после входа (показывает меню в зависимости от роли)
    public function dashboard(): string
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }

        $user = Auth::user();
        return new View('site.dashboard', ['user' => $user]);
    }
}