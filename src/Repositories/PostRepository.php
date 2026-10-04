<?php

declare(strict_types=1);

final class PostRepository
{
    public function __construct(
        private PDO $pdo
    ) {
    }

    public function findById(int $id): ?array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                id,
                image,
                title,
                description,
                content,
                views,
                published_at,
                updated_at
             FROM posts
             WHERE id = :id
             LIMIT 1'
        );

        $statement->execute([
            'id' => $id,
        ]);

        $post = $statement->fetch();

        if ($post === false) {
            return null;
        }

        $post['categories'] = $this->getCategories($id);

        return $post;
    }

    public function incrementViews(int $id): void
    {
        $statement = $this->pdo->prepare(
            'UPDATE posts
             SET views = views + 1
             WHERE id = :id'
        );

        $statement->execute([
            'id' => $id,
        ]);
    }

    public function getCategories(int $postId): array
    {
        $statement = $this->pdo->prepare(
            'SELECT
                c.id,
                c.name,
                c.description,
                c.is_system,
                pc.position
             FROM post_categories pc
             INNER JOIN categories c
                 ON c.id = pc.category_id
             WHERE pc.post_id = :post_id
             ORDER BY pc.position'
        );

        $statement->execute([
            'post_id' => $postId,
        ]);

        return $statement->fetchAll();
    }

    public function getLatestByCategory(
        int $categoryId,
        int $limit = 3
    ): array {
        $statement = $this->pdo->prepare(
            'SELECT
                p.id,
                p.image,
                p.title,
                p.description,
                p.views,
                p.published_at,
                p.updated_at
             FROM posts p
             INNER JOIN post_categories pc
                 ON pc.post_id = p.id
             WHERE pc.category_id = :category_id
             ORDER BY p.published_at DESC, p.id DESC
             LIMIT :limit'
        );

        $statement->bindValue(':category_id', $categoryId, PDO::PARAM_INT);
        $statement->bindValue(':limit', $limit, PDO::PARAM_INT);

        $statement->execute();

        return $statement->fetchAll();
    }

    public function countByCategory(int $categoryId): int
    {
        $statement = $this->pdo->prepare(
            'SELECT COUNT(*)
             FROM post_categories
             WHERE category_id = :category_id'
        );

        $statement->execute([
            'category_id' => $categoryId,
        ]);

        return (int) $statement->fetchColumn();
    }

    public function getByCategory(
        int $categoryId,
        int $limit,
        int $offset,
        string $sort,
        string $direction
    ): array {
        $allowedSorts = [
            'date' => 'p.published_at',
            'views' => 'p.views',
        ];

        if (!isset($allowedSorts[$sort])) {
            throw new InvalidArgumentException('Invalid sort field.');
        }

        $direction = strtoupper($direction);

        if (!in_array($direction, ['ASC', 'DESC'], true)) {
            throw new InvalidArgumentException('Invalid sort direction.');
        }

        $orderBy = $allowedSorts[$sort];

        $sql = "
            SELECT
                p.id,
                p.image,
                p.title,
                p.description,
                p.views,
                p.published_at,
                p.updated_at
            FROM posts p
            INNER JOIN post_categories pc
                ON pc.post_id = p.id
            WHERE pc.category_id = :category_id
            ORDER BY {$orderBy} {$direction}, p.id DESC
            LIMIT :limit OFFSET :offset
        ";

        $statement = $this->pdo->prepare($sql);

        $statement->bindValue(
            ':category_id',
            $categoryId,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':limit',
            $limit,
            PDO::PARAM_INT
        );

        $statement->bindValue(
            ':offset',
            $offset,
            PDO::PARAM_INT
        );

        $statement->execute();

        return $statement->fetchAll();
    }

public function getSimilar(
    int $postId,
    array $categories,
    int $limit = 3
): array {
    if ($categories === []) {
        return [];
    }

    $categoryIds = array_map(
        static fn(array $category): int => (int) $category['id'],
        $categories
    );

    $placeholders = implode(
        ', ',
        array_fill(0, count($categoryIds), '?')
    );

    $sql = "
        SELECT
            p.id,
            p.image,
            p.title,
            p.description,
            p.views,
            p.published_at,
            COUNT(DISTINCT pc.category_id) AS matched_categories,
            (
                SELECT c.name
                FROM post_categories pc2
                INNER JOIN categories c
                    ON c.id = pc2.category_id
                WHERE pc2.post_id = p.id
                ORDER BY pc2.position
                LIMIT 1
            ) AS category_name
        FROM posts p
        INNER JOIN post_categories pc
            ON pc.post_id = p.id
        WHERE p.id <> ?
          AND pc.category_id IN ({$placeholders})
        GROUP BY
            p.id,
            p.image,
            p.title,
            p.description,
            p.views,
            p.published_at
        ORDER BY
            matched_categories DESC,
            p.published_at DESC,
            p.id DESC
        LIMIT ?
    ";

    $statement = $this->pdo->prepare($sql);

    $parameters = [$postId, ...$categoryIds, $limit];

    foreach ($parameters as $index => $parameter) {
        $statement->bindValue(
            $index + 1,
            $parameter,
            PDO::PARAM_INT
        );
    }

    $statement->execute();

    return $statement->fetchAll();
}
}