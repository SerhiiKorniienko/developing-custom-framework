<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Core\Response;
use App\Models\User;

class AuthController extends BaseController
{
    public function viewLogin(): string
    {
        $this->setLayout('auth');

        return $this->render('login');
    }

    public function handleLogin(Request $request): string
    {
        return 'handle login data';
    }

    public function viewRegister(): string
    {
        $this->setLayout('auth');

        return $this->render('register', [
            'model' => new User(),
        ]);
    }

    public function handleRegister(Request $request): string
    {
        $user = User::fromRequest($request);

        if($user->validate() && $user->save()) {
            app()->session->setFlash('success', 'Thanks for registering');
            app()->router->response->redirect('/');
        }

        return $this->render('register', [
            'model' => $user,
        ]);
    }
}
