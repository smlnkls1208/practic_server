<section class="section-heading">
    <span class="section-kicker">Администрирование</span>
    <h1>Сотрудники</h1>
    <p>На странице доступен просмотр уже созданных учетных записей и форма добавления нового сотрудника регистратуры.</p>
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
            <?php foreach (($employees ?? []) as $employee): ?>
                <tr>
                    <td><?= (int)$employee->id ?></td>
                    <td><?= htmlspecialchars($employee->login) ?></td>
                    <td><?= htmlspecialchars($employee->role->name ?? '') ?></td>
                </tr>
            <?php endforeach; ?>
            <?php if (empty($employees) || count($employees) === 0): ?>
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
    <?php if (!empty($message)): ?>
        <p class="alert"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post" class="stack-form two-columns">
        <label>
            <span>Логин</span>
            <input type="text" name="login" required>
        </label>
        <label>
            <span>Пароль</span>
            <input type="password" name="password" required>
        </label>
        <label class="full-width">
            <span>Роль</span>
            <select name="role_id" required>
                <option value="">Выберите роль</option>
                <?php foreach (($roles ?? []) as $role): ?>
                    <option value="<?= (int)$role->id ?>"><?= htmlspecialchars($role->name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit" class="full-width">Создать сотрудника</button>
    </form>
</section>
