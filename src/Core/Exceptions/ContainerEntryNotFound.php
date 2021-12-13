<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

class ContainerEntryNotFound extends \Exception implements NotFoundExceptionInterface
{
}