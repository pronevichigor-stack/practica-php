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
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
        <tr style="background: #f0f0f0;">
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Название</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Тип</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($subdivisions)): ?>
            <tr>
                <td colspan="4" style="padding: 10px; text-align: center; border: 1px solid #ddd;">Нет подразделений</td>
            </tr>
        <?php else: ?>
            <?php foreach ($subdivisions as $sd): ?>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $sd->subdivision_id ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($sd->name) ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($sd->type->name ?? '—') ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        <a href="<?= app()->route->getUrl('/subdivision/delete/' . $sd->subdivision_id) ?>"
                           onclick="return confirm('Удалить подразделение?')"
                           style="color: red; text-decoration: none;">🗑 Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>/