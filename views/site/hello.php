<h2><?= $message ?? ''; ?></h2>

<?php if (!app()->auth::check()): ?>
    <div style="margin-top: 20px;">
        <a href="<?= app()->route->getUrl('/login') ?>" class="btn">Войти</a>
        <a href="<?= app()->route->getUrl('/signup') ?>" class="btn">Регистрация</a>
    </div>
<?php else: ?>
    <div class="menu-grid">
        <?php if (app()->auth::user()->role->name === 'sysadmin'): ?>
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
        <?php elseif (app()->auth::user()->role->name === 'admin'): ?>
            <div class="menu-card">
                <h3>👑 Администрирование</h3>
                <a href="<?= app()->route->getUrl('/admin/create-sysadmin') ?>">Создать сисадмина</a>
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>