<div class="card">
    <h2>Управление подразделениями</h2>

    <?php if (isset($_GET['message'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>

    <!-- Форма добавления подразделения -->
    <form method="post" style="margin-bottom: 30px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <h3>Добавить подразделение</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input type="text" name="name" placeholder="Название подразделения" required style="flex: 2;">
            <select name="type_id" required style="flex: 1;">
                <option value="">Выберите тип</option>
                <?php foreach ($types as $type): ?>
                    <option value="<?= $type->type_id ?>"><?= htmlspecialchars($type->name) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">➕ Добавить</button>
        </div>
    </form>

    <!-- Список подразделений -->
    <h3>Список подразделений</h3>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Тип</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($subdivisions)): ?>
            <tr><td colspan="4" style="text-align: center;">Нет подразделений</td></tr>
        <?php else: ?>
            <?php foreach ($subdivisions as $sd): ?>
                <tr>
                    <td><?= $sd->subdivision_id ?></td>
                    <td><?= htmlspecialchars($sd->name) ?></td>
                    <td><?= htmlspecialchars($sd->type->name ?? '—') ?></td>  <!-- ИСПРАВЛЕНО -->
                    <td>
                        <a href="<?= app()->route->getUrl('/subdivision/delete/' . $sd->subdivision_id) ?>"
                           onclick="return confirm('Удалить подразделение?')"
                           style="color: red; text-decoration: none;">🗑 Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>