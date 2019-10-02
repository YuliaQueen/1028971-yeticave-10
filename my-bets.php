<?php
require('init.php');

$category = query_all($link, 'SELECT * FROM categories');
$my_id = $_SESSION['user_name']['user_id'];

$my_bets = query_all($link, "SELECT *, bid_lot, category_name, user_contacts FROM bids
JOIN lots l on bids.bid_lot = l.lot_id
JOIN users u on l.lot_author = u.user_id
JOIN categories c on l.lot_category = c.category_id
WHERE bid_user = $my_id ORDER BY lot_end_date DESC
");


$winner = query_all($link, "SELECT lot_winner, lot_id, bid_user FROM lots
JOIN bids b on lots.lot_id = b.bid_lot
WHERE lot_winner = $my_id AND lot_end_date <= CURDATE() AND
lot_winner = bid_user");

// шаблонизация
$main_content = include_template('my-bets.php', [
    'category' => $category,
    'my_bets' => $my_bets,
    'winner' => $winner
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Мои ставки'

]);

print($layout_content);
