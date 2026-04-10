<div class="card" style="max-width: 500px; margin: auto;">
    <h2>✏ Редактирование системного администратора</h2>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>ФИО сотрудника *</label>
        <input type="text" name="name" value="<?= htmlspecialchars($sysAdmin->name) ?>" required>

        <label>Логин для входа *</label>
        <input type="text" name="login" value="<?= htmlspecialchars($sysAdmin->login) ?>" required>

        <label>Новый пароль (оставьте пустым, чтобы не менять)</label>
        <input type="password" name="password" placeholder="******">

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn">Сохранить</button>
            <a href="<?= app()->route->getUrl('/') ?>" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>