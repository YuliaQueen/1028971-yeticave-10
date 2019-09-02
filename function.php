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
