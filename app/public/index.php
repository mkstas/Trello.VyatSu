<?php declare(strict_types=1);

require_once __DIR__ . '/../bootstrap.php';

?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>trello/app</title>
    <link rel="stylesheet" href="./assets/main.css">
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

    <script src="./assets/main.js"></script>
</body>
</html>
