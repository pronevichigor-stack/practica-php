<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Внутренняя телефонная связь</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        nav { background: #2c3e50; color: white; padding: 15px 20px; }
        nav a { color: white; text-decoration: none; margin-right: 20px; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 20px auto; padding: 0 20px; }
        .card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 4px rgba(0,0,0,0.1); margin-bottom: 20px; }
        .btn { display: inline-block; background: #3498db; color: white; padding: 8px 16px; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; font-size: 14px; }
        .btn-secondary { background: #95a5a6; }
        .btn-danger { background: #e74c3c; }
        .btn:hover { opacity: 0.9; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f8f9fa; }
        label { display: block; margin-top: 10px; margin-bottom: 5px; font-weight: bold; }
        input, select { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 4px; }
        .error { background: #f8d7da; color: #721c24; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .success { background: #d4edda; color: #155724; padding: 10px; border-radius: 4px; margin-bottom: 15px; }
        .menu-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 20px; margin-top: 20px; }
        .menu-card { background: white; border-radius: 8px; padding: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); }
        .menu-card h3 { margin-bottom: 15px; color: #2c3e50; }
        .menu-card a { display: block; margin: 10px 0; color: #3498db; text-decoration: none; }
        .menu-card a:hover { text-decoration: underline; }
        .actions { margin-bottom: 20px; }
        .filter-form { margin: 20px 0; padding: 15px; background: #f8f9fa; border-radius: 4px; }
        .filter-form label { display: inline; margin-right: 10px; }
        .filter-form select { width: auto; display: inline; margin-left: 10px; }
    </style>
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/') ?>">Главная</a>

        <?php if (app()->auth::check()): ?>
            <?php $user = app()->auth::user(); ?>

            <?php if ($user->id_role == 1): ?>
                <a href="<?= app()->route->getUrl('/subscribers') ?>">Абоненты</a>
                <a href="<?= app()->route->getUrl('/subdivisions') ?>">Подразделения</a>
                <a href="<?= app()->route->getUrl('/rooms') ?>">Помещения</a>
                <a href="<?= app()->route->getUrl('/phones') ?>">Телефоны</a>
                <a href="<?= app()->route->getUrl('/report/subdivision') ?>">Отчеты</a>
            <?php elseif ($user->id_role == 2): ?>
                <a href="<?= app()->route->getUrl('/admin/sysadmins') ?>">Системные администраторы</a>
                <a href="<?= app()->route->getUrl('/admin/create-sysadmin') ?>">Создать сисадмина</a>
            <?php endif; ?>

            <a href="<?= app()->route->getUrl('/logout') ?>" style="float:right">Выход (<?= htmlspecialchars($user->name) ?>)</a>
        <?php else: ?>
            <a href="<?= app()->route->getUrl('/login') ?>" style="float:right">Вход</a>
            <a href="<?= app()->route->getUrl('/signup') ?>" style="float:right">Регистрация</a>
        <?php endif; ?>
    </nav>
</header>

<main class="container">
    <?= $content ?? '' ?>
</main>
</body>
</html>