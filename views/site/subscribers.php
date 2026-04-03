<div class="card">
    <h2>Список абонентов внутренней связи</h2>

    <table>
        <thead>
        <tr>
            <th>Фамилия</th>
            <th>Имя</th>
            <th>Отчество</th>
            <th>Подразделение</th>
            <th>Телефон</th>
        </tr>
        </thead>
        <tbody>
        <?php if (empty($subscribers)): ?>
            <tr>
                <td colspan="5" style="text-align: center;">Абоненты пока не добавлены</td>
            </tr>
        <?php else: ?>
            <?php foreach ($subscribers as $s): ?>
                <tr>
                    <td><?= $s->last_name ?></td>
                    <td><?= $s->first_name ?></td>
                    <td><?= $s->middle_name ?></td>
                    <td><?= $s->subdivision ?></td>
                    <td><?= $s->phone ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</div>