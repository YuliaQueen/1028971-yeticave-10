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

//пагинация


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
