{extends file="layouts/main.tpl"}

{block name="title"}{$post.title}{/block}

{block name="content"}
    <article class="post-detail">
        <h1>{$post.title}</h1>

        <div class="post-meta">
            <span>👁 Просмотров: {$post.views_count}</span> |
            <span>📅 Дата: {$post.created_at}</span>
        </div>

        {if $post.image}
            <img src="{$post.image}" alt="{$post.title}" class="post-main-img">
        {/if}

        <p class="post-lead">{$post.description}</p>

        <div class="post-text">
            {$post.content|nl2br}
        </div>
    </article>

    {if !empty($similarPosts)}
        <div class="similar-posts-block">
            <h2 class="similar-title">Похожие статьи:</h2>
            <div class="posts-grid">
                {foreach $similarPosts as $spost}
                    <div class="post-card standard-card">
                        {if $spost.image}
                            <img src="{$spost.image}" alt="{$spost.title}">
                        {/if}
                        <h4>{$spost.title}</h4>
                        <p>{$spost.description|truncate:100:"..."}</p>
                        <a href="/index.php?route=post&id={$spost.id}" class="btn">Читать</a>
                    </div>
                {/foreach}
            </div>
        </div>
    {/if}
{/block}
