<?php

declare(strict_types=1);

require_once __DIR__ . '/../src/Database/Connection.php';

$pdo = Connection::get();

$pdo->exec(
    <<<'SQL'
    CREATE TABLE IF NOT EXISTS migrations (
        id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        migration VARCHAR(255) NOT NULL,
        executed_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

        UNIQUE KEY uq_migrations_migration (migration)
    ) ENGINE=InnoDB
      DEFAULT CHARSET=utf8mb4
      COLLATE=utf8mb4_unicode_ci
    SQL
);

$migrationsPath = __DIR__ . '/migrations';

$files = glob($migrationsPath . '/*.sql');

sort($files, SORT_STRING);

foreach ($files as $file) {
    $migration = basename($file);

    $statement = $pdo->prepare(
        'SELECT COUNT(*) FROM migrations WHERE migration = :migration'
    );

    $statement->execute([
        'migration' => $migration,
    ]);

    $alreadyExecuted = (int) $statement->fetchColumn() > 0;

    if ($alreadyExecuted) {
        echo "Skipped: {$migration}" . PHP_EOL;
        continue;
    }

    echo "Running: {$migration}" . PHP_EOL;

    $sql = file_get_contents($file);

    if ($sql === false) {
        throw new RuntimeException(
            "Unable to read migration: {$migration}"
        );
    }

    try {
        $pdo->beginTransaction();

        $pdo->exec($sql);

        $statement = $pdo->prepare(
            'INSERT INTO migrations (migration) VALUES (:migration)'
        );

        $statement->execute([
            'migration' => $migration,
        ]);

        $pdo->commit();

        echo "Completed: {$migration}" . PHP_EOL;
    } catch (Throwable $exception) {
        if ($pdo->inTransaction()) {
            $pdo->rollBack();
        }

        echo "Failed: {$migration}" . PHP_EOL;

        throw $exception;
    }
}

echo 'All migrations are up to date.' . PHP_EOL;