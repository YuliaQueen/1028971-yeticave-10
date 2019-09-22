<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');
header('Content-Type: text/html; charset=UTF-8');
require('function.php');


$db_host = ref($_SERVER['DATABASE_HOST'], 'localhost');
$db_user = ref($_SERVER['DATABASE_USER'], 'root');
$db_pass = ref($_SERVER['DATABASE_PASS'], '');
$db_name = ref($_SERVER['DATABASE_DB'], 'yeti_cave');

//подключаем базу данных
$link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
if (!$link) {
    $error = iconv("Windows-1251", "UTF-8", mysqli_connect_error());
    exit(include_template('error.php', ['error' => $error]));
}

//устанавливаем кодировку
mysqli_set_charset($link, 'utf8');

$category = [];
$content = '';
$error = '';



