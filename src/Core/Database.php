<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Database extends Singleton
{
    public PDO $pdo;

    public function init(array $config): self
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

        $this->pdo = new PDO($dsn, $username, $password);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $this;
    }
}
