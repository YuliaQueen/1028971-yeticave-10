<?php
require ('init.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['user_email', 'user_password'];

//проверка на заполненность полей
    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    };

//если массив с ошибками пуст...
    if (empty($errors)) {
//        $email_in_form = $form['user_email'];
//        $email = query_scalar("SELECT `user_email` FROM `users` WHERE `user_email` = '$email_in_form'");
//        var_dump($email);
//        die();
        header('Location: index.php');
    };

};

// шаблонизация
$main_content = include_template('login.php', [
    'category' => $category,
    'errors' => $errors
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'is_auth' => $is_auth,
    'user_name' => $user_name,
    'title' => 'Вход'

]);

print($layout_content);
