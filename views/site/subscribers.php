<div class="card">
    <h2>Список абонентов</h2>

    <div class="actions">
        <a href="<?= app()->route->getUrl('/subscribers/create') ?>" class="btn">➕ Добавить абонента</a>
        <a href="<?= app()->route->getUrl('/subscribers/attach-phone') ?>" class="btn">📞 Привязать телефон</a>
    </div>

    <form method="get" class="filter-form">
        <label>Фильтр по подразделению:</label>
        <select name="subdivision_id" onchange="this.form.submit()">
            <option value="">Все подразделения</option>
            <?php foreach ($subdivisions as $sd): ?>
                <option value="<?= $sd->subdivision_id ?>" <?= ($selectedSubdivision ?? '') == $sd->subdivision_id ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sd->name) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </form>

    <?php if (isset($_GET['message'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>

    <table>
        <thead>
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Подразделение</th>
            <th>Телефоны</th>
            <th style="text-align: center;">Действия</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($subscribers as $sub): ?>
            <tr>
                <td><?= htmlspecialchars($sub->last_name) ?></td>
                <td><?= htmlspecialchars($sub->first_name) ?></td>
                <td><?= htmlspecialchars($sub->middle_name ?? '') ?></td>
                <td><?= htmlspecialchars($sub->subdivision->name ?? '—') ?></td>
                <td>
                    <?php
                    $numbers = $sub->phones->pluck('phone_number')->toArray();
                    echo !empty($numbers) ? implode(', ', $numbers) : '—';
                    ?>
                </td>
                <td style="text-align: center;">
                    <a href="<?= app()->route->getUrl('/subscriber/delete/' . $sub->subscriber_id) ?>"
                       onclick="return confirm('Удалить абонента <?= htmlspecialchars($sub->last_name . ' ' . $sub->first_name) ?>?')"
                       class="btn btn-danger" style="background: #e74c3c;">🗑 Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>