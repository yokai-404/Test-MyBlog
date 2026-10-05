{extends file="layouts/main.tpl"}

{block name="content"}

<section class="home-hero">

    <div class="home-hero__content">

        <span class="home-hero__eyebrow">
            My Blog
        </span>

        <h1>
            Идеи, знания<br>
            и интересные истории.
        </h1>

        <p>
            Небольшой блог о мире, природе, технологиях,
            культуре и других темах, которые стоит изучить.
        </p>

    </div>

    <div class="home-hero__decoration" aria-hidden="true">

        <span class="home-hero__circle home-hero__circle--one"></span>
        <span class="home-hero__circle home-hero__circle--two"></span>
        <span class="home-hero__circle home-hero__circle--three"></span>

    </div>

</section>


<div class="home-categories">

    {foreach $categories as $category}

        <section class="category-section">

            <div class="section-header">

                <div class="section-header__content">

                    <span class="section-header__eyebrow">
                        Категория
                    </span>

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

                        {else}

                            <div
                                class="post-card__image-placeholder"
                                aria-hidden="true"
                            >
                                <span>
                                    {$category.name|escape}
                                </span>
                            </div>

                        {/if}


                        <div class="post-card-content">

                            <span class="post-card__category">
                                {$category.name|escape}
                            </span>

                            <h3 class="post-card__title">

                                <a
                                    href="/category/{$category.name|escape:'url'}/post/{$post.id}"
                                >
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
                                    {$post.views} просмотров
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