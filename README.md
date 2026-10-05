# MyBlog

Простой блог на PHP с использованием MySQL, Smarty и SCSS.

Проект выполнен в рамках тестового задания. Приложение поддерживает работу как через Open Server, так и через Docker.

## Стек

* PHP 8.4
* MySQL 8.0
* Smarty 5
* Apache
* SCSS
* Docker / Docker Compose
* phpMyAdmin
* Composer
* npm / Sass

## Возможности

* Главная страница со всеми категориями, в которых есть статьи.
* По 3 последние статьи для каждой категории.
* Страница категории с пагинацией по 10 статей.
* Сортировка статей:

  * по дате публикации;
  * по количеству просмотров.
* Направление сортировки:

  * по возрастанию;
  * по убыванию.
* Страница отдельной статьи.
* Автоматическое увеличение количества просмотров при открытии статьи.
* Несколько категорий у одной статьи.
* Блок похожих статей.
* Категория «Без категории».
* Страница 404.
* Тестовые данные: 11 категорий и 100 статей.
* Адаптивная вёрстка.
* SCSS с разделением стилей по компонентам и страницам.
* Docker-окружение с PHP, MySQL и phpMyAdmin.

## Структура проекта

```text
my_blog/
├── database/
│   ├── migrations/
│   │   ├── 001_create_tables.sql
│   │   ├── 002_add_system_flag_to_categories.sql
│   │   └── 003_add_status_to_migrations.sql
│   ├── seeders/
│   │   └── seed.php
│   └── migrate.php
│
├── public/
│   ├── assets/
│   │   ├── css/
│   │   └── images/
│   ├── .htaccess
│   └── index.php
│
├── resources/
│   └── scss/
│       ├── _base.scss
│       ├── _buttons.scss
│       ├── _cards.scss
│       ├── _category.scss
│       ├── _error.scss
│       ├── _footer.scss
│       ├── _header.scss
│       ├── _home.scss
│       ├── _layout.scss
│       ├── _pagination.scss
│       ├── _post.scss
│       ├── _variables.scss
│       └── style.scss
│
├── src/
│   ├── Controllers/
│   ├── Database/
│   ├── Repositories/
│   └── ...
│
├── templates/
│   ├── category/
│   ├── home/
│   ├── post/
│   └── ...
│
├── Dockerfile
├── docker-compose.yml
├── composer.json
├── package.json
├── .env.example
└── README.md
```

## База данных

Используются следующие основные таблицы:

### `categories`

Хранит категории статей.

Основные поля:

* `id`
* `name`
* `description`
* `is_system`
* `created_at`

### `posts`

Хранит статьи.

Основные поля:

* `id`
* `image`
* `title`
* `description`
* `content`
* `views`
* `published_at`
* `updated_at`

### `post_categories`

Связывает статьи с категориями и позволяет назначать статье несколько категорий.

Основные поля:

* `post_id`
* `category_id`
* `position`

### `migrations`

Хранит информацию о применённых миграциях.

Миграции запускаются через:

```bash
php database/migrate.php
```

## Маршруты

### Главная

```text
/
```

Показывает категории, в которых есть статьи, и по 3 последние статьи каждой категории.

### Категория

```text
/category/{category}
```

Пример:

```text
/category/Технологии
```

Поддерживаются параметры:

```text
?page=2
&sort=date
&direction=desc
```

Также доступна сортировка по просмотрам:

```text
?sort=views&direction=desc
```

### Статья

```text
/category/{category}/post/{id}
```

Пример:

```text
/category/Технологии/post/15
```

При открытии статьи количество просмотров увеличивается на 1.

### 404

Для несуществующих страниц и ресурсов отображается отдельная страница 404.

## Похожие статьи

Для статьи выводится до 3 похожих материалов.

Поиск выполняется по категориям статьи с приоритетом:

1. статьи с совпадением всех категорий;
2. при отсутствии таких статей — совпадение по двум категориям;
3. далее поиск по отдельным категориям;
4. категории проверяются в порядке их приоритета у исходной статьи.

## Тестовые данные

Seed создаёт:

* 11 категорий;
* 100 статей;
* связи статей с категориями;
* изображения для тестовых статей.

В проекте также предусмотрена системная категория:

```text
Без категории
```

## Запуск через Open Server

### 1. Требования

Необходимы:

* Open Server;
* PHP 8.4;
* MySQL;
* Composer;
* Node.js и npm.

### 2. Клонирование проекта

```bash
git clone https://github.com/yokai-404/Test-MyBlog.git
cd my_blog
```

Для разработки используется ветка `develop`:

```bash
git checkout develop
```

### 3. Настройка `.env`

Создайте `.env` на основе `.env.example`:

```text
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=YOUR_BASE
DB_USERNAME=DB_USER
DB_PASSWORD=DB_PASSWORD
```

Укажите параметры локального MySQL.

### 4. Установка PHP-зависимостей

```bash
composer install
```

### 5. Создание структуры базы

```bash
php database/migrate.php
```

### 6. Заполнение тестовыми данными

```bash
php database/seeders/seed.php
```

### 7. SCSS

Для автоматической компиляции SCSS:

```bash
npm install
npm run scss
```

После этого проект доступен через настроенный домен Open Server:

```text
http://myblog/
```

## Запуск через Docker

Docker-окружение включает:

* PHP 8.4 + Apache;
* MySQL 8.0;
* phpMyAdmin.

### 1. Запуск

Из корня проекта:

```bash
docker compose up -d
```

### 2. Проверка контейнеров

```bash
docker compose ps
```

Ожидаемые сервисы:

```text
myblog_app
myblog_db
myblog_phpmyadmin
```

### 3. Миграции

```bash
docker compose exec app php database/migrate.php
```

### 4. Seed

```bash
docker compose exec app php database/seeders/seed.php
```

### 5. Адрес приложения

```text
http://localhost:8080/
```

### 6. phpMyAdmin

```text
http://localhost:8081/
```

Для подключения к Docker MySQL из phpMyAdmin используются:

```text
Server: db
Port: 3306
User: my_blog
Password: my_blog_password
Database: my_blog
```

### 7. Остановка

```bash
docker compose stop
```

Для полного удаления контейнеров и сети:

```bash
docker compose down
```

> Не используйте `docker compose down -v`, если нужно сохранить данные Docker MySQL.

## SCSS

Стили разделены на отдельные файлы по назначению:

* `_base.scss` — базовые стили;
* `_layout.scss` — общая структура страниц;
* `_header.scss` — шапка;
* `_footer.scss` — подвал;
* `_buttons.scss` — кнопки;
* `_cards.scss` — карточки статей;
* `_home.scss` — главная страница;
* `_category.scss` — страница категории;
* `_pagination.scss` — пагинация;
* `_post.scss` — страница статьи;
* `_error.scss` — страницы ошибок;
* `_variables.scss` — переменные.

Главный файл:

```text
resources/scss/style.scss
```

Собранный CSS находится в:

```text
public/assets/css/style.css
```

## Особенности реализации

### Динамические данные

Данные не зашиты в HTML-шаблоны. Категории, статьи, пагинация, сортировка и похожие статьи загружаются из MySQL при выполнении запросов.

### Безопасность SQL-запросов

Для запросов с пользовательскими параметрами используются подготовленные выражения PDO.

### Разделение ответственности

Логика разделена между:

* контроллерами;
* репозиториями;
* подключением к базе данных;
* Smarty-шаблонами.

### Docker и Open Server

Docker является дополнительным способом запуска проекта и не заменяет локальное окружение Open Server.

Настройки подключения к БД выбираются следующим образом:

* Open Server использует `.env`;
* Docker передаёт параметры подключения через переменные окружения Compose.

## Git

Основная рабочая ветка проекта:

```text
develop
```

Изменения разрабатываются и проверяются в `develop`.

`main` используется только для финального состояния проекта после проверки.

## Использование AI

При разработке проекта использовался AI-инструмент ChatGPT.

AI использовался как вспомогательный инструмент для:

* обсуждения архитектуры;
* поиска и исправления ошибок;
* проверки отдельных решений;
* подготовки части документации;
* помощи при настройке Docker.

Основная логика приложения, структура проекта и финальные решения были проверены и адаптированы в процессе самостоятельной разработки.
