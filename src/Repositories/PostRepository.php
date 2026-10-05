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
            pc.category_id,
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
        ORDER BY
            p.published_at DESC,
            p.id DESC,
            pc.position
    ";

    $statement = $this->pdo->prepare($sql);

    $parameters = [$postId, ...$categoryIds];

    foreach ($parameters as $index => $parameter) {
        $statement->bindValue(
            $index + 1,
            $parameter,
            PDO::PARAM_INT
        );
    }

    $statement->execute();

    $rows = $statement->fetchAll();

    if ($rows === []) {
        return [];
    }

    $candidates = [];

    foreach ($rows as $row) {
        $candidateId = (int) $row['id'];

        if (!isset($candidates[$candidateId])) {
            $candidates[$candidateId] = [
                'id' => $candidateId,
                'image' => $row['image'],
                'title' => $row['title'],
                'description' => $row['description'],
                'views' => (int) $row['views'],
                'published_at' => $row['published_at'],
                'category_name' => $row['category_name'],
                'category_ids' => [],
            ];
        }

        $candidates[$candidateId]['category_ids'][] =
            (int) $row['category_id'];
    }

    foreach ($candidates as &$candidate) {
        $candidate['match_level'] = 0;
        $candidate['priority'] = PHP_INT_MAX;

        foreach ($categoryIds as $priority => $categoryId) {
            if (!in_array(
                $categoryId,
                $candidate['category_ids'],
                true
            )) {
                continue;
            }

            $candidate['match_level']++;

            if ($candidate['priority'] === PHP_INT_MAX) {
                $candidate['priority'] = $priority;
            }
        }
    }

    unset($candidate);

    usort(
        $candidates,
        static function (array $first, array $second): int {
            if ($first['match_level'] !== $second['match_level']) {
                return $second['match_level']
                    <=> $first['match_level'];
            }

            if ($first['priority'] !== $second['priority']) {
                return $first['priority']
                    <=> $second['priority'];
            }

            if ($first['published_at'] !== $second['published_at']) {
                return strcmp(
                    $second['published_at'],
                    $first['published_at']
                );
            }

            return $second['id'] <=> $first['id'];
        }
    );

    return array_slice($candidates, 0, $limit);
}

public function hasInvalidCategoryCombination(int $postId): bool
{
    $statement = $this->pdo->prepare(
        'SELECT COUNT(*)
         FROM post_categories pc
         INNER JOIN categories c
             ON c.id = pc.category_id
         WHERE pc.post_id = :post_id
           AND c.is_system = 1'
    );

    $statement->execute([
        'post_id' => $postId,
    ]);

    $systemCategoryCount = (int) $statement->fetchColumn();

    if ($systemCategoryCount === 0) {
        return false;
    }

    $statement = $this->pdo->prepare(
        'SELECT COUNT(*)
         FROM post_categories
         WHERE post_id = :post_id'
    );

    $statement->execute([
        'post_id' => $postId,
    ]);

    $categoryCount = (int) $statement->fetchColumn();

    return $categoryCount > 1;
}
}