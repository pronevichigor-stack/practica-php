<?php

namespace Controller;

use Src\View;
use Src\Request;
use Model\User;
use Model\Subscriber;
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
            // Пытаемся создать пользователя с данными из формы
            if (User::create($request->all())) {
                // Если успешно — идем на главную
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

        // Пытаемся авторизовать
        if (Auth::attempt($request->all())) {
            app()->route->redirect('/hello');
        }

        // Если данные не подошли
        return new View('site.login', ['message' => 'Ошибка: Неверный логин или пароль']);
    }

    public function logout(): void
    {
        Auth::logout();
        app()->route->redirect('/login');
    }

    // Метод для отображения списка абонентов
    public function subscribers(): string
    {
        // В реальной БД тут будет Subscriber::all();
        // Пока передаем пустой массив, чтобы страница не падала
        return new View('site.subscribers', ['subscribers' => []]);
    }
}