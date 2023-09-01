<?php
session_start();
// подключаемся к базе
include 'conn.php';
$inputSearch = $_POST['search']; // записываем в переменную данные из формы
$inputSearch = trim($inputSearch); // удаляем пробелы, если они есть
$inputSearch = mysqli_real_escape_string($conn, $inputSearch); //экранируем спец символы
$inputSearch = htmlspecialchars($inputSearch); // преобразуем спец символы
if (!empty($inputSearch)) { // если передано значение из формы
    if (strlen($inputSearch) < 3) { //если длина слова меньше трех
?>
        <p class="error-search">Слишком короткий поисковый запрос.</p>
    <? } else if (strlen($inputSearch) > 128) { // если длина слова больше 128
    ?>
        <p class="error-search">Слишком длинный поисковый запрос.</p>
        <? } else { // выполняем запрос к БД для выборки
        $sql = $conn->prepare("select * from post_comment where body like CONCAT('%', ?, '%')"); //подготавляем запрос к БД
        $sql->bind_param("s", $inputSearch); // передаем параметры
        $sql->execute(); // запускаем подготовленный запрос
        $result = $sql->get_result(); //получаем результат из подготовленного запроса
        $itog = mysqli_fetch_assoc($result); // записываем в массив полученные данные из запроса
        if (mysqli_affected_rows($conn) > 0) { //если результат выполнения запроса вернул хотябы одну строку, то выводим на экран выборку
            $num = mysqli_num_rows($result);
            $num = $num - 1; ?>
            <!DOCTYPE html>
            <html lang="ru">

            <head>
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Выборка по запросу</title>
                <link rel="stylesheet" href="style.css">
            </head>

            <body class="body-table">
                <div class="container">
                    <a href="/index.php" class="subscribe-btn subscribe-btn__table">Новый поисковой запрос</a>
                    <p class="text-search">Выборка по запросу: <?php echo '<b>' . $inputSearch . '</b>'; ?></p>
                    <div class="container">
                        <p class="text-zapros">Найдено совпадений:<?php echo '<b>' . $num . '</b>'; ?></p>
                    </div>
                </div>
                <table>
                    <thead>
                        <tr class="title-table">
                            <th>Пост</th>
                            <th>Комментарий</th>
                        </tr>
                    </thead>
                    <tbody>
                        <? while ($itog = mysqli_fetch_assoc($result)) { ?>

                            <tr>
                                <td><?php echo $itog['title']; ?></td>
                                <td><?php echo $itog['body'];
                                } ?></td>
                            </tr>
                        <?php
                    } else { //если нет, то выводим сообщение
                        ?>
                            <link rel="stylesheet" href="style.css">
                            <div class="container">
                                <a href="/index.php" class="subscribe-btn subscribe-btn__table">Новый поисковой запрос</a>
                                <p class="text-search">По вашему запросу <? echo '<b>' . $inputSearch . '</b>' ?> ничего не найдено!</p>
                            </div>
                        <? } ?>
                    </tbody>
                </table>
            </body>

            </html>

        <?php
    }
} else { ?>
        <p class="error-search-form">Введите запрос, поле не должно быть пустым!</p>
    <?php
}
    ?>