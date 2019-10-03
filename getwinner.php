<?php

require('vendor/autoload.php');

$sql = "SELECT l.*
FROM lots l
WHERE 1
	AND lot_winner IS NULL
	AND lot_end_date + INTERVAL 23 HOUR + INTERVAL 59 MINUTE + INTERVAL 59 SECOND <= NOW()";

$winner_info = [];
$finished_lots = query_all($link, $sql); //лоты, которые закончились

if (!empty($finished_lots)) {
    $finished_lots_ids = [];

    foreach ($finished_lots as $lot) {
        $finished_lots_ids [] = $lot['lot_id']; // Id закончившихся лотов
    };

    $sql = "SELECT b.bid_user, b.bid_lot, lot_name, b.bid_amount, user_email, user_name FROM bids b
LEFT JOIN
		(SELECT bid_lot, MAX(bid_amount) AS bid_amount
		FROM   bids
		WHERE bid_lot IN (" . implode(',', $finished_lots_ids) . ") -- Тут лоты на проверку, implode - массив в строку через разделитель
		GROUP BY bid_lot
		ORDER BY bid_lot) bmax ON bmax.bid_lot = b.bid_lot AND bmax.bid_amount = b.bid_amount
LEFT JOIN users ON b.bid_user = user_id
LEFT JOIN lots ON b.bid_lot = lot_id
WHERE 1
	AND b.bid_lot = bmax.bid_lot
	AND b.bid_amount = bmax.bid_amount";


    $finished_lots_winners_temp = query_all($link, $sql); //временный массив с победителями

    $finished_lots_winners = [];

    foreach ($finished_lots_winners_temp as $winner) {
        $finished_lots_winners [$winner['bid_lot']] = $winner; // ключ - это id лота, значение - данные самой большой ставки
    };

    foreach ($finished_lots as &$lot) {
        if (isset($finished_lots_winners[$lot['lot_id']])) {
            $lot['winner'] = $finished_lots_winners[$lot['lot_id']];
        } else {
            $lot['winner'] = false;
        };
        if (!empty($lot['winner'])) {
            $winner_info = $lot['winner'];

            $transport = (new Swift_SmtpTransport('phpdemo.ru', 25))
                ->setUsername('keks@phpdemo.ru')
                ->setPassword('htmlacademy');

            $mailer = new Swift_Mailer($transport);

            $message = (new Swift_Message('Ваша ставка выиграла'))
                ->setFrom('keks@phpdemo.ru', "YetiCave")
                ->setTo($winner_info['user_email'])
                ->setBody($mail = include_template('email.php', [
                    'user_name' => $winner_info['user_name'],
                    'lot_name' => $winner_info['lot_name'],
                    'lot_id' => $winner_info['bid_lot']
                ]), 'text/html');

            $result = $mailer->send($message);

            if ($result) {
                $lot_winner = mysqli_real_escape_string($link, $winner_info['bid_user']);
                $lot_id = mysqli_real_escape_string($link, $winner_info['bid_lot']);
                $winner_write = mysqli_query($link, "UPDATE lots SET lot_winner = $lot_winner
                     WHERE lot_id = $lot_id");
            };
        };
    };
};


