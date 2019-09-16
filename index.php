<?php
require('init.php');
require('vendor/autoload.php');
require ('getwinner.php');


// Категории
$category = query_all('SELECT * FROM categories');


$page_items = $page_items ?? 6;
$cur_page = $_GET['page'] ?? 1;

$offset = ($cur_page - 1) * $page_items;
$lots_count = query_one("SELECT COUNT(*) as cnt FROM lots ");


$items_count = query_all("
SELECT
    l.*,
    c.category_name AS category
FROM lots l
JOIN categories AS c ON l.lot_category = c.category_id
ORDER BY l.lot_end_date DESC LIMIT $page_items OFFSET $offset");


if (isset($items_count)) {
    $pages_count = ceil((int)$lots_count['cnt'] / $page_items);

    if ($cur_page > $pages_count || !$cur_page) {
        http_response_code(404);
        exit();
    }
}
$pages = range(1, $pages_count);


// шаблонизация
$main_content = include_template('main.php', [
    'items_structure' => $items_count,
    'category' => $category,
    'pages' => $pages,
    'cur_page' => $cur_page,
    'pages_count' => $pages_count

]);


$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Главная'
]);


print($layout_content);
