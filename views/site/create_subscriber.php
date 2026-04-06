<div class="card" style="max-width: 500px; margin: auto;">
    <h2>Добавление абонента</h2>
    <form method="post">
        <label>Фамилия *</label>
        <input type="text" name="last_name" required>

        <label>Имя *</label>
        <input type="text" name="first_name" required>

        <label>Отчество</label>
        <input type="text" name="middle_name">

        <label>Дата рождения</label>
        <input type="date" name="birth_date">

        <label>Подразделение *</label>
        <select name="subdivision_id" required>
            <option value="">Выберите подразделение</option>
            <?php foreach ($subdivisions as $sd): ?>
                <option value="<?= $sd->subdivision_id ?>"><?= htmlspecialchars($sd->name) ?></option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn">Сохранить</button>
        <a href="<?= app()->route->getUrl('/subscribers') ?>" class="btn btn-secondary">Отмена</a>
    </form>
</div>