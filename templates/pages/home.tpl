{extends file="layouts/main.tpl"}

{block name="content"}

<section class="page-header home-header">
    <span class="page-header__eyebrow">
        My Blog
    </span>

    <h1>
        Последние статьи
    </h1>

    <p>
        Интересные материалы по разным категориям
    </p>
</section>

<div class="home-categories">

    {foreach $categories as $category}

        <section class="category-section">

            <div class="section-header">

                <div class="section-header__content">

                    <h2>
                        {$category.name|escape}
                    </h2>

                    {if $category.description}
                        <p>
                            {$category.description|escape}
                        </p>
                    {/if}

                </div>

                <a
                    href="/category/{$category.name|escape:'url'}"
                    class="button section-header__button"
                >
                    Все статьи
                    <span aria-hidden="true">→</span>
                </a>

            </div>

            <div class="posts-grid">

                {foreach $category.posts as $post}

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

                            <h3 class="post-card__title">
                                <a href="/category/{$category.name|escape:'url'}/post/{$post.id}">
                                    {$post.title|escape}
                                </a>
                            </h3>

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

        </section>

    {/foreach}

</div>

{/block}