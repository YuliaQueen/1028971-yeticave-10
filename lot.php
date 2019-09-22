<?php

require('init.php');

// Категории
$category = query_all($link,'SELECT * FROM categories');

// Текуший лот
$lot_id = (int)$_GET['lot_id'] ?? 0;


//Инфо о текущем лоте
$lot_info = query_one($link,"
SELECT
    l.*,
    c.category_name AS category
FROM lots l
JOIN categories AS c ON l.lot_category = c.category_id
WHERE lot_id = $lot_id");

if ($lot_info == null) {
    include '404.php';
    die();
};

//10 последних ставок для вывода в шаблон
$bids = query_all($link,"SELECT bid_date, bid_amount, bid_user, user_name FROM bids
JOIN users ON bids.bid_user = users.user_id
WHERE bid_lot = '$lot_id' ORDER BY bid_date DESC LIMIT 10");


$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (empty($_POST['bid'])) {
        $errors['bid'] = 'Введите ставку';
    };

    //Запрет ставки к своему лоту
    if (isset($lot_info['lot_author']) && $lot_info['lot_author'] == $_SESSION['user_name']['user_id']) {
        $errors['bid'] = 'Нельзя сделать ставку к своему лоту';
    };

    $last_bid = query_scalar("SELECT bid_amount FROM bids WHERE bid_lot = '$lot_id' ORDER BY bid_date DESC LIMIT 1");

    //Сравнение текущей и предыдущей ставок
    if ((int)$_POST['bid'] < (int)$last_bid) {
        $errors['bid'] = 'Слишком маленькая ставка';
    };

    //Если ставка не число или меньше нуля
    if ((!intval($_POST['bid'])) || intval($_POST['bid']) <= 0) {
        $errors['bid'] = 'Введите цифры больше нуля';
    };

    if (empty($errors)) {
        $new_bid = [
            $bid_date = date('Y-m-d H-i-s'),
            (int)$_POST['bid'],
            (int)$_SESSION['user_name']['user_id'],
            (int)$lot_id
        ];

        $sql = 'INSERT INTO bids(bid_date, bid_amount, bid_user, bid_lot)
                    VALUES(?, ?, ?, ?) ';
        $stmt = db_get_prepare_stmt($link, $sql, $new_bid);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $bid_id = mysqli_insert_id($link);
            header('Location: /my-bets.php');
            exit();
        };
    };
};


// шаблонизация
$main_content = include_template('lot.php', [
    'lot_info' => $lot_info,
    'category' => $category,
    'bids' => $bids,
    'errors' => $errors,
    'lot_id' => $lot_id
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => $lot_info['lot_name']
]);

print($layout_content);
