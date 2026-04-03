<?php

use Src\Route;

// Главная страница (доступна авторизованным)
Route::add('GET', '/hello', [Controller\Site::class, 'hello'])
    ->middleware('auth');

// Работа с абонентами (только для сисадминов и админов)
Route::add('GET', '/subscribers', [Controller\Site::class, 'subscribers'])
    ->middleware('auth');

// Регистрация доступна только Администратору (роль 'admin')
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup'])
    ->middleware('auth', 'admin');

Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);