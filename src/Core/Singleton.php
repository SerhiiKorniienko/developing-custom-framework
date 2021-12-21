<?php

declare(strict_types=1);

namespace App\Core;

class Singleton extends Container
{
    private static array $instances = [];

    private function __construct() { /** @return Application */ }

    private function __clone() { /** @return Application */ }

    public static function getInstance(): static
    {
        $subclass = static::class;

        if (! isset(static::$instances[$subclass])) {
            self::$instances[$subclass] = new static();
        }

        return self::$instances[$subclass];
    }
}
