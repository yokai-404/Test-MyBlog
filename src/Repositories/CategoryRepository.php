<?php

declare(strict_types=1);

final class CategoryRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function getAll(): array
    {
        $statement = $this->pdo->query(
            'SELECT
                id,
                name,
                description,
                is_system
             FROM categories
             ORDER BY name'
        );

        return $statement->fetchAll();
    }

    public function findByName(string $name): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                id,
                name,
                description,
                is_system
             FROM categories
             WHERE name = :name
             LIMIT 1'
        );

        $statement->execute([
            'name' => $name,
        ]);

        $category = $statement->fetch();

        return $category !== false ? $category : null;
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                id,
                name,
                description,
                is_system
             FROM categories
             WHERE id = :id
             LIMIT 1'
        );

        $statement->execute([
            'id' => $id,
        ]);

        $category = $statement->fetch();

        return $category !== false ? $category : null;
    }

    public function findSystemCategory(): ?array
{
    $statement = $this->pdo->query(
        'SELECT
            id,
            name,
            description,
            is_system
         FROM categories
         WHERE is_system = 1
         LIMIT 1'
    );

    $category = $statement->fetch();

    return $category !== false ? $category : null;
}
}