<?php
require ('init.php');


$form = $_POST;

$category = query_all('SELECT * FROM categories');

$errors = [];
if (isset($_SESSION['user_name'])) {
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
            if (empty($form[$field])) {
                $errors[$field] = $fields[$field];
            }
        };

        //проверка логина на уникальность
        $user_in_form = mysqli_real_escape_string($link, $form['user_name']);
        $user_in_db = checkLogin($user_in_form);

        if ($user_in_db['user_name'] == $user_in_form) {
            $errors['user_name'] = 'Пользователь с таким именем уже существует';
        };



        //проверка длины пароля
        if (!empty($form['user_password'])) {
            if ($form['user_password'] < 6 && $form['user_password'] > 12) {
                $errors['user_password'] = 'Пароль должен быть от 6 до 12 символов';
            }
        };

        //проверка валидности емайл
        if (!empty($form['user_email'])) {
            if (!filter_var($form['user_email'], FILTER_VALIDATE_EMAIL)) {
                $errors['user_email'] = 'Введите корректный емайл';
            }
        };


        if (empty($errors)) {
            $email = mysqli_real_escape_string($link, $form['user_email']);
            $sql = "SELECT * FROM users WHERE user_email = '$email'";
            $res = mysqli_query($link, $sql);

            if (mysqli_num_rows($res) > 0) {
                $errors['user_email'] = 'Пользователь с этим email уже зарегистрирован';


            } else {
                $new_user = [
                    $form['user_email'],
                    $form['user_name'],
                    $form['user_password'] = password_hash($form['user_password'], PASSWORD_DEFAULT),
                    $form['user_contacts'],
                    $date_reg = date('Y-m-d')
                ];

                $sql = 'INSERT INTO users(user_email, user_name, user_password, user_contacts, user_registration_date)
                    VALUES(?, ?, ?, ?, ?) ';
                $stmt = db_get_prepare_stmt($link, $sql, $new_user);
                $res = mysqli_execute($stmt);
            };
            if ($res && empty($errors)) {
                $user_id = mysqli_insert_id($link);
                header('Location: /templates/login.php');
                exit();
            }
        };

    };
} else {
    header("HTTP/1.1 403 Forbidden" );
    exit();
};

// шаблонизация
$main_content = include_template('sign-up.php', [
    'category' => $category,
    'errors' => $errors
]);

$layout_content = include_template('layout.php', [
    'category' => $category,
    'content' => $main_content,
    'title' => 'Регистрация'

]);

print($layout_content);
