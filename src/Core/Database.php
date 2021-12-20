<?php

declare(strict_types=1);

namespace App\Core;

use PDO;

class Database
{
    public PDO $pdo;

    public function __construct()
    {
        $dsn = $config['dsn'] ?? '';
        $username = $config['username'] ?? '';
        $password = $config['password'] ?? '';

//        $this->pdo = new PDO($dsn, $username, $password);
//        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}