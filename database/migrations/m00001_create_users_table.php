<?php

declare(strict_types=1);

class m00001_create_users_table
{
    public function up(\App\Core\Database $connection)
    {
        $connection->pdo->exec("CREATE TABLE IF NOT EXISTS users (
                id INT AUTO_INCREMENT PRIMARY KEY,
                first_name VARCHAR(255) NOT NULL ,
                last_name VARCHAR(255) NOT NULL ,
                email VARCHAR(255) NOT NULL ,
                password_hash VARCHAR(255) NOT NULL ,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT NULL,
                deleted_at TIMESTAMP DEFAULT NULL
            );
        ");
    }

    public function down(\App\Core\Database $connection)
    {
        $connection->pdo->exec("DROP TABLE IF EXISTS users;");
    }
}
