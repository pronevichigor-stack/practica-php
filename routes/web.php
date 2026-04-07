<?php

use Src\Route;

// Публичные маршруты
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);

// Главная
Route::add('GET', '/', [Controller\Site::class, 'dashboard'])->middleware('auth');

// Маршруты для сисадмина
Route::add('GET', '/subscribers', [Controller\Site::class, 'subscribers'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/create', [Controller\Site::class, 'createSubscriber'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/attach-phone', [Controller\Site::class, 'attachPhone'])->middleware('auth');
Route::add('GET', '/subscriber/delete/{id}', [Controller\Site::class, 'deleteSubscriber'])->middleware('auth');

Route::add(['GET', 'POST'], '/subdivisions', [Controller\Site::class, 'subdivisions'])->middleware('auth');
Route::add('GET', '/subdivision/delete/{id}', [Controller\Site::class, 'deleteSubdivision'])->middleware('auth');

Route::add(['GET', 'POST'], '/rooms', [Controller\Site::class, 'rooms'])->middleware('auth');
Route::add('GET', '/room/delete/{id}', [Controller\Site::class, 'deleteRoom'])->middleware('auth');

Route::add(['GET', 'POST'], '/phones', [Controller\Site::class, 'phones'])->middleware('auth');
Route::add('GET', '/phone/delete/{id}', [Controller\Site::class, 'deletePhone'])->middleware('auth');

Route::add('GET', '/report/subdivision', [Controller\Site::class, 'reportBySubdivision'])->middleware('auth');
Route::add('GET', '/report/room', [Controller\Site::class, 'reportByRoom'])->middleware('auth');

// Маршруты для администратора (упрощенные)
Route::add(['GET', 'POST'], '/admin/create-sysadmin', [Controller\Site::class, 'createSysAdmin'])->middleware('auth');
Route::add('GET', '/admin/sysadmins', [Controller\Site::class, 'dashboard'])->middleware('auth'); // Перенаправляем на главную
Route::add(['GET', 'POST'], '/admin/edit/{id}', [Controller\Site::class, 'editSysAdmin'])->middleware('auth');
Route::add('GET', '/admin/delete/{id}', [Controller\Site::class, 'deleteSysAdmin'])->middleware('auth');