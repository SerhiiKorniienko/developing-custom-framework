<?php

declare(strict_types=1);

namespace App\Core\Contracts;

use App\Core\Exceptions\ContainerException;
use Psr\Container\NotFoundExceptionInterface;

interface ContainerInterface extends \Psr\Container\ContainerInterface
{
    /**
     * @throws NotFoundExceptionInterface
     * @throws ContainerException
     */
    public function get(string $id): mixed;

    public function has(string $id): bool;
}