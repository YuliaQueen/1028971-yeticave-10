<?php
require ('init.php');

// Категории
$category = query_all('SELECT * FROM categories');

// Текуший лот
$lot_id = (int) ref($_GET['lot_id'], 0);

$lot_info = query_one("
SELECT
    l.*,
    c.category_name AS category
FROM lots l
JOIN categories AS c ON l.lot_category = c.category_id
WHERE lot_id = $lot_id");


if ($lot_info === NULL) {
    include 'pages/404.html'; // По хорошему счёту это тоже Template для layout
    die();
}

// шаблонизация
$main_content = include_template('lot.php', [
    'lot_info' => $lot_info,
    'category' => $category
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => $lot_info['lot_name'], // Тут поменяли заголовок
    'is_auth' => $is_auth,
    'user_name' => $user_name,

]);

print($layout_content);
