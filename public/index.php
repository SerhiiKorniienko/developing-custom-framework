<?php

declare(strict_types=1);

require_once __DIR__ . '/../vendor/autoload.php';

use App\Controllers\AuthController;
use App\Controllers\ContactController;
use App\Core\Application;

$app = new Application(dirname(__DIR__));

$app->router->get('/', 'home');
$app->router->get('/contact', [ContactController::class, 'view']);
$app->router->post('/contact', [ContactController::class, "store"]);

$app->router->get('/login', [AuthController::class, 'viewLogin']);
$app->router->post('/login', [AuthController::class, 'handleLogin']);
$app->router->get('/register', [AuthController::class, 'viewRegister']);
$app->router->post('/register', [AuthController::class, 'handleRegister']);

$app->run();