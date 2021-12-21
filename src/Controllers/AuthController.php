<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\BaseController;
use App\Core\Request;
use App\Models\RegisterModel;

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
            'model' => new RegisterModel(),
        ]);
    }

    public function handleRegister(Request $request): string
    {
        $model = RegisterModel::fromRequest($request);

        $model->validate();


        return $this->render('register', [
            'model' => $model,
        ]);
    }
}
