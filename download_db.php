<?php
session_start();
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
include 'conn.php';
$comments = 'https://jsonplaceholder.typicode.com/comments'; //записываем путь к БД
$posts = 'https://jsonplaceholder.typicode.com/posts';
$comJson = file_get_contents("$comments"); //забираем файл
$postJson = file_get_contents($posts);
$comArr = json_decode($comJson, true); //декодируем в массив
$comArr = array_map('array_values', $comArr);
$postArr = json_decode($postJson, true);
$postArr = array_map('array_values', $postArr);

$comSql = "INSERT INTO comments (postId, id, name, email, body) VALUES ";
$comValues = "(?" . str_repeat(",?", count($comArr[0]) - 1) . ")";
$comSql .= $comValues . str_repeat(",$comValues", count($comArr) - 1);

$comStmt = $conn->prepare($comSql);
$comTypes = str_repeat("s", count($comArr) * count($comArr[0]));
$comParams = array_merge(...$comArr);
$comStmt->bind_param($comTypes, ...$comParams);
$comStmt->execute();

$comDwnld = (mysqli_affected_rows($conn));

$postSql = "INSERT INTO posts (userId, id, title, body) VALUES ";
$postValues = "(?" . str_repeat(",?", count($postArr[0]) - 1) . ")";
$postSql .= $postValues . str_repeat(",$postValues", count($postArr) - 1);

$postStmt = $conn->prepare($postSql);
$postTypes = str_repeat("s", count($postArr) * count($postArr[0]));
$postParams = array_merge(...$postArr);
$postStmt->bind_param($postTypes, ...$postParams);
$postStmt->execute();

$postDwnld = (mysqli_affected_rows($conn));
$download = $comDwnld + $postDwnld;
printf('Загружено ' . $postDwnld . ' записей и ' . $comDwnld . ' комментариев');

$postComSql = "INSERT INTO post_comment (title, body) SELECT a.title, b.body from posts a INNER JOIN comments b
    on a.id = b.postId";
$result = $conn->query($postComSql);
