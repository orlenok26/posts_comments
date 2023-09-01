<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
$servername = "localhost"; //имя сервера
$database = "blog"; //имя БД
$username = "root"; //Пользователь
$password = ""; //пароль
$conn = mysqli_connect($servername, $username, $password, $database); //подключение к БД
