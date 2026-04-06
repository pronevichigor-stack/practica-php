<div class="card" style="max-width: 400px; margin: auto;">
    <h2>Авторизация</h2>
    <?php if ($message ?? ''): ?>
        <div class="error"><?= $message ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Логин</label>
        <input type="text" name="login" required>

        <label>Пароль</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn">Войти</button>
    </form>
    <p style="margin-top: 15px;">Нет аккаунта? <a href="<?= app()->route->getUrl('/signup') ?>">Зарегистрироваться</a></p>
</div>