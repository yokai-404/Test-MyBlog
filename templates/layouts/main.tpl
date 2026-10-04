<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{$title|escape} — My Blog</title>

    <link rel="stylesheet" href="/assets/css/style.css">
</head>
<body>

<header class="site-header">
    <div class="container">
        <a href="/" class="logo">My Blog</a>

        <nav class="navigation">
            <a href="/">Главная</a>
        </nav>
    </div>
</header>

<main class="container">
    {block name="content"}{/block}
</main>

<footer class="site-footer">
    <div class="container">
        <p>&copy; My Blog</p>
    </div>
</footer>

</body>
</html>