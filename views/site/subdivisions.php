<div class="card">
    <h2>Подразделения</h2>
    <form method="post" style="margin-bottom: 20px;">
        <input type="text" name="name" placeholder="Название подразделения" required style="width: auto; display: inline;">
        <input type="text" name="type" placeholder="Тип подразделения" style="width: auto; display: inline;">
        <button type="submit" class="btn">Добавить</button>
    </form>

    <table>
        <thead><tr><th>ID</th><th>Название</th><th>Тип</th></tr></thead>
        <tbody>
        <?php foreach ($subdivisions as $sd): ?>
            <tr>
                <td><?= $sd->subdivision_id ?></td>
                <td><?= htmlspecialchars($sd->name) ?></td>
                <td><?= htmlspecialchars($sd->type ?? '—') ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>