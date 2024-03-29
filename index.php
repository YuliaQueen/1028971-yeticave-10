<?php
require('init.php');
require('vendor/autoload.php');

$title = '';

// Категории
$category = query_all($link, 'SELECT * FROM categories');

//Пагинация
$page_items = 6;
$cur_page = $_GET['page'] ?? 1;

$offset = ($cur_page - 1) * $page_items;
$lots_count = query_one($link, "SELECT COUNT(*) as cnt FROM lots WHERE lot_end_date >= CURDATE()");


$items_count = query_all($link, "
SELECT
    l.*,
    c.category_name AS category
FROM lots l
JOIN categories AS c ON l.lot_category = c.category_id
WHERE l.lot_end_date >= CURDATE()
ORDER BY l.lot_end_date  LIMIT $page_items OFFSET $offset");


if (isset($items_count)) {
    $pages_count = ceil((int)$lots_count['cnt'] / $page_items);

    if ($cur_page > $pages_count || !$cur_page) {
        include '404.php';
        die();
    }
};
$pages = range(1, $pages_count);


// шаблонизация
$main_content = include_template('main.php', [
    'items_count' => $items_count,
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
