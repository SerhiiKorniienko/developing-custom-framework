<?php

declare(strict_types=1);

namespace App\Core\ORM;

abstract class DatabaseModel
{
    abstract protected function getTableName(): string;

    abstract protected function getAttributes(): array;

    abstract protected function getAttributesMap(): array;

    abstract protected function getMappedAttributeValue(string $mappedKey): mixed;

    public function save(): mixed
    {
        $tableName = $this->getTableName();
        $attributes = implode(',', $this->getAttributes());
        $bindParams = implode(',', array_map(fn($attr) => ":$attr", $this->getAttributes()));

        $statement = $this->prepare("
            INSERT INTO $tableName ($attributes) VALUES ($bindParams); 
        ");

        foreach ($this->getAttributes() as $attribute) {
            $statement->bindValue(":$attribute", $this->getMappedAttributeValue($attribute));
        }

        return $statement->execute();
    }

    protected function prepare(string $sql): \PDOStatement
    {
        return app()->db->pdo->prepare($sql);
    }
}
