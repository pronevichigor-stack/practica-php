<div class="card" style="max-width: 400px; margin: auto; text-align: center;">
    <h2>Авторизация</h2>
    <p style="color: red;"><?= $message ?? ''; ?></p>

    <?php if (!app()->auth::check()): ?>
        <form method="post">
            <div style="text-align: left;">
                <label>Логин</label>
                <input type="text" name="login" required>

                <label>Пароль</label>
                <input type="password" name="password" required>
            </div>
            <button class="btn" style="width: 100%;">Войти в систему</button>
        </form>
    <?php else: ?>
        <p>Вы уже вошли как <b><?= app()->auth->user()->name ?></b></p>
        <a href="<?= app()->route->getUrl('/logout') ?>" class="btn">Выйти</a>
    <?php endif; ?>
</div>