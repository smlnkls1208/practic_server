<section class="panel auth-panel">
    <div class="section-heading">
        <h1>Авторизация</h1>
    </div>
    <?php if (!empty($message)): ?>
        <p class="alert"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
    <form method="post" class="stack-form">
        <label>
            <span>Логин</span>
            <input type="text" name="login" required>
        </label>
        <label>
            <span>Пароль</span>
            <input type="password" name="password" required>
        </label>
        <button type="submit">Войти</button>
    </form>
</section>