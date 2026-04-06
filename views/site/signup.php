<div class="card" style="max-width: 400px; margin: auto;">
    <h2>Регистрация</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>ФИО</label>
        <input type="text" name="name" required>

        <label>Логин</label>
        <input type="text" name="login" required>

        <label>Пароль</label>
        <input type="password" name="password" required>

        <button type="submit" class="btn">Зарегистрироваться</button>
    </form>
    <p style="margin-top: 15px;">Уже есть аккаунт? <a href="<?= app()->route->getUrl('/login') ?>">Войти</a></p>
</div>