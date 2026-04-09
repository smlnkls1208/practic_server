<?php
$role = $user?->role?->name ?? '';
?>
<section class="hero-card">
    <h1>Добро пожаловать</h1>
    <p>Система поликлиники используется для учета сотрудников, пациентов, врачей и записей на прием. На главной странице собраны только доступные вам разделы.</p>
</section>

<section class="feature-grid">
    <?php if ($role === 'admin'): ?>
        <a class="feature-card" href="<?= app()->route->getUrl('/employees/create') ?>">
            <h2>Сотрудники</h2>
            <p>Добавление учетных записей для сотрудников регистратуры.</p>
            <span>Перейти</span>
        </a>
    <?php endif; ?>

    <?php if ($role === 'employee'): ?>
        <a class="feature-card" href="<?= app()->route->getUrl('/patients') ?>">
            <h2>Пациенты</h2>
            <p>Просмотр списка пациентов и форма добавления новой записи.</p>
            <span>Перейти</span>
        </a>
        <a class="feature-card" href="<?= app()->route->getUrl('/doctors') ?>">
            <h2>Врачи</h2>
            <p>Таблица врачей и форма добавления нового специалиста.</p>
            <span>Перейти</span>
        </a>
        <a class="feature-card" href="<?= app()->route->getUrl('/appointments') ?>">
            <h2>Записи</h2>
            <p>Таблица записей к врачу, фильтрация и блок добавления.</p>
            <span>Перейти</span>
        </a>
    <?php endif; ?>
</section>
