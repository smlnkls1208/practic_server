<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Поликлиника</title>
    <link rel="stylesheet" href="<?= app()->route->getUrl('/style.css') ?>">
</head>
<body>
<header class="topbar">
    <div class="topbar-inner">
        <a class="brand" href="<?= app()->route->getUrl('/dashboard') ?>">Поликлиника</a>
        <?php if (app()->auth::check()): ?>
            <a class="logout-button" href="<?= app()->route->getUrl('/logout') ?>">Выход</a>
        <?php endif; ?>
    </div>
</header>
<main class="page-shell">
    <?= $content ?? '' ?>
</main>
</body>
</html>
