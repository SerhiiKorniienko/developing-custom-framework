<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Contracts\ContainerInterface;
use App\Core\Exceptions\ContainerEntryNotFound;
use App\Core\Exceptions\ContainerException;

class Container implements ContainerInterface
{
    private array $instances;

    public function addInstance($id, $concrete = null)
    {
        if (null === $concrete) {
            $concrete = $id;
        }

        $this->instances[$id] = $concrete;
    }

    /**
     * {@inheritdoc}
     * @throws \ReflectionException
     */
    public function get(string $id): object
    {
        if (!$this->has($id)) {
            $this->addInstance($id);
        }

        $concrete = $this->instances[$id];

        return $this->resolve($concrete);
    }

    /**
     * {@inheritdoc}
     */
    public function has(string $id): bool
    {
        return isset($this->instances[$id]);
    }

    /**
     * @throws ContainerException
     */
    private function resolve(string $concrete): object
    {
        try {
            $reflection = new \ReflectionClass($concrete);
        } catch (\ReflectionException $e) {
            throw new ContainerException("Class {$concrete} is not found.", 1, $e);
        }

        $constructor = $reflection->getConstructor();
        if (is_null($constructor)) {
            return $reflection->newInstance();
        }

        $parameters = $constructor->getParameters();
        $dependencies = $this->getDependencies($parameters);

        return $reflection->newInstanceArgs($dependencies);
    }

    /**
     * @throws ContainerException
     */
    private function getDependencies(array $parameters): array
    {
        $dependencies = [];

        /** @var \ReflectionParameter $parameter */
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getType();

            if (is_null($dependency)) {
                if ($parameter->isDefaultValueAvailable()) {
                    $dependencies[] = $parameter->getDefaultValue();
                } else {
                    throw new ContainerException(sprintf("Can not resolve class dependency [%s]", $parameter->name));
                }
            } else {
                $dependencies[] = $this->get($dependency->getName());
            }
        }

        return $dependencies;
    }
}