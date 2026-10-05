<?php

declare(strict_types=1);

require_once __DIR__ . '/../../src/Database/Connection.php';

$pdo = Connection::get();

$pdo->beginTransaction();

try {
    // Очистка данных перед повторным запуском seed.
    $pdo->exec('DELETE FROM post_categories');
    $pdo->exec('DELETE FROM posts');
    $pdo->exec('DELETE FROM categories');

    $categories = [
        [
            'name' => 'Мир',
            'description' => 'Новости и события в разных уголках мира.',
            'is_system' => 0,
        ],
        [
            'name' => 'Природа',
            'description' => 'Природа, животные, окружающая среда и экология.',
            'is_system' => 0,
        ],
        [
            'name' => 'Технологии',
            'description' => 'Современные технологии, интернет и цифровой мир.',
            'is_system' => 0,
        ],
        [
            'name' => 'Наука',
            'description' => 'Научные открытия, исследования и интересные факты.',
            'is_system' => 0,
        ],
        [
            'name' => 'Путешествия',
            'description' => 'Путешествия, города, страны и интересные места.',
            'is_system' => 0,
        ],
        [
            'name' => 'Культура',
            'description' => 'Искусство, литература, кино и культурные события.',
            'is_system' => 0,
        ],
        [
            'name' => 'Спорт',
            'description' => 'Спортивные события, соревнования и достижения.',
            'is_system' => 0,
        ],
        [
            'name' => 'Общество',
            'description' => 'Люди, общество и актуальные социальные темы.',
            'is_system' => 0,
        ],
        [
            'name' => 'История',
            'description' => 'Исторические события, личности и эпохи.',
            'is_system' => 0,
        ],
        [
            'name' => 'Еда',
            'description' => 'Кулинария, продукты, рецепты и гастрономия.',
            'is_system' => 0,
        ],
        [
            'name' => 'Без категории',
            'description' => 'Статьи без определённой категории.',
            'is_system' => 1,
            // Системная категория.
            // Должна использоваться отдельно и не может сочетаться с другими категориями статьи.
        ],
    ];

    $categoryStatement = $pdo->prepare(
        'INSERT INTO categories (name, description, is_system)
         VALUES (:name, :description, :is_system)'
    );

    $categoryIds = [];

    foreach ($categories as $category) {
        $categoryStatement->execute($category);

        $categoryIds[$category['name']] = (int) $pdo->lastInsertId();
    }

    $posts = [
        [
            'title' => 'Как меняется современный мир',
            'description' => 'Краткий обзор главных изменений, происходящих в мире.',
            'content' => 'Современный мир постоянно меняется. Технологии, экономика и общество влияют друг на друга и формируют новые тенденции.',
            'views' => 125,
            'published_at' => '2026-09-01 10:00:00',
            'categories' => ['Мир', 'Общество'],
        ],
        [
            'title' => 'Почему леса важны для планеты',
            'description' => 'Роль лесов в сохранении природы и климата.',
            'content' => 'Леса являются важнейшей частью экосистемы планеты. Они поддерживают биоразнообразие и участвуют в естественном круговороте углерода.',
            'views' => 210,
            'published_at' => '2026-09-05 12:00:00',
            'categories' => ['Природа', 'Наука'],
        ],
        [
            'title' => 'Технологии, которые меняют нашу жизнь',
            'description' => 'Несколько технологий, которые уже стали частью повседневной жизни.',
            'content' => 'Цифровые технологии давно перестали быть чем-то необычным. Они помогают людям работать, учиться, путешествовать и общаться.',
            'views' => 340,
            'published_at' => '2026-09-10 09:30:00',
            'categories' => ['Технологии'],
        ],
        [
            'title' => 'Интересные места для путешествий',
            'description' => 'Идеи для будущих путешествий и новых впечатлений.',
            'content' => 'Путешествия позволяют увидеть новые культуры, познакомиться с людьми и получить впечатления, которые остаются на всю жизнь.',
            'views' => 180,
            'published_at' => '2026-09-15 14:00:00',
            'categories' => ['Путешествия', 'Культура'],
        ],
        [
            'title' => 'Как наука изучает космос',
            'description' => 'Современные методы исследования Вселенной.',
            'content' => 'Изучение космоса помогает человечеству лучше понимать происхождение Вселенной, планет и звёзд.',
            'views' => 290,
            'published_at' => '2026-09-20 16:00:00',
            'categories' => ['Наука', 'Мир'],
        ],
        [
            'title' => 'История больших спортивных соревнований',
            'description' => 'Как развивались крупнейшие спортивные события.',
            'content' => 'Спортивные соревнования прошли длинный путь от локальных состязаний до масштабных международных событий.',
            'views' => 95,
            'published_at' => '2026-09-22 11:00:00',
            'categories' => ['Спорт', 'История'],
        ],
        [
            'title' => 'Кино как часть современной культуры',
            'description' => 'Почему кино продолжает влиять на общество.',
            'content' => 'Кино отражает изменения в обществе и одновременно само влияет на взгляды людей, формируя новые культурные явления.',
            'views' => 155,
            'published_at' => '2026-09-25 18:00:00',
            'categories' => ['Культура', 'Общество'],
        ],
        [
            'title' => 'Простые правила хорошего питания',
            'description' => 'Несколько общих принципов сбалансированного питания.',
            'content' => 'Разнообразный рацион, умеренность и внимание к качеству продуктов являются основой разумного подхода к питанию.',
            'views' => 275,
            'published_at' => '2026-09-27 13:00:00',
            'categories' => ['Еда'],
        ],
        [
            'title' => 'Один день без интернета',
            'description' => 'Небольшой эксперимент над привычным цифровым образом жизни.',
            'content' => 'Иногда полезно на время отказаться от цифровых сервисов и посмотреть, сколько времени появляется для других занятий.',
            'views' => 70,
            'published_at' => '2026-09-28 15:00:00',
            'categories' => ['Технологии', 'Общество'],
        ],
        [
            'title' => 'Необычные факты о нашей планете',
            'description' => 'Несколько интересных фактов о Земле.',
            'content' => 'Наша планета намного интереснее, чем может показаться на первый взгляд. Её история хранит множество необычных фактов.',
            'views' => 320,
            'published_at' => '2026-09-29 10:30:00',
            'categories' => ['Мир', 'Природа', 'Наука'],
        ],
        [
            'title' => 'Зачем сохранять историческое наследие',
            'description' => 'Почему память о прошлом важна для будущего.',
            'content' => 'Историческое наследие помогает обществу понимать собственное прошлое и сохранять знания для следующих поколений.',
            'views' => 110,
            'published_at' => '2026-09-30 17:00:00',
            'categories' => ['История', 'Культура'],
        ],
        [
            'title' => 'Большие города и зелёные пространства',
            'description' => 'Как городская среда может сосуществовать с природой.',
            'content' => 'Парки, скверы и другие зелёные пространства делают города комфортнее и помогают сохранять связь человека с природой.',
            'views' => 135,
            'published_at' => '2026-10-01 09:00:00',
            'categories' => ['Природа', 'Общество'],
        ],
    ];

    $postStatement = $pdo->prepare(
        'INSERT INTO posts (
            image,
            title,
            description,
            content,
            views,
            published_at,
            updated_at
        ) VALUES (
            :image,
            :title,
            :description,
            :content,
            :views,
            :published_at,
            :updated_at
        )'
    );

    $categoryStatement = $pdo->prepare(
        'INSERT INTO post_categories (post_id, category_id, position)
         VALUES (:post_id, :category_id, :position)'
    );

    foreach ($posts as $post) {
        $postStatement->execute([
            'image' => null,
            'title' => $post['title'],
            'description' => $post['description'],
            'content' => $post['content'],
            'views' => $post['views'],
            'published_at' => $post['published_at'],
            'updated_at' => $post['published_at'],
        ]);

        $postId = (int) $pdo->lastInsertId();

        foreach ($post['categories'] as $position => $categoryName) {
            $categoryStatement->execute([
                'post_id' => $postId,
                'category_id' => $categoryIds[$categoryName],
                'position' => $position + 1,
            ]);
        }
    }

    $pdo->commit();

    echo 'Seed completed successfully.' . PHP_EOL;
} catch (Throwable $exception) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }

    echo 'Seed failed.' . PHP_EOL;
    throw $exception;
}