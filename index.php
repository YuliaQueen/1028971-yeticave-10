<?php
require('function.php');
require('data.php');
require ('init.php');
//подключение категорий
//если нет подключения к базе, выводим страницу с ошибкой
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
else {
    $sql = 'SELECT * FROM categories';//запрос

    $result = mysqli_query($link, $sql);//результат запроса

    if ($result) {
        $category = mysqli_fetch_all($result, MYSQLI_ASSOC);//результат запроса выводим в массив
    }
    else {
        $error = mysqli_error($link);//если ошибка
        $content = include_template('error.php', ['error' => $error]);
    }
}

//подключение лотов
if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}
else {
    $sql =   'SELECT *, cat.category_name FROM lots JOIN categories AS cat ON lot_category = cat.category_id';


    $result = mysqli_query($link, $sql);//результат запроса

    if ($result) {
        $items_structure = mysqli_fetch_all($result, MYSQLI_ASSOC);//результат запроса выводим в массив
    }
    else {
        $error = mysqli_error($link);//если ошибка
        $content = include_template('error.php', ['error' => $error]);
    }
}

//шаблонизация
$main_content = include_template('main.php', [
    'items_structure' => $items_structure,
    'category' => $category

]);


$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,

] );

print($layout_content);
