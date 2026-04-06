<?php

namespace Middlewares;

use Src\Auth\Auth;
use Src\Request;

class RoleMiddleware
{
    public function handle(Request $request, string $role)
    {
        if (!Auth::check()) {
            app()->route->redirect('/login');
        }

        $userRole = Auth::user()->role->name ?? '';

        if ($userRole !== $role) {
            app()->route->redirect('/hello?message=Доступ запрещен');
        }
    }
}