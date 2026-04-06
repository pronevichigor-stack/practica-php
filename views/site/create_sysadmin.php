<div class="card" style="max-width: 500px; margin: auto;">
    <h2>Создание системного администратора</h2>

    <?php if (isset($_GET['message'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>

    <?php if (isset($error)): ?>
        <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>ФИО сотрудника *</label>
        <input type="text" name="name" placeholder="Иванов Иван Иванович" required>

        <label>Логин для входа *</label>
        <input type="text" name="login" placeholder="ivanov" required>

        <label>Пароль *</label>
        <input type="password" name="password" placeholder="******" required>

        <button type="submit" class="btn">Создать сисадмина</button>
        <a href="<?= app()->route->getUrl('/') ?>" class="btn btn-secondary">Отмена</a>
    </form>
</div>