<?php

require('init.php');

// Категории
$category = query_all($link, 'SELECT * FROM categories');
$search_result = [];
$errors = '';
$q_search = '';
$pages_count = '';
$pages[0] = 1;

if ($_SERVER['REQUEST_METHOD'] == 'GET') {
    $q_search = mysqli_real_escape_string($link, $_GET['search']);
    $page_items = 6;
    $cur_page = $_GET['page'] ?? 1;
    $offset = ($cur_page - 1) * $page_items;

    $search_result = query_all($link, "SELECT *, lot_name FROM lots
    JOIN categories c on lots.lot_category = c.category_id
    WHERE MATCH(lot_name, lot_description) AGAINST('$q_search')
    ORDER BY lot_end_date DESC LIMIT $page_items OFFSET $offset");

    if (!empty($search_result)) {
        $lots_count = count($search_result);
        $pages_count = ceil($lots_count / $page_items);
        $pages = range(1, $pages_count);

        if ($cur_page > $pages_count || !$cur_page) {
            http_response_code(404);
            exit();
        }
    } else {
        $errors = "Ничего не найдено по вашему запросу";
    };

// шаблонизация
    $main_content = include_template('search.php', [
        'category' => $category,
        'search_result' => $search_result,
        'q_search' => $q_search,
        'errors' => $errors,
        'pages' => $pages,
        'cur_page' => $cur_page,
        'pages_count' => $pages_count
    ]);

    $layout_content = include_template('layout.php', [
        'category' => $category,
        'content' => $main_content,
        'title' => 'Результаты поиска'
    ]);

    print($layout_content);
};
