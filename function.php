<?php

//Шаблонизатор
function include_template($name, $data = []) {
    $name = __DIR__ . '/templates/' . $name;
    if (!is_readable($name)) {
        return false;
    }
    ob_start();
    extract($data);
    include($name);
    return ob_get_clean();
}


//Форматирует цену, добавляет пробел между разрядмаи
function change_number($number) {
    $price_round = ceil($number);
    if ($price_round >= 1000) {
        $price_round = number_format($price_round, 0,'.',' ');
    }

    return $price_round;
}
//Преобразует теги 'html special chars' - преобразует в мнемноики, strip_tags - удаляет теги
function esc($str) {
    return htmlspecialchars($str);
    //$text = strip_tags($str);
}


function time_to_end($ends_str) {
    $date_then  = DateTime::createFromFormat('Y-m-d H:i:s', "$ends_str 23:59:59");
    $date_now   = new DateTime();
    $difference = $date_then->diff($date_now, false);
    if ($difference->y > 0) { // Если годов минимум 1
        return  $difference->format('%y') . ' г';
    } elseif ($difference->m > 0) { // Если месяцев минимум 1
        return  $difference->format('%m') . ' м';
    } elseif ($difference->d > 0) { // Если дней минимум 1
        return  $difference->format('%d') . ' дн.';
    } else { // Если меньше
        return  $difference->format('%H час. %i мин.');
    }
}

//добавляет класс в разметку
function time_class($ends_str) {
    $date_then  = DateTime::createFromFormat('Y-m-d H:i:s', "$ends_str 23:59:59");
    $date_now   = new DateTime();
    if($date_then < $date_now) {
        return 0;
    }
    $difference = $date_then->diff($date_now, false);
    if ($difference -> h <= 1 ) {
        return 1;
    } else return 2;

};

//проверяет наличие ставки для текущего лота
function get_last_bid($id, $default) {
    $result = query_scalar("select bid_amount from bids
        where bid_lot = $id
        order by bid_amount desc
        limit 1");
    if ($result === false) {
        return $default;
    } else {
        return $result;
    }
};

//Reference values
function ref(&$value, $default=null) {
    if (isset($value)) {
        return $value;
    } else {
        return $default;
    }
}

// Запросить все сроки из БД
function query_all($sql) {
    global $link;
    $stmt = mysqli_query($link, $sql);
    if ($stmt) {
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        mysqli_free_result($stmt);
        return $result;
    } else {
        echo "<div><strong>MySQL Error :</strong> " . mysqli_error($link) . "</div>";
        return false;
    }
}

// Запросить 1 строку из БД
function query_one($sql) {
    global $link;
    $stmt = mysqli_query($link, $sql);
    if ($stmt) {
        $result = mysqli_fetch_assoc($stmt);
        mysqli_free_result($stmt);
        return $result;
    } else {
        echo "<div><strong>MySQL Error :</strong> " . mysqli_error($link) . "</div>";
        return false;
    }
}

// Запроосить 1е значение первой строчки из БЗ
function query_scalar($sql) {
    global $link;
    $stmt = mysqli_query($link, $sql);
    if ($stmt) {
        $result = mysqli_fetch_row($stmt);
        mysqli_free_result($stmt);
        if ($result === NULL) {
            return false;
        }
        return $result[0];
    } else {
        echo "<div><strong>MySQL Error :</strong> " . mysqli_error($link) . "</div>";
        return false;
    }
}

