<section class="card narrow">
    <h1>Добавить сотрудника регистратуры</h1>
    <?php if (!empty($message)): ?>
        <p class="alert"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post" class="form">
        <label>Логин
            <input type="text" name="login" required>
        </label>
        <label>Пароль
            <input type="password" name="password" required>
        </label>
        <label>Роль
            <select name="role_id" required>
                <option value="">Выберите роль</option>
                <?php foreach (($roles ?? []) as $role): ?>
                    <option value="<?= (int)$role->id ?>"><?= htmlspecialchars($role->name) ?></option>
                <?php endforeach; ?>
            </select>
        </label>
        <button type="submit">Создать сотрудника</button>
    </form>
</section>