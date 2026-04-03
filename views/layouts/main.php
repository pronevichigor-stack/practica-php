<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Телефонная связь</title>
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<header>
    <nav>
        <a href="<?= app()->route->getUrl('/hello') ?>">Главная</a>
        <?php if (app()->auth::check()): ?>
            <a href="<?= app()->route->getUrl('/subscribers') ?>">Абоненты</a>

            <?php if (app()->auth::user()->role === 'admin'): ?>
                <a href="<?= app()->route->getUrl('/signup') ?>">Регистрация сисадминов</a>
            <?php endif; ?>

            <a href="<?= app()->route->getUrl('/logout') ?>">Выход (<?= app()->auth::user()->name ?>)</a>
        <?php else: ?>
            <a href="<?= app()->route->getUrl('/login') ?>">Вход</a>
        <?php endif; ?>
    </nav>
</header>

<main>
    <?= $content ?? '' ?>
</main>

</body>
</html>