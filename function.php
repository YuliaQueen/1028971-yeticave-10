<?php

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

function change_number($number) {
    $price_round = ceil($number);
    if ($price_round >= 1000) {
        $price_round = number_format($price_round, 0,'.',' ');
    }

    return $price_round;
}

function esc($str) {  //XSS
    $text = htmlspecialchars($str);
    //$text = strip_tags($str);

    return $text;
}
