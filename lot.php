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
    include '404.php'; // По хорошему счёту это тоже Template для layout
    die();
};
$bids = query_all("SELECT bid_date, bid_amount, user_name FROM bids
JOIN users ON bids.bid_user = users.user_id
WHERE bid_lot = '$lot_id' ORDER BY bid_date DESC LIMIT 10");






// шаблонизация
$main_content = include_template('lot.php', [
    'lot_info' => $lot_info,
    'category' => $category,
    'bids' => $bids
//    'errors' => $errors
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => $lot_info['lot_name'], // Тут поменяли заголовок
]);

print($layout_content);
