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

function time_to_end ($arr) {

    $time_end = strtotime($arr);
    $time_now = time();
    $secs_to_end = $time_end - $time_now;
    $h_end = str_pad(floor($secs_to_end/3600), 2, '0', STR_PAD_LEFT);
    $m_end = str_pad(floor(($secs_to_end % 3600) / 60), 2, '0', STR_PAD_RIGHT);

    return $h_end.':'.$m_end;

}
