<?php $csrf = app()->auth::generateCSRF(); ?>
<section class="section-heading">
    <h1>Сотрудники</h1>
</section>

<section class="panel">
    <div class="panel-header">
        <h2>Текущие сотрудники</h2>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
            <tr>
                <th>ID</th>
                <th>Логин</th>
                <th>Роль</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($employees)): ?>
                <?php foreach ($employees as $employee): ?>
                    <tr>
                        <td><?= $employee->id ?></td>
                        <td><?= htmlspecialchars($employee->login, ENT_QUOTES, 'UTF-8', false) ?></td>
                        <td><?= htmlspecialchars($employee->role->name ?? '', ENT_QUOTES, 'UTF-8', false) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="empty-cell">Записей пока нет.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</section>

<section class="panel form-panel">
    <div class="panel-header">
        <h2>Добавить сотрудника</h2>
    </div>
    <form method="post" class="stack-form">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <?php if (!empty($errors['form'])): ?>
            <p class="error-message"><?= htmlspecialchars($errors['form'], ENT_QUOTES, 'UTF-8', false) ?></p>
        <?php endif; ?>
        <label>
            <span>Логин</span>
            <?php if (!empty($errors['login'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['login'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
        </label>
        <label>
            <span>Пароль</span>
            <?php if (!empty($errors['password'])): ?>
                <p class="error-message"><?= htmlspecialchars($errors['password'], ENT_QUOTES, 'UTF-8', false) ?></p>
            <?php endif; ?>
            <input type="password" name="password">
        </label>
        <button type="submit">Создать сотрудника</button>
    </form>
</section>
