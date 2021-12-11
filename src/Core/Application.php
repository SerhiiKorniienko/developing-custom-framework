<?php

declare(strict_types=1);

namespace App\Core;

class Application
{
    public static string $ROOT_DIR;

    public BaseController $controller;

    public Router $router;

    public Request $request;

    public Response $response;

    public static Application $app;

    public function __construct(string $rootPath)
    {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;

        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->controller = new BaseController();
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}