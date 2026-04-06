<div class="card">
    <h2>Отчет: Количество телефонов по помещениям</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Помещение</th>
            <th>Тип</th>
            <th>Подразделение</th>
            <th>Количество телефонов</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($rooms)): ?>
            <tr><td colspan="5" style="text-align: center;">Нет данных</td></tr>
        <?php else: ?>
            <?php foreach ($rooms as $room): ?>
                <tr>
                    <td><?= $room->room_id ?></td>
                    <td><strong><?= htmlspecialchars($room->name) ?></strong></td>
                    <td><?= htmlspecialchars($room->type ?? '—') ?></td>
                    <td><?= htmlspecialchars($room->subdivision->name ?? '—') ?></td>
                    <td><?= $room->phones_count ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="<?= app()->route->getUrl('/') ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>