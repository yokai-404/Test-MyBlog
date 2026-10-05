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
    <div class="container site-header__inner">

        <a href="/" class="logo">
            My Blog
        </a>

        <nav class="navigation" aria-label="Основная навигация">
            <a href="/" class="navigation__link">
                Главная
            </a>
        </nav>

    </div>
</header>

<main class="site-main">
    <div class="container">
        {block name="content"}{/block}
    </div>
</main>

<footer class="site-footer">

    <div class="container site-footer__inner">

        <div class="site-footer__info">

            <a href="/" class="site-footer__logo">
                My Blog
            </a>

            <p class="site-footer__description">
                Личный блог об интересных идеях,
                технологиях, природе и мире.
            </p>

        </div>


        <div class="site-footer__author">

            <span class="site-footer__label">
                Автор
            </span>

            <div class="site-footer__socials">

                <a
                    href="https://github.com/yokai-404"
                    class="site-footer__social"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="GitHub"
                    title="GitHub"
                >
                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            fill="currentColor"
                            d="M12 .5C5.65.5.5 5.65.5 12c0 5.08 3.29 9.39 7.86 10.91.58.11.79-.25.79-.56v-2.16c-3.2.7-3.87-1.54-3.87-1.54-.53-1.33-1.28-1.68-1.28-1.68-1.04-.71.08-.7.08-.7 1.15.08 1.75 1.18 1.75 1.18 1.03 1.75 2.69 1.24 3.35.95.1-.74.4-1.24.73-1.52-2.55-.29-5.23-1.28-5.23-5.69 0-1.26.45-2.29 1.18-3.1-.12-.29-.51-1.46.11-3.05 0 0 .97-.31 3.17 1.18a11 11 0 0 1 5.77 0c2.2-1.49 3.17-1.18 3.17-1.18.62 1.59.23 2.76.11 3.05.73.81 1.18 1.84 1.18 3.1 0 4.42-2.69 5.39-5.25 5.67.41.35.78 1.04.78 2.1v3.11c0 .31.21.68.8.56A11.51 11.51 0 0 0 23.5 12C23.5 5.65 18.35.5 12 .5Z"
                        />
                    </svg>
                </a>


                <a
                    href="https://t.me/Langiris"
                    class="site-footer__social"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Telegram"
                    title="Telegram"
                >
                    <svg
                        viewBox="0 0 24 24"
                        aria-hidden="true"
                    >
                        <path
                            fill="currentColor"
                            d="M21.94 3.53 18.7 19.1c-.24 1.1-.88 1.37-1.79.85l-4.92-3.63-2.37 2.28c-.26.26-.48.48-.98.48l.35-5.01 9.12-8.24c.4-.35-.09-.55-.62-.2L6.21 12.9l-4.85-1.52c-1.06-.33-1.08-1.06.22-1.58L20.55 2.7c.9-.33 1.68.22 1.39.83Z"
                        />
                    </svg>
                </a>


                <a
                    href="https://samara.hh.ru/resume/19c7b4b4ff1057b0420039ed1f4c4947415375"
                    class="site-footer__social"
                    target="_blank"
                    rel="noopener noreferrer"
                    aria-label="Профиль на hh.ru"
                    title="hh.ru"
                >
                    <span class="site-footer__hh">
                        hh
                    </span>
                </a>

            </div>

        </div>

    </div>


    <div class="container site-footer__bottom">

        <p>
            &copy; 2026 My Blog
        </p>

    </div>

</footer>

</body>
</html>