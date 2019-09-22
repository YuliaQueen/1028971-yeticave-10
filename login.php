<?php
require('init.php');

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
//проверка введенного в форму емайл в базе данных
    $email_in_form = $form['user_email'];
    $user_data = query_one($link,"SELECT * FROM `users` WHERE `user_email` = '$email_in_form'");

    if ($user_data === false) {
        $errors['user_email'] = 'Пользователь не найден';
    };

    if (!filter_var($form['user_email'], FILTER_VALIDATE_EMAIL)) {
        $errors['user_email'] = 'Введите корректный емайл';
    };


//Проверка введенного в форму пароля в базе данных
    $user_pass = $user_data['user_password'];
    $pass_in_form = $form['user_password'];
    $check_pass = password_verify($pass_in_form, $user_pass);

    if (!$check_pass) {
        $errors['user_password'] = 'Неверный пароль';
    }

//если массив с ошибками пуст...
    if (empty($errors)) {
        $_SESSION['user_name'] = $user_data;
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
    'title' => 'Вход'

]);

print($layout_content);
