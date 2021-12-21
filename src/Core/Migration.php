<?php

declare(strict_types=1);

namespace App\Core;

class Migration
{
    public static function applyMigrations(): void
    {
        self::createMigrationsTable();
        $alreadyApplied = self::getAppliedMigrations();
        $files = array_diff(scandir(app()->getRootPath() . '/database/migrations'), ['.', '..']);
        $toApply = array_diff($files, $alreadyApplied);
        $toStore = [];

        foreach ($toApply as $migration) {
            $migrationClassName = str_ends_with($migration, '.php') ? substr($migration, 0, -4) : null;

            if (! $migrationClassName) continue;

            require_once sprintf("%s/database/migrations/%s", app()->getRootPath(), $migration);

            $migrationToExecute = new $migrationClassName;
            $migrationToExecute->up(app()->db);

            self::log(sprintf("Executed migration: %s", $migration));
            $toStore[] = $migration;
        }

        if (! empty($toStore)) {
            self::storeExecutedMigrations($toStore);
        } else {
            self::log('Nothing to migrate');
        }
    }

    public static function createMigrationsTable(): void
    {
        app()->db->pdo->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            executed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );");
    }

    private static function getAppliedMigrations(): array
    {
        $statement = app()->db->pdo->prepare("SELECT migration FROM migrations");

        $statement->execute();

        return $statement->fetchAll(\PDO::FETCH_COLUMN);
    }

    private static function storeExecutedMigrations(array $toStore): void
    {
        $strToStore = implode(',', array_map(fn($m) => "('$m')", $toStore));

        $statement = app()->db->pdo->prepare("INSERT INTO migrations (migration) VALUES $strToStore");

        $statement->execute();
    }

    private static function log(string $message): void
    {
        echo sprintf("[%s] - %s" . PHP_EOL, date('Y-m-d H:i'), $message);
    }
}
