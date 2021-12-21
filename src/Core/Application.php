<?php

declare(strict_types=1);

namespace App\Core;

use Dotenv\Dotenv;

final class Application extends Singleton
{
    private static string $ROOT_DIR;

    private array $config = [];

    private array $commands = [];

    public Router $router;

    public Database $db;

    public function setRootPath(string $rootPath): self
    {
        self::$ROOT_DIR = $rootPath;

        return $this;
    }

    public function getRootPath(): string
    {
        return self::$ROOT_DIR;
    }

    public function initConfig(string $configPath = null): self
    {
        $this->config = Dotenv::createImmutable($configPath ?? self::$ROOT_DIR)->load();

        return $this;
    }

    public function config(string $key = null): ?string
    {
        return isset($key) ? $this->getConfigItem($key) : null;
    }

    public function getConfigItem(?string $key): ?string
    {
        return array_key_exists($key, $this->config) ? $this->config[$key] : null;
    }

    public function initRouter(): self
    {
        $this->router = $this->get(Router::class);

        return $this;
    }

    public function initDatabase(): self
    {
        $this->db = Database::getInstance();

        $this->db->init([
            'dsn' => self::getConfigItem('DB_DSN'),
            'username' => self::getConfigItem('DB_USER'),
            'password' => self::getConfigItem('DB_PASSWORD'),
        ]);

        return $this;
    }

    public function addCommand(string $command)
    {
        $signature = $command::$signature;

        $this->commands[$signature] = $command;
    }

    public function resolveCommand(string $signature)
    {
        if (array_key_exists($signature, $this->commands)) {
            $command = $this->get($this->commands[$signature]);

            $command->execute();
        }
    }

    public function run()
    {
        echo $this->router->resolve();
    }
}
