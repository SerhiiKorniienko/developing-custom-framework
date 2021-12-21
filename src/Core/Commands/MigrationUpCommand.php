<?php

declare(strict_types=1);

namespace App\Core\Commands;

use App\Core\BaseCommand;
use App\Core\Migration;

class MigrationUpCommand extends BaseCommand
{
    public static string $signature = 'migration:up';

    public function execute()
    {
        Migration::applyMigrations();
    }
}
