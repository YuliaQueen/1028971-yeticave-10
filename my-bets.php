<?php
require ('init.php');

$category = query_all('SELECT * FROM categories');

// шаблонизация
$main_content = include_template('my-bets.php', [
    'category' => $category,
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Регистрация'

]);

print($layout_content);
