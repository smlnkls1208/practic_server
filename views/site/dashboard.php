<?php
$role = $user?->role?->name ?? '';

$cards = [];

if ($role === 'admin') {
    $cards[] = [
        'title' => 'Сотрудники',
        'text' => 'Добавление учетных записей для сотрудников регистратуры.',
        'url' => app()->route->getUrl('/employees/create'),
    ];
}

if ($role === 'employee') {
    $cards[] = [
        'title' => 'Пациенты',
        'text' => 'Просмотр списка пациентов и форма добавления новой записи.',
        'url' => app()->route->getUrl('/patients'),
    ];
    $cards[] = [
        'title' => 'Врачи',
        'text' => 'Таблица врачей и форма добавления нового специалиста.',
        'url' => app()->route->getUrl('/doctors'),
    ];
    $cards[] = [
        'title' => 'Записи',
        'text' => 'Таблица записей к врачу, фильтрация и блок добавления.',
        'url' => app()->route->getUrl('/appointments'),
    ];
}
?>
<section class="hero-card">
    <span class="hero-chip">Рабочее место</span>
    <h1>Добро пожаловать, <?= htmlspecialchars($user?->login ?? '') ?></h1>
    <p>Система поликлиники используется для учета сотрудников, пациентов, врачей и записей на прием. На главной странице собраны только доступные вам разделы.</p>
</section>

<section class="feature-grid">
    <?php foreach ($cards as $card): ?>
        <a class="feature-card" href="<?= $card['url'] ?>">
            <h2><?= htmlspecialchars($card['title']) ?></h2>
            <p><?= htmlspecialchars($card['text']) ?></p>
            <span>Перейти</span>
        </a>
    <?php endforeach; ?>
</section>
