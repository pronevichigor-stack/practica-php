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

    <?php if (empty($phones)): ?>
        <p>Нет телефонов</p>
    <?php else: ?>
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
            <tr style="background: #f0f0f0;">
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">ID</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Номер телефона</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Помещение</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Подразделение</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Владелец</th>
                <th style="padding: 10px; border: 1px solid #ddd; text-align: left;">Действия</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($phones as $phone): ?>
                <tr>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= $phone->phone_id ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><strong><?= htmlspecialchars($phone->phone_number) ?></strong></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($phone->room->name ?? '—') ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;"><?= htmlspecialchars($phone->room->subdivision->name ?? '—') ?></td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        <?php
                        $owners = [];
                        foreach ($phone->subscribers as $subscriber) {
                            $owners[] = $subscriber->last_name . ' ' . mb_substr($subscriber->first_name, 0, 1) . '.';
                        }
                        echo !empty($owners) ? implode(', ', $owners) : '—';
                        ?>
                    </td>
                    <td style="padding: 8px; border: 1px solid #ddd;">
                        <a href="<?= app()->route->getUrl('/phone/delete/' . $phone->phone_id) ?>"
                           onclick="return confirm('Удалить телефон?')"
                           style="color: red; text-decoration: none;">🗑 Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div style="margin-top: 20px;">
        <a href="<?= app()->route->getUrl('/') ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>