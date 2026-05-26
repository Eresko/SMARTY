{extends file="layouts/main.tpl"}

{block name="title"}Главная страница — Блог{/block}

{block name="content"}
    <h1>Последние публикации</h1>

    {foreach $categories as $cat}
        <div class="category-block">
            <h2>{$cat.name}</h2>

            <div class="posts-grid">
                {foreach $cat.posts as $post}
                    <div class="post-card">
                        {if $post.image}
                            <img src="{$post.image}" alt="{$post.title}">
                        {/if}
                        <h3>{$post.title}</h3>
                        <p>{$post.description}</p>
                        <small>Просмотров: {$post.views_count} | Дата: {$post.created_at}</small>
                        <br>
                        <a href="/index.php?route=post&id={$post.id}" class="btn">Читать далее</a>
                    </div>
                {/foreach}
            </div>

            <div class="category-action">
                <a href="/index.php?route=category&id={$cat.id}" class="btn btn-success">Все статьи категории →</a>
            </div>
        </div>
        {foreachelse}
        <p>Статей и категорий пока нет.</p>
    {/foreach}
{/block}
