<?php

use Src\Route;

// ==================== ПУБЛИЧНЫЕ МАРШРУТЫ (доступны всем) ====================
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);

// ==================== ГЛАВНАЯ ПОСЛЕ ВХОДА ====================
Route::add('GET', '/', [Controller\Site::class, 'dashboard'])->middleware('auth');

// ==================== МАРШРУТЫ ДЛЯ СИСТЕМНОГО АДМИНИСТРАТОРА (id_role = 1) ====================

// Абоненты
Route::add('GET', '/subscribers', [Controller\Site::class, 'subscribers'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/create', [Controller\Site::class, 'createSubscriber'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/attach-phone', [Controller\Site::class, 'attachPhone'])->middleware('auth');

// Подразделения
Route::add(['GET', 'POST'], '/subdivisions', [Controller\Site::class, 'subdivisions'])->middleware('auth');

// Помещения
Route::add(['GET', 'POST'], '/rooms', [Controller\Site::class, 'rooms'])->middleware('auth');

// Телефоны
Route::add(['GET', 'POST'], '/phones', [Controller\Site::class, 'phones'])->middleware('auth');

// Отчеты
Route::add('GET', '/report/subdivision', [Controller\Site::class, 'reportBySubdivision'])->middleware('auth');
Route::add('GET', '/report/room', [Controller\Site::class, 'reportByRoom'])->middleware('auth');

// Удаление (опционально)
Route::add('GET', '/subdivision/delete/{id}', [Controller\Site::class, 'deleteSubdivision'])->middleware('auth');
Route::add('GET', '/room/delete/{id}', [Controller\Site::class, 'deleteRoom'])->middleware('auth');
Route::add('GET', '/phone/delete/{id}', [Controller\Site::class, 'deletePhone'])->middleware('auth');

// ==================== МАРШРУТЫ ДЛЯ АДМИНИСТРАТОРА (id_role = 2) ====================
Route::add(['GET', 'POST'], '/admin/create-sysadmin', [Controller\Site::class, 'createSysAdmin'])->middleware('auth');






