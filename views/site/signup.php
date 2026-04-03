<div class="card" style="max-width: 500px; margin: auto;">
    <h2>Регистрация сотрудника</h2>
    <h3><?= $message ?? ''; ?></h3>

    <form method="post">
        <label>ФИО сотрудника</label>
        <input type="text" name="name" placeholder="Иванов Иван Иванович" required>

        <label>Логин для входа</label>
        <input type="text" name="login" required>

        <label>Пароль</label>
        <input type="password" name="password" required>

        <label>Роль в системе</label>
        <select name="role">
            <option value="sysadmin">Системный администратор</option>
            <option value="admin">Администратор системы</option>
        </select>

        <button class="btn" style="width: 100%; margin-top: 10px;">Создать аккаунт</button>
    </form>
</div>