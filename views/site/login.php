<?php $csrf = app()->auth::generateCSRF(); ?>
<section class="panel auth-panel">
    <div class="section-heading">
        <h1>Авторизация</h1>
    </div>
    <form method="post" class="stack-form">
        <input type="hidden" name="csrf_token" value="<?= $csrf ?>">
        <?php if (!empty($message)): ?>
            <p class="error-message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8', false) ?></p>
        <?php endif; ?>
        <label>
            <span>Логин</span>
            <input type="text" name="login" value="<?= htmlspecialchars($old['login'] ?? '', ENT_QUOTES, 'UTF-8', false) ?>">
        </label>
        <label>
            <span>Пароль</span>
            <input type="password" name="password">
        </label>
        <button type="submit">Войти</button>
    </form>
</section>
