<?php
//подключаем базу данных
$link = mysqli_connect('localhost', 'root', '', 'yeti_cave');

//устанавливаем кодировку
mysqli_set_charset($link, 'utf8');

$category = [];
$content = '';
$items_structure = [];
