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
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Тип</th>
            <th>Подразделение</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($rooms)): ?>
            <tr><td colspan="5" style="text-align: center;">Нет помещений</td></tr>
        <?php else: ?>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?= $room->room_id ?></td>
                    <td><?= htmlspecialchars($room->name) ?></td>
                    <td><?= htmlspecialchars($room->type ?? '—') ?></td>
                    <td><?= htmlspecialchars($room->subdivision->name ?? '—') ?></td>
                    <td>
                        <a href="<?= app()->route->getUrl('/room/delete/' . $room->room_id) ?>"
                           onclick="return confirm('Удалить помещение «<?= htmlspecialchars($room->name) ?>»? Все связанные телефоны также будут удалены!')"
                           style="color: red; text-decoration: none;">🗑 Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>