<div class="card">
    <h2>Добро пожаловать, <?= htmlspecialchars($user->name) ?>!</h2>
    <p>Ваша роль: <strong><?= $user->id_role == 1 ? 'Системный администратор' : 'Администратор' ?></strong></p>

    <?php if ($user->id_role == 1): // Системный администратор ?>
        <div class="menu-grid" style="margin-top: 30px;">
            <div class="menu-card">
                <h3>📞 Абоненты</h3>
                <a href="<?= app()->route->getUrl('/subscribers') ?>">Список абонентов</a>
                <a href="<?= app()->route->getUrl('/subscribers/create') ?>">Добавить абонента</a>
                <a href="<?= app()->route->getUrl('/subscribers/attach-phone') ?>">Привязать телефон</a>
            </div>
            <div class="menu-card">
                <h3>🏢 Справочники</h3>
                <a href="<?= app()->route->getUrl('/subdivisions') ?>">Подразделения</a>
                <a href="<?= app()->route->getUrl('/rooms') ?>">Помещения</a>
                <a href="<?= app()->route->getUrl('/phones') ?>">Телефоны</a>
            </div>
            <div class="menu-card">
                <h3>📊 Отчеты</h3>
                <a href="<?= app()->route->getUrl('/report/subdivision') ?>">Абоненты по подразделениям</a>
                <a href="<?= app()->route->getUrl('/report/room') ?>">Телефоны по помещениям</a>
            </div>
        </div>
    <?php elseif ($user->id_role == 2): // Администратор ?>
        <div class="menu-card" style="margin-top: 30px;">
            <h3>👑 Администрирование</h3>
            <a href="<?= app()->route->getUrl('/admin/create-sysadmin') ?>">Создать системного администратора</a>
        </div>
    <?php endif; ?>
</div>