{extends file="layouts/main.tpl"}

{block name="content"}

<article class="post-page">

    <a
        href="/category/{$category.name|escape:'url'}"
        class="back-link"
    >
        ← {$category.name|escape}
    </a>


    <header class="post-header">

        <span class="page-header__eyebrow">
            Статья
        </span>

        <h1>
            {$post.title|escape}
        </h1>

        {if $post.description}

            <p class="post-description">
                {$post.description|escape}
            </p>

        {/if}

        <div class="post-meta post-header__meta">

            <span>
                Опубликовано: {$post.published_at|escape}
            </span>

            <span>
                Изменено: {$post.updated_at|escape}
            </span>

            <span>
                Просмотров: {$post.views}
            </span>

        </div>

    </header>


    {if $post.image}

        <figure class="post-image">

            <img
                src="{$post.image|escape}"
                alt="{$post.title|escape}"
            >

        </figure>

    {/if}


    <div class="post-content">
        {$post.content|escape|nl2br}
    </div>


    {if $post.categories}

        <section class="post-categories">

            <h2 class="post-categories__title">
                Категории
            </h2>

            <div class="category-tags">

                {foreach $post.categories as $postCategory}

                    <a
                        href="/category/{$postCategory.name|escape:'url'}"
                        class="category-tag"
                    >
                        {$postCategory.name|escape}
                    </a>

                {/foreach}

            </div>

        </section>

    {/if}

</article>


<section class="similar-section">

    <div class="similar-section__header">

        <div>

            <span class="page-header__eyebrow">
                Вам может понравиться
            </span>

            <h2>
                Похожие статьи
            </h2>

        </div>

    </div>


    {if $similarPosts}

        <div class="posts-grid">

            {foreach $similarPosts as $similar}

                <article class="post-card">

                    {if $similar.image}

                        <a
                            href="/category/{$similar.category_name|escape:'url'}/post/{$similar.id}"
                            class="post-card__image-link"
                            tabindex="-1"
                            aria-hidden="true"
                        >
                            <img
                                src="{$similar.image|escape}"
                                alt=""
                                class="post-card__image"
                            >
                        </a>

                    {/if}


                    <div class="post-card-content">

                        <h3 class="post-card__title">

                            <a
                                href="/category/{$similar.category_name|escape:'url'}/post/{$similar.id}"
                            >
                                {$similar.title|escape}
                            </a>

                        </h3>


                        {if $similar.description}

                            <p class="post-card__description">
                                {$similar.description|escape}
                            </p>

                        {/if}


                        <div class="post-meta">

                            <span>
                                {$similar.published_at|escape}
                            </span>

                            <span>
                                Просмотров: {$similar.views}
                            </span>

                        </div>

                    </div>

                </article>

            {/foreach}

        </div>

    {else}

        <p class="empty-message">
            Похожих статей нет
        </p>

    {/if}

</section>

{/block}