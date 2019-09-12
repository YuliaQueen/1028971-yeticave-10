<?php
require ('init.php');

// Категории
$category = query_all('SELECT * FROM categories');

// Лоты
$lots = query_all('
SELECT
    l.*,
    c.category_name AS category
FROM lots l
JOIN categories AS c ON l.lot_category = c.category_id
ORDER BY l.lot_end_date ASC ');


//Пагинация
$cur_page = $_GET['page'] ?? 1;

$page_items = 6;
$items_count = query_one("SELECT COUNT(*) as cnt FROM lots ");

$pages_count = ceil((int)$items_count['cnt']/$page_items);

$offset = ($cur_page - 1)*$page_items;

$pages = range(1, $pages_count);

$page_lot = query_all("SELECT * FROM lots LIMIT  $page_items OFFSET $offset");



// шаблонизация
$main_content = include_template('main.php', [
    'items_structure' => $lots,
    'category' => $category

]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Главная'
] );

print($layout_content);
