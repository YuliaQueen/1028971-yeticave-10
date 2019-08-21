<?php

//Шаблонизатор
function include_template($name, array $data = []) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name))  {

        return $result;

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
    $text = htmlspecialchars($str);
    //$text = strip_tags($str);

    return $text;
}

//Функция для подсчета оставшегося времени до закрытия лота

//function time_to_end ($arr) {
//
//    $time_end = strtotime($arr);
//    $time_now = time();
//    $secs_to_end = $time_end - $time_now;
//    $h_end = str_pad(floor($secs_to_end/3600), 2, '0', STR_PAD_LEFT);
//    $m_end = str_pad(floor(($secs_to_end % 3600) / 60), 2, '0', STR_PAD_RIGHT);
//
//    return $h_end.':'.$m_end;
//
//}

function time_to_end($ends_str)
{
    $date_then  = DateTime::createFromFormat('Y-m-d H:i:s', "$ends_str 23:59:59");
    $date_now   = new DateTime();
    $difference = $date_then->diff($date_now, false);
    if ($difference->y > 0) { // Если годов минимум 1
        return  $difference->format('%y') . ' г';
    } elseif ($difference->m > 0) { // Если месяцев минимум 1
        return  $difference->format('%m') . ' м';
    } elseif ($difference->d > 0) { // Если дней минимум 1
        return  $difference->format('%d') . ' д';
    } else { // Если меньше
        return  $difference->format('%H час. %i мин.');
    }
}

//Должна добавлять css-класс timer——finishing в разметку
function time_class($ends_str) {
    $date_then  = DateTime::createFromFormat('Y-m-d H:i:s', "$ends_str 23:59:59");
    $date_now   = new DateTime();
    $difference = $date_then->diff($date_now, false);
    $flag = 0;
    if ($difference <= '1 hour') {
        $flag = 1;
        return $flag;
    } else return '';
};
