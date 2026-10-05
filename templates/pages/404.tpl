{extends file="layouts/main.tpl"}

{block name="content"}

<section class="error-page">

    <div class="error-page__number">
        404
    </div>

    <div class="error-page__content">

        <span class="page-header__eyebrow">
            Ошибка
        </span>

        <h1>
            Страница не найдена
        </h1>

        <p>
            Возможно, страница была удалена, перемещена
            или вы перешли по неверной ссылке.
        </p>

        <a href="/" class="button">
            Вернуться на главную
            <span aria-hidden="true">→</span>
        </a>

    </div>

</section>

{/block}