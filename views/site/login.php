<section class="card narrow">
    <h1>Авторизация</h1>
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
        <button type="submit">Войти</button>
    </form>
</section>