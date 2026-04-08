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
    <nav class="nav">
        <?php if (app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/dashboard') ?>">Главная</a>
            <a href="<?= app()->route->getUrl('/patients') ?>">Пациенты</a>
            <a href="<?= app()->route->getUrl('/doctors') ?>">Врачи</a>
            <a href="<?= app()->route->getUrl('/appointments') ?>">Записи</a>
            <a href="<?= app()->route->getUrl('/reports') ?>">Отчеты</a>
            <?php if ((app()->auth::user()?->role?->name ?? '') === 'admin'): ?>
                <a href="<?= app()->route->getUrl('/employees/create') ?>">Сотрудники</a>
            <?php endif; ?>
            <span class="muted">Пользователь: <?= app()->auth::user()?->login ?></span>
            <a href="<?= app()->route->getUrl('/logout') ?>">Выход</a>
        <?php else: ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
        <?php endif; ?>
    </nav>
</header>
<main class="container">
    <?= $content ?? '' ?>
</main>
</body>
</html>