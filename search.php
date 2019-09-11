    <?php

    require ('init.php');

    // Категории
    $category = query_all('SELECT * FROM categories');
    $search_result = [];
    $errors = '';

    if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $q_search = strip_tags($_GET['search']);
        $search_result = query_all("SELECT *, lot_name FROM lots
        JOIN categories c on lots.lot_category = c.category_id
        WHERE MATCH(lot_name, lot_description) AGAINST('$q_search')");

        if (empty($search_result)) {
            $errors = 'Ничего не найдено по вашему запросу';
        }

    };


    // шаблонизация
    $main_content = include_template('search.php', [
        'category' => $category,
        'search_result' => $search_result,
        'q_search' => $q_search,
        'errors' => $errors
    ]);

    $layout_content = include_template('layout.php', [
        'category' => $category,
        'content' => $main_content,
        'title' => 'Результаты поиска'
    ]);

    print($layout_content);
