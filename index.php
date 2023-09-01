<!DOCTYPE html>
<html lang="en">
<html>
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <title>Поиск по базе данных - тестовое задание</title>
        <link rel="stylesheet" 
            href="https://use.fontawesome.com/releases/v5.9.0/css/all.css" 
            integrity="sha384-i1LQnF23gykqWXg6jxC2ZbCbUMxyw5gLZY6UiUS98LYV5unm8GWmfkIS6jqJfb4E" 
            crossorigin="anonymous">
        <link rel="stylesheet" href="style.css" />
    </head>
    <body class="body">
        <div class="wrapper">
            <form action="search.php" class="card-content" method="POST">
                <div class="container">
                    <div class="image">
                        <i class="fa fa-database"></i>
                    </div>
                    <h1>Search</h1>
                    <p>Поиск постов по слову из комментария</p>
                </div>
                <div class="form-input">
                    <input type="search" placeholder="Поиск..." class="search" name="search" id="search" required minlength="3", maxlength="128"/>
                    <button type="submit" class="subscribe-btn">Найти</button>
                </div>
            </form>
        </div>
    </body>
</html>

