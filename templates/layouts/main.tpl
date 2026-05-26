<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>{block name="title"}Блог на Smarty{/block}</title>
    <link rel="stylesheet" href="/assets/css/main.css">
</head>
<body>
    <header>
        <div style="background:#333;color:#fff;padding:15px;margin-bottom:30px;">
            <a href="/index.php?route=home" style="color:#fff;text-decoration:none;font-size:20px;font-weight:bold;">🏠 Мой Блог</a>
        </div>
    </header>
    <main style="max-width:1200px;margin:0 auto;padding:0 20px;">
        {block name="content"}{/block}
    </main>
</body>
</html>
