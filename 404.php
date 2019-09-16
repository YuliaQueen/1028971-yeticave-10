<?php
require('init.php');

// шаблонизация
$main_content = include_template('login.php', [
    'category' => $category,
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Вход'

]);

print($layout_content);
