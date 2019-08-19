<?php
require('function.php');
require('data.php');

$main_content = include_template('main.php', [
    'items_structure' => $items_structure,
    'category' => $category

]);


$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => $title,
    'is_auth' => $is_auth,
    'user_name' => $user_name,

] );

print($layout_content);
