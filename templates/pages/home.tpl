{extends file="layouts/main.tpl"}

{block name="content"}

<section class="page-header">
    <h1>My Blog</h1>
    <p>Последние статьи по категориям</p>
</section>

{foreach $categories as $category}

    <section class="category-section">

        <div class="section-header">
            <div>
                <h2>{$category.name|escape}</h2>

                {if $category.description}
                    <p>{$category.description|escape}</p>
                {/if}
            </div>

            <a
                href="/category/{$category.name|escape:'url'}"
                class="button"
            >
                Все статьи
            </a>
        </div>

        <div class="posts-grid">

            {foreach $category.posts as $post}

                <article class="post-card">

                    {if $post.image}
                        <img
                            src="{$post.image|escape}"
                            alt="{$post.title|escape}"
                        >
                    {/if}

                    <div class="post-card-content">

                        <h3>
                            <a href="/category/{$category.name|escape:'url'}/post/{$post.id}">
                                {$post.title|escape}
                            </a>
                        </h3>

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

    </section>

{/foreach}

{/block}