<?php $csrf = app()->auth::generateCSRF(); ?>
<section class="section-heading">
    <h1>Врачи</h1>
</section>

<section class="panel">
    <div class="panel-header">
        <h2>Список врачей</h2>
    </div>
    <div class="table-toolbar">
        <form method="get" class="search-form">
            <input type="text" name="search" value="<?= htmlspecialchars($search ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Поиск по врачу, должности, специализации">
            <div class="filter-actions">
                <button type="submit">Найти</button>
                <a class="ghost-button" href="<?= app()->route->getUrl('/doctors') ?>">Сбросить</a>
            </div>
        </form>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>ФИО</th>
                <th>Должность</th>
                <th>Специализация</th>
                <th>Дата рождения</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($doctors)): ?>
                <?php foreach ($doctors as $doctor): ?>
                    <tr>
                        <td><?= $doctor->id ?></td>
                        <td><?= htmlspecialchars(trim($doctor->surname . ' ' . $doctor->name . ' ' . ($doctor->patronym ?? '')), ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($doctor->position->name ?? '', ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($doctor->specialization->name ?? '', ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($doctor->birth_date, ENT_QUOTES, 'UTF-8', false) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="empty-cell">Врачи не найдены.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="panel form-panel">
    <div class="panel-header">
        <h2>Добавить врача</h2>
    </div>
    <form method="post" class="stack-form two-columns">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <label>
            <span>Фамилия</span>
            <?php if (!empty($errors['surname'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['surname'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="text" name="surname" value="<?= htmlspecialchars($old['surname'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Петров">
        </label>
        <label>
            <span>Имя</span>
            <?php if (!empty($errors['name'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['name'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="text" name="name" value="<?= htmlspecialchars($old['name'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Петр">
        </label>
        <label>
            <span>Отчество</span>
            <input type="text" name="patronym" value="<?= htmlspecialchars($old['patronym'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>" placeholder="Петрович">
        </label>
        <label>
            <span>Дата рождения</span>
            <?php if (!empty($errors['birth_date'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['birth_date'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="date" name="birth_date" value="<?= htmlspecialchars($old['birth_date'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
        </label>
        <label>
            <span>Должность</span>
            <?php if (!empty($errors['position_id'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['position_id'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <select name="position_id">
                <option value="">Выберите должность</option>
                <?php if (!empty($positions)): ?>
                    <?php foreach ($positions as $position): ?>
                        <option value="<?= $position->id ?>" <?= (string)($old['position_id'] ?? '') === (string)$position->id ? 'selected' : '' ?>><?= htmlspecialchars($position->name, ENT_QUOTES, 'UTF-8', false) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </label>
        <label>
            <span>Специализация</span>
            <?php if (!empty($errors['specialization_id'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['specialization_id'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <select name="specialization_id">
                <option value="">Выберите специализацию</option>
                <?php if (!empty($specializations)): ?>
                    <?php foreach ($specializations as $specialization): ?>
                        <option value="<?= $specialization->id ?>" <?= (string)($old['specialization_id'] ?? '') === (string)$specialization->id ? 'selected' : '' ?>><?= htmlspecialchars($specialization->name, ENT_QUOTES, 'UTF-8', false) ?></option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </label>
        <button type="submit" class="full-width">Сохранить врача</button>
    </form>
</section>