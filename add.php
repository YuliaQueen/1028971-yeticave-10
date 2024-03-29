<?php
require('init.php');


// Категории
$category = query_all($link, 'SELECT * FROM categories');
$errors = [];

if (isset($_SESSION['user_name'])) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $required = [
            'lot_name',
            'lot_start_price',
            'lot_bet_step',
            'lot_category',
            'lot_description'
        ];


        $fields = [
            'lot_name' => 'Введите наименование лота',
            'lot_description' => 'Напишите описание лота',
            'lot_start_price' => 'Введите начальную цену',
            'lot_bet_step' => 'Введите шаг ставки',
        ];

        //проверка на заполненность полей
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                $errors[$field] = $fields[$field];
            }
        };
        //Проверка заполненности категории
        if ($_POST['lot_category'] === "default") {
            $errors['lot_category'] = 'Выберите категорию';
        }

        //Проверка расширения файла
        $upload = saveUploadedFile($_FILES['lot_picture']);
        if ($upload === false) {
            $errors['lot_picture'] = 'Слишком большое расширение файла';
        }

        //Проверка - заружен ли файл
        if (!empty($_FILES['lot_picture']['error'])) {
            $errors['lot_picture'] = "Загрузите файл";
        };


        //Проверка даты окончания торгов
        if (isset($_POST['lot_end_date'])) {
            if (strtotime($_POST['lot_end_date']) - time() < 86400) {
                $errors['lot_end_date'] = 'Введите период более суток';
            }
        };

        //Проверка начальной цены
        if (!is_numeric($_POST['lot_start_price'])) {
            $errors['lot_start_price'] = 'Введите число';
        };

        //Проверка величины шага ставки
        if ((int)$_POST['lot_bet_step'] <= 0) {
            $errors['lot_bet_step'] = "Шаг ставки - больше нуля";
        };

        //Проверка шага ставки на число
        if (!is_numeric($_POST['lot_bet_step'])) {
            $errors['lot_bet_step'] = 'Введите число';
        };
        //Проверка начальной цены
        if ((int)$_POST['lot_start_price'] <= 0) {
            $errors['lot_start_price'] = 'Введите число больше нуля';
        }


        //Если ошибок 0, то начинаем формировать запрос на добавление лота в базу
        if (count($errors) < 1) {
            $new_lot = [
                $_POST['lot_name'],
                (int)$_POST['lot_category'],
                (int)$_POST['lot_start_price'],
                $_POST['lot_end_date'],
                $_POST['lot_author'] = $_SESSION['user_name']['user_id'],
                (int)$_POST['lot_bet_step'],
                $_POST['lot_creation_date'] = date('Y-m-d'),
                $_POST['lot_picture'] = $upload,
                $_POST['lot_description']
            ];


            $sql = "INSERT INTO lots (lot_name, lot_category, lot_start_price,
                 lot_end_date, lot_author, lot_bet_step, lot_creation_date, lot_picture, lot_description) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $stmt = db_get_prepare_stmt($link, $sql, $new_lot);

            $res = mysqli_stmt_execute($stmt);

            if ($res) {
                $lot_id = mysqli_insert_id($link);

                header("Location: /lot.php?lot_id=" . $lot_id);
            } else {
                $content = include_template('error.php', ['error' => mysqli_error($link)]);
            };
        };
    };
} else {
    header("HTTP/1.1 403 Forbidden");
    exit();
};


// шаблонизация
$main_content = include_template('add_lot.php', [
    'category' => $category,
    'errors' => $errors,
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Добавить лот'

]);

print($layout_content);
