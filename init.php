<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 'on');
header('Content-Type: text/html; charset=UTF-8');
require('function.php');

date_default_timezone_set('Europe/Moscow');


//подключаем базу данных
$link = mysqli_connect('localhost', 'root', '', 'yeti_cave');
if (!$link) {
    $error = iconv("Windows-1251", "UTF-8", mysqli_connect_error());
    exit(include_template('error.php', ['error' => $error]));
}


//устанавливаем кодировку
mysqli_set_charset($link, 'utf8');

$category = [];
$content = '';
$error = '';



