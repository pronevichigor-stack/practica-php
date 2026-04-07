<div class="card">
    <h2>Управление помещениями</h2>

    <?php if (isset($_GET['message'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>

    <!-- Форма добавления -->
    <form method="post" style="margin-bottom: 30px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <h3>Добавить помещение</h3>
        <div style="display: grid; gap: 10px; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
            <input type="text" name="name" placeholder="Номер/Название помещения" required>
            <input type="text" name="type" placeholder="Тип помещения (кабинет, серверная и т.д.)">
            <select name="subdivision_id" required>
                <option value="">Выберите подразделение</option>
                <?php foreach ($subdivisions as $sd): ?>
                    <option value="<?= $sd->subdivision_id ?>"><?= htmlspecialchars($sd->name) ?></option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">➕ Добавить</button>
        </div>
    </form>

    <!-- Список помещений -->
    <h3>Список помещений</h3>
    <table style="width: 100%; border-collapse: collapse;">
        <thead>
        <tr style="background: #f0f0f0;">
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Название</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Тип</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Подразделение</th>
            <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($rooms)): ?>
            <tr>
                <td colspan="5" style="padding: 10px; text-align: center; border: 1px solid #ddd;">Нет помещений</td>
            </tr>
        <?php else: ?>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $room->room_id ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($room->name) ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($room->type ?? '—') ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($room->subdivision->name ?? '—') ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        <a href="<?= app()->route->getUrl('/room/delete/' . $room->room_id) ?>"
                           onclick="return confirm('Удалить помещение?')"
                           style="color: red; text-decoration: none;">🗑 Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>