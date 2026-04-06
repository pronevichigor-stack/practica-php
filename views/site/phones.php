<div class="card">
    <h2>Управление телефонами</h2>

    <?php if (isset($_GET['message'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>

    <!-- Форма добавления -->
    <form method="post" style="margin-bottom: 30px; padding: 15px; background: #f8f9fa; border-radius: 8px;">
        <h3>Добавить телефон</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <input type="text" name="phone_number" placeholder="Номер телефона (например: 111-11-11)" required style="flex: 1;">
            <select name="room_id" required style="flex: 1;">
                <option value="">Выберите помещение</option>
                <?php foreach ($rooms as $room): ?>
                    <option value="<?= $room->room_id ?>"><?= htmlspecialchars($room->name) ?> (<?= htmlspecialchars($room->subdivision->name ?? '—') ?>)</option>
                <?php endforeach; ?>
            </select>
            <button type="submit" class="btn">➕ Добавить</button>
        </div>
    </form>

    <!-- Список телефонов -->
    <h3>Список телефонов</h3>
    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Номер телефона</th>
            <th>Помещение</th>
            <th>Подразделение</th>
            <th>Владелец</th>
            <th>Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($phones)): ?>
            <tr><td colspan="6" style="text-align: center;">Нет телефонов</td></tr>
        <?php else: ?>
            <?php foreach ($phones as $phone): ?>
                <tr>
                    <td><?= $phone->phone_id ?></td>
                    <td><strong><?= htmlspecialchars($phone->phone_number) ?></strong></td>
                    <td><?= htmlspecialchars($phone->room->name ?? '—') ?></td>
                    <td><?= htmlspecialchars($phone->room->subdivision->name ?? '—') ?></td>
                    <td>
                        <?php
                        $subscribers = $phone->subscribers->pluck('last_name')->toArray();
                        echo !empty($subscribers) ? implode(', ', $subscribers) : '—';
                        ?>
                    </td>
                    <a href="<?= app()->route->getUrl('/phone/delete/' . $phone->phone_id) ?>"
                       onclick="return confirm('Удалить телефон?')"
                       style="color: red; text-decoration: none;">🗑 Удалить</a>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>