<div class="card" style="max-width: 600px; margin: auto;">
    <h2>Привязка телефона к абоненту</h2>

    <?php if (isset($_GET['message'])): ?>
        <div class="success"><?= htmlspecialchars($_GET['message']) ?></div>
    <?php endif; ?>

    <form method="post">
        <label>Абонент *</label>
        <select name="subscriber_id" required>
            <option value="">Выберите абонента</option>
            <?php foreach ($subscribers as $sub): ?>
                <option value="<?= $sub->subscriber_id ?>">
                    <?= htmlspecialchars($sub->last_name . ' ' . $sub->first_name . ' ' . $sub->middle_name) ?>
                    (<?= htmlspecialchars($sub->subdivision->name ?? '—') ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <label>Телефон *</label>
        <select name="phone_id" required>
            <option value="">Выберите телефон</option>
            <?php foreach ($phones as $phone): ?>
                <option value="<?= $phone->phone_id ?>">
                    <?= htmlspecialchars($phone->phone_number) ?>
                    (пом. <?= htmlspecialchars($phone->room->name ?? '—') ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <div style="display: flex; gap: 10px; margin-top: 20px;">
            <button type="submit" class="btn">📞 Привязать</button>
            <a href="<?= app()->route->getUrl('/subscribers') ?>" class="btn btn-secondary">Отмена</a>
        </div>
    </form>
</div>