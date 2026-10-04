{extends file="layouts/main.tpl"}

{block name="content"}

<section class="page-header">

    <a href="/" class="back-link">
        ← На главную
    </a>

    <h1>{$category.name|escape}</h1>

    {if $category.description}
        <p>{$category.description|escape}</p>
    {/if}

</section>

<section class="category-page">

    <div class="sorting">

        <span>Сортировка:</span>

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

    {if $posts}

        <div class="posts-list">

            {foreach $posts as $post}

                <article class="post-card">

                    {if $post.image}
                        <img
                            src="{$post.image|escape}"
                            alt="{$post.title|escape}"
                        >
                    {/if}

                    <div class="post-card-content">

                        <h2>
                            <a href="/category/{$category.name|escape:'url'}/post/{$post.id}">
                                {$post.title|escape}
                            </a>
                        </h2>

                        {if $post.description}
                            <p>{$post.description|escape}</p>
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

        <p class="empty-message">
            В этой категории пока нет статей
        </p>

    {/if}

</section>

{if $totalPages > 1}

    <nav class="pagination">

        {if $page > 1}
            <a
                href="?sort={$sort}&direction={$direction}&page={$page - 1}"
                class="pagination-link"
            >
                ← Назад
            </a>
        {/if}

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

        {if $page < $totalPages}
            <a
                href="?sort={$sort}&direction={$direction}&page={$page + 1}"
                class="pagination-link"
            >
                Далее →
            </a>
        {/if}

    </nav>

{/if}

{/block}