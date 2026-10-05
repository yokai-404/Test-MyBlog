{extends file="layouts/main.tpl"}

{block name="content"}

<section class="category-header">

    <a href="/" class="back-link">
        ← На главную
    </a>

    <span class="page-header__eyebrow">
        Категория
    </span>

    <h1>
        {$category.name|escape}
    </h1>

    {if $category.description}
        <p>
            {$category.description|escape}
        </p>
    {/if}

</section>


<section class="category-page">

    <div class="category-toolbar">

        <div class="sorting">

            <span class="sorting__label">
                Сортировка:
            </span>

            {if $sort === 'date'}

                {if $direction === 'DESC'}

                    <a
                        href="?sort=date&direction=ASC&page={$page}"
                        class="sort-link active"
                    >
                        Дата ↓
                    </a>

                {else}

                    <a
                        href="?sort=date&direction=DESC&page={$page}"
                        class="sort-link active"
                    >
                        Дата ↑
                    </a>

                {/if}

            {else}

                <a
                    href="?sort=date&direction=DESC&page=1"
                    class="sort-link"
                >
                    Дата
                </a>

            {/if}


            {if $sort === 'views'}

                {if $direction === 'DESC'}

                    <a
                        href="?sort=views&direction=ASC&page={$page}"
                        class="sort-link active"
                    >
                        Просмотры ↓
                    </a>

                {else}

                    <a
                        href="?sort=views&direction=DESC&page={$page}"
                        class="sort-link active"
                    >
                        Просмотры ↑
                    </a>

                {/if}

            {else}

                <a
                    href="?sort=views&direction=DESC&page=1"
                    class="sort-link"
                >
                    Просмотры
                </a>

            {/if}

        </div>

    </div>


    {if $posts}

        <div class="posts-list">

            {foreach $posts as $post}

                <article class="post-card">

                    {if $post.image}

                        <a
                            href="/category/{$category.name|escape:'url'}/post/{$post.id}"
                            class="post-card__image-link"
                            tabindex="-1"
                            aria-hidden="true"
                        >
                            <img
                                src="{$post.image|escape}"
                                alt=""
                                class="post-card__image"
                            >
                        </a>

                    {/if}

                    <div class="post-card-content">

                        <h2 class="post-card__title">

                            <a
                                href="/category/{$category.name|escape:'url'}/post/{$post.id}"
                            >
                                {$post.title|escape}
                            </a>

                        </h2>

                        {if $post.description}

                            <p class="post-card__description">
                                {$post.description|escape}
                            </p>

                        {/if}

                        <div class="post-meta">

                            <span>
                                {$post.published_at|escape}
                            </span>

                            <span>
                                Просмотров: {$post.views}
                            </span>

                        </div>

                    </div>

                </article>

            {/foreach}

        </div>

    {else}

        <div class="empty-message">

            <h2>
                В этой категории пока нет статей
            </h2>

            <p>
                Здесь появятся статьи, когда они будут опубликованы.
            </p>

        </div>

    {/if}

</section>


{if $totalPages > 1}

    <nav class="pagination" aria-label="Пагинация">

        {if $page > 1}

            <a
                href="?sort={$sort}&direction={$direction}&page={$page - 1}"
                class="pagination-link pagination-link--arrow"
            >
                ← Назад
            </a>

        {/if}


        <div class="pagination__pages">

            {for $pageNumber=1 to $totalPages}

                {if $pageNumber === $page}

                    <span class="pagination-link active">
                        {$pageNumber}
                    </span>

                {else}

                    <a
                        href="?sort={$sort}&direction={$direction}&page={$pageNumber}"
                        class="pagination-link"
                    >
                        {$pageNumber}
                    </a>

                {/if}

            {/for}

        </div>


        {if $page < $totalPages}

            <a
                href="?sort={$sort}&direction={$direction}&page={$page + 1}"
                class="pagination-link pagination-link--arrow"
            >
                Далее →
            </a>

        {/if}

    </nav>

{/if}

{/block}