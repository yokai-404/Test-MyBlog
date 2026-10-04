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

        <h1>{$post.title|escape}</h1>

        {if $post.description}
            <p class="post-description">
                {$post.description|escape}
            </p>
        {/if}

        <div class="post-meta">
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
        <div class="post-image">
            <img
                src="{$post.image|escape}"
                alt="{$post.title|escape}"
            >
        </div>
    {/if}

    <div class="post-content">
        {$post.content|escape|nl2br}
    </div>

    {if $post.categories}

        <div class="post-categories">

            <strong>Категории:</strong>

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

        </div>

    {/if}

</article>


<section class="similar-section">

    <h2>Похожие статьи</h2>

    {if $similarPosts}

        <div class="posts-grid">

            {foreach $similarPosts as $similar}

                <article class="post-card">

                    {if $similar.image}
                        <img
                            src="{$similar.image|escape}"
                            alt="{$similar.title|escape}"
                        >
                    {/if}

                    <div class="post-card-content">

                        <h3>
                            <a href="/category/{$similar.category_name|escape:'url'}/post/{$similar.id}">
                                {$similar.title|escape}
                            </a>
                        </h3>

                        {if $similar.description}
                            <p>
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