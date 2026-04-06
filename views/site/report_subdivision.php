<div class="card">
    <h2>Отчет: Количество абонентов по подразделениям</h2>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Подразделение</th>
            <th>Тип</th>
            <th>Количество абонентов</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($subdivisions)): ?>
            <tr><td colspan="4" style="text-align: center;">Нет данных</td></tr>
        <?php else: ?>
            <?php foreach ($subdivisions as $sd): ?>
                <tr>
                    <td><?= $sd->subdivision_id ?></td>
                    <td><strong><?= htmlspecialchars($sd->name) ?></strong></td>
                    <td><?= htmlspecialchars($sd->type->name ?? '—') ?></td>
                    <td><?= $sd->subscribers_count ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>

    <div style="margin-top: 20px;">
        <a href="<?= app()->route->getUrl('/') ?>" class="btn btn-secondary">Назад</a>
    </div>
</div>