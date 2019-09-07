<?php
require ('init.php');

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $form = $_POST;
    $required = ['user_email', 'user_password'];

    foreach ($required as $field) {
        if (empty($form[$field])) {
            $errors[$field] = 'Это поле надо заполнить';
        }
    };

    if (empty($errors)) {
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
