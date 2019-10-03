<?php
require('init.php');

$category = query_all($link, 'SELECT * FROM categories');
$my_id = $_SESSION['user_name']['user_id'];
$cur_time = date("Y-m-d");

$my_bets = query_all($link, "SELECT l.*, c.category_name,  b.bid_lot, max(b.bid_amount) AS my_bid_amount
 FROM bids b
 JOIN lots l ON b.bid_lot = l.lot_id
 JOIN categories c ON l.lot_category = c.category_id
 WHERE b.bid_user = $my_id GROUP BY b.bid_lot, l.lot_end_date ORDER BY l.lot_end_date DESC;");


foreach ($my_bets as &$my_bet) {
    $my_bet['last_bid'] = get_last_bid($link, $my_bet['lot_id'], $my_bet['lot_start_price']);
    $my_bet['is_my_winning'] = ($my_bet['last_bid'] === $my_bet['my_bid_amount']);
    if ($my_bet['is_my_winning']) {
        $my_bet['owner_contacts'] = query_scalar($link, "SELECT u.user_contacts FROM users u
             WHERE u.user_id = $my_bet[lot_author]");
        $my_bet['bet_status'] = 'Ставка выиграла';
    } else $my_bet['bet_status'] = 'Торги окончены';
};

// шаблонизация
$main_content = include_template('my-bets.php', [
    'category' => $category,
    'my_bets' => $my_bets,
    'cur_time' => $cur_time
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Мои ставки'

]);

print($layout_content);
