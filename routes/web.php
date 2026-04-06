<?php

use Src\Route;

// Публичные маршруты (доступны всем)
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);
Route::add('GET', '/hello', [Controller\Site::class, 'hello']);
Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup']);

// Главная после входа
Route::add('GET', '/', [Controller\Site::class, 'dashboard'])->middleware('auth');

// ========== ТОЛЬКО ДЛЯ СИСАДМИНА (id_role = 1) ==========
Route::add('GET', '/subscribers', [Controller\Site::class, 'subscribers'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/create', [Controller\Site::class, 'createSubscriber'])->middleware('auth');
Route::add(['GET', 'POST'], '/subscribers/attach-phone', [Controller\Site::class, 'attachPhone'])->middleware('auth');
Route::add(['GET', 'POST'], '/subdivisions', [Controller\Site::class, 'subdivisions'])->middleware('auth');
Route::add(['GET', 'POST'], '/rooms', [Controller\Site::class, 'rooms'])->middleware('auth');
Route::add(['GET', 'POST'], '/phones', [Controller\Site::class, 'phones'])->middleware('auth');
Route::add('GET', '/report/subdivision', [Controller\Site::class, 'reportBySubdivision'])->middleware('auth');
Route::add('GET', '/report/room', [Controller\Site::class, 'reportByRoom'])->middleware('auth');

// ========== ТОЛЬКО ДЛЯ АДМИНИСТРАТОРА (id_role = 2) ==========
Route::add(['GET', 'POST'], '/admin/create-sysadmin', [Controller\Site::class, 'createSysAdmin'])->middleware('auth');











