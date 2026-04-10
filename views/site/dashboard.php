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
                <h3> Справочники</h3>
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
            <h3>Администрирование</h3>
            <a href="<?= app()->route->getUrl('/admin/create-sysadmin') ?>" class="btn" >Создать системного администратора</a>
        </div>

        <div class="menu-card" style="margin-top: 30px;">
            <h3>Существующие системные администраторы</h3>
            <?php
            $sysAdmins = \Model\User::where('id_role', 1)->get();
            ?>
            <?php if ($sysAdmins->isEmpty()): ?>
                <p>Нет системных администраторов</p>
            <?php else: ?>
                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>ФИО</th>
                        <th>Логин</th>
                        <th style="text-align: center;">Действия</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sysAdmins as $admin): ?>
                        <tr>
                            <td><?= $admin->id_user ?></td>
                            <td><?= htmlspecialchars($admin->name) ?></td>
                            <td><?= htmlspecialchars($admin->login) ?></td>
                            <td style="text-align: center;">
                                <a href="<?= app()->route->getUrl('/admin/edit/' . $admin->id_user) ?>" class="btn" style="background: #95a5a6;">Редактировать</a>
                                <?php if ($admin->id_user != $user->id_user): ?>
                                    <a href="<?= app()->route->getUrl('/admin/delete/' . $admin->id_user) ?>" class="btn btn-danger" style="background: #95a5a6; onclick="return confirm('Удалить администратора <?= htmlspecialchars($admin->name) ?>?')">Удалить</a>
                                <?php else: ?>
                                    <span style="background: #95a5a6; color: white; padding: 8px 16px; border-radius: 4px;">Текущий</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>

    <?php endif; ?>
</div>