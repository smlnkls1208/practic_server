<?php $csrf = app()->auth::generateCSRF(); ?>
<section class="section-heading">
    <h1>Пациенты</h1>
</section>

<section class="panel">
    <div class="panel-header">
        <h2>Список пациентов</h2>
    </div>
    <div class="table-toolbar">
        <form method="get" class="search-form">
            <input type="text" name="search" value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Поиск по фамилии, имени, отчеству">
            <div class="filter-actions">
                <button type="submit">Найти</button>
                <a class="ghost-button" href="<?= app()->route->getUrl('/patients') ?>">Сбросить</a>
            </div>
        </form>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Фамилия</th>
                <th>Имя</th>
                <th>Отчество</th>
                <th>Дата рождения</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($patients)): ?>
                <?php foreach ($patients as $patient): ?>
                    <tr>
                        <td><?= $patient->id ?></td>
                        <td><?= htmlspecialchars($patient->surname, ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($patient->name, ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($patient->patronym ?? '', ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($patient->birth_date, ENT_QUOTES, 'UTF-8', false) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-cell">Пациенты не найдены.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="panel form-panel">
    <div class="panel-header">
        <h2>Добавить пациента</h2>
    </div>
    <form method="post" class="stack-form two-columns">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <label>
            <span>Фамилия</span>
            <?php if (!empty($errors['surname'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['surname'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="text" name="surname" value="<?= htmlspecialchars($old['surname'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Иванов">
        </label>
        <label>
            <span>Имя</span>
            <?php if (!empty($errors['name'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Иван">
        </label>
        <label>
            <span>Отчество</span>
            <input type="text" name="patronym" value="<?= htmlspecialchars($old['patronym'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Иванович">
        </label>
        <label>
            <span>Дата рождения</span>
            <?php if (!empty($errors['birth_date'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['birth_date'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="date" name="birth_date" value="<?= htmlspecialchars($old['birth_date'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
        </label>
        <button type="submit" class="full-width">Сохранить пациента</button>
    </form>
</section>