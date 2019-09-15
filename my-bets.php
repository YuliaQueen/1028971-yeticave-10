<?php
require('init.php');

$category = query_all('SELECT * FROM categories');
$my_id = $_SESSION['user_name']['user_id'];

$my_bets = query_all("SELECT *, bid_lot, category_name FROM bids
JOIN lots l on bids.bid_lot = l.lot_id
JOIN categories c on l.lot_category = c.category_id
WHERE bid_user = $my_id  ORDER BY bid_date DESC
");


// шаблонизация
$main_content = include_template('my-bets.php', [
    'category' => $category,
    'my_bets' => $my_bets
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Мои ставки'

]);

print($layout_content);
