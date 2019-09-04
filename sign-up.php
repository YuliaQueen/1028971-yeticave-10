<?php
require ('init.php');

// Категории
$category = query_all('SELECT * FROM categories');
//$empty_cat = query_scalar('SELECT category_name FROM categories WHERE category_name = ""');


$errors = [];











// шаблонизация
$main_content = include_template('sign-up.php', [
    'category' => $category,
    'errors' => $errors
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Добавить лот'

]);

print($layout_content);
