<?php
require ('init.php');

// Категории
$form = $_POST;
$category = query_all('SELECT * FROM categories');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $required = ['user_name', 'user_email', 'user_password', 'user_contacts'];

    $fields = [
        'user_name' => 'Введите имя',
        'user_email' => 'Введите электронную почту',
        'user_password' => 'Введите пароль',
        'user_contacts' => 'Укажите контакты'
    ];

    //проверка на заполненность полей
    foreach ($required as $field) {
        if (empty($_POST[$field])) {
            $errors[$field] = $fields[$field];
        }
    };

    if (empty($errors)) {

        $email = mysqli_real_escape_string($link, $form['user_email']);
        $sql = "SELECT * FROM users WHERE user_email = '$email'";
        $res = mysqli_query($link, $sql);

        if (mysqli_num_rows($res) > 0) {
            $errors[] = 'Пользователь с этим email уже зарегистрирован';
        }
        else {
            $new_user = [
                $_POST['user_email'],
                $_POST['user_name'],
                $_POST['user_password'] = password_hash($form['user_password'], PASSWORD_DEFAULT),
                $_POST['user_contacts'],
                $date_reg = date('Y-m-d')
            ];

            $sql = 'INSERT INTO users(user_email, user_name, user_password, user_contacts, user_registration_date)
                    VALUES(?, ?, ?, ?, ?) ';
            $stmt = db_get_prepare_stmt($link, $sql, $new_user);
            $res = mysqli_execute($stmt);
        };
        if ($res && empty($errors)) {
            $user_id = mysqli_insert_id($link);
            header('Location: /pages/login.html');
            exit();
        }
    };

};

// шаблонизация
$main_content = include_template('sign-up.php', [
    'category' => $category,
    'errors' => $errors
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Регистрация'

]);

print($layout_content);
