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

    public function __construct(
        Request        $request,
        Response       $response,
        BaseController $baseController,
        Router         $router
    )
    {
        self::$app = $this;

        $this->request = $request;
        $this->response = $response;
        $this->router = $router;
        $this->controller = $baseController;

        return $this;
    }

    public function setRootPath(string $rootPath)
    {
        self::$ROOT_DIR = $rootPath;
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}