<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>nginx + php-fpm + PostgreSQL</title>
    <link rel="stylesheet" href="main.css">
</head>
<body>
    <div class="card">
        <h1 class="card-title">Регистрация</h1>
        <form class="form">
            <div class="form-field">
                <label class="form-field__label" for="name">Имя</label>
                <input class="form-field__input" id="name" name="name" type="text">
            </div>
            <div class="form-field">
                <label class="form-field__label" for="email">Электронная почта</label>
                <input class="form-field__input" id="email" name="email" type="email">
            </div>
            <div class="form-field">
                <label class="form-field__label" for="password">Пароль</label>
                <input class="form-field__input" id="password" name="password" type="password">
            </div>
            <button class="form-field__button">
                Зарегистрироваться
            </button>
        </form>
    </div>

    <script src="main.js"></script>
</body>
</html>
