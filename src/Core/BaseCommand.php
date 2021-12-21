<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Contracts\Executable;

abstract class BaseCommand implements Executable
{
    public static string $signature;

    abstract public function execute();
}
