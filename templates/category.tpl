{extends file="layouts/main.tpl"}

{block name="title"}{$category.name} — Категория{/block}

{block name="content"}
    <h1>{$category.name}</h1>
    <p class="category-description">{$category.description}</p>

    {* Блок сортировки *}
    <div class="sorting">
        Сортировать по:
        <a href="/index.php?route=category&id={$category.id}&sort=date" {if $sortKey == 'date'}class="active"{/if}>Дате публикации</a>
        <a href="/index.php?route=category&id={$category.id}&sort=views" {if $sortKey == 'views'}class="active"{/if}>Количеству просмотров</a>
    </div>

    {* Список статей категории *}
    <div class="posts-grid">
        {foreach $posts as $post}
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
            {foreachelse}
            <p>В этой категории пока нет статей.</p>
        {/foreach}
    </div>

    {* Пагинация *}
    {if $totalPages > 1}
        <div class="pagination">
            {for $page=1 to $totalPages}
                {if $page == $currentPage}
                    <span class="active">{$page}</span>
                {else}
                    <a href="/index.php?route=category&id={$category.id}&sort={$sortKey}&page={$page}">{$page}</a>
                {/if}
            {/for}
        </div>
    {/if}
{/block}
