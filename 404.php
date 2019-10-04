<?php
require_once('init.php');

// шаблонизация
$main_content = include_template('404.php', [
    'category' => $category,
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Страницы не существует'

]);

print($layout_content);
