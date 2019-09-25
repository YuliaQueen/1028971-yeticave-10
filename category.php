<?php
require('init.php');

// Категории
$category = query_all($link, 'SELECT * FROM categories');
$lot_list = [];
$category_id = (int)$_GET['category_id'] ?? 0;

$lot_list = query_all($link, "SELECT *, category_name FROM lots
JOIN categories c on lots.lot_category = c.category_id WHERE lot_category = $category_id");

$cat_name = query_scalar($link, "SELECT category_name FROM categories WHERE category_id = $category_id");


// шаблонизация
$main_content = include_template('lot-list.php', [
    'items_structure' => $lot_list,
    'category' => $category,
    'cat_name' => $cat_name

]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => $cat_name

]);

print($layout_content);
