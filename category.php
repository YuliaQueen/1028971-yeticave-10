<?php
require('init.php');

// Категории
$items_structure = [];
$category = query_all($link, 'SELECT * FROM categories');
$lot_list = [];
$category_id = (int)$_GET['category_id'] ?? 0;
$pages_count = '';

$page_items = 6;
$cur_page = $_GET['page'] ?? 1;

$offset = ($cur_page - 1) * $page_items;
$lots_count = query_scalar($link, "SELECT COUNT(*) as cnt FROM lots WHERE lot_category = $category_id");

$lot_list = query_all($link, "SELECT *, category_name, lot_category 
                                 FROM lots
                                 JOIN categories c ON lots.lot_category = c.category_id 
                                 WHERE lot_category = $category_id
                                 ORDER BY lot_end_date DESC
                                 LIMIT $page_items OFFSET $offset");

$cat_name = query_scalar($link, "SELECT category_name 
                                    FROM categories 
                                    WHERE category_id = $category_id
                                    ");

if (isset($lot_list)) {
    $page_count = ceil((int)$lots_count / $page_items);

};

$pages = range(1, $page_count);


// шаблонизация
$main_content = include_template('lot-list.php', [
    'items_structure' => $lot_list,
    'category' => $category,
    'cat_name' => $cat_name,
    'pages' => $pages,
    'cur_page' => $cur_page,
    'pages_count' => $pages_count,
    'category_id' => $category_id

]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => $cat_name

]);

print($layout_content);
