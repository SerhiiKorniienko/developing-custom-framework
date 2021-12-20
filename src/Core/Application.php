<?php

declare(strict_types=1);

namespace App\Core;

use Dotenv\Dotenv;

final class Application extends Container
{
    public static string $ROOT_DIR;

    /**
     * @var null[]|string[]
     */
    private array $config;

    public Router $router;

    private static self $instance;

    private function __construct()
    {
        /** @return Application */
    }

    private function __clone()
    {
        /** @return Application */
    }

    private function __wakeup()
    {
        /** @return Application */
    }

    public static function getInstance(): self
    {
        if (! isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function setRootPath(string $rootPath): self
    {
        self::$ROOT_DIR = $rootPath;

        return $this;
    }

    public function initConfig(string $configPath = null): self
    {
        $this->config = Dotenv::createImmutable($configPath ?? self::$ROOT_DIR)->load();

        return $this;
    }

    public function config($key = null): string|array|null
    {
        return $this->config[$key] ?? $this->config;
    }

    public function initRouter(): self
    {
        $this->router = $this->get(Router::class);

        return $this;
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}