<?php

declare(strict_types=1);

namespace App\Core;

class Application
{
    public static string $ROOT_DIR;

    public static Application $app;

    public function __construct(
        public Request        $request,
        public Response       $response,
        public BaseController $controller,
        public Router         $router
    )
    {
        self::$app = $this;

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