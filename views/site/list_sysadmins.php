<div class="card">
    <h2>Системные администраторы</h2>

    <?php if (isset($_GET['message'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>

    <a href="<?= app()->route->getUrl('/admin/create-sysadmin') ?>" class="btn">Создать сисадмина</a>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>ФИО</th>
            <th>Логин</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($sysAdmins as $admin): ?>
            <tr>
                <td><?= $admin->id_user ?></td>
                <td><?= htmlspecialchars($admin->name) ?></td>
                <td><?= htmlspecialchars($admin->login) ?></td>
                <td>
                    <a href="/admin/sysadmin/edit/<?= $admin->id_user ?>" class="btn">Редактировать</a>
                    <?php if ($admin->id_user != app()->auth::user()->id_user): ?>
                        <a href="/admin/sysadmin/delete/<?= $admin->id_user ?>" class="btn btn-danger" onclick="return confirm('Удалить?')">Удалить</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>