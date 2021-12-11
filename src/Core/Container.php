<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Contracts\ContainerInterface;
use App\Core\Exceptions\ContainerEntryNotFound;
use App\Core\Exceptions\ContainerException;

class Container implements ContainerInterface
{
    private array $bindings;

    private array $instances;

    /**
     * {@inheritdoc}
     */
    public function get(string $id): mixed
    {
        try {
            return $this->resolve($id);
        } catch (\Throwable $e) {
            if ($this->has($id) || $e instanceof ContainerException) {
                throw $e;
            }

            throw new ContainerEntryNotFound($id, $e->getCode(), $e);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $id): bool
    {
        if(isset($this->bindings[$id]) || isset($this->instances[$id])) {
            return true;
        }

        throw new ContainerEntryNotFound($id, '1');
    }

    private function resolve(string $id): mixed
    {
        return true;
    }
}