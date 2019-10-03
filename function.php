<?php

/**
 * Функция шаблонизации
 *
 * @param string $name HTML-шаблон
 * @param array $data Данные для вставки в шаблон
 * @return string Сгенерированный шаблон
 */
function include_template($name, $data = [])
{
    $name = __DIR__ . '/templates/' . $name;
    if (!is_readable($name)) {
        return false;
    }
    ob_start();
    extract($data);
    include($name);
    return ob_get_clean();
}

/** Форматирует цену, добавляет пробел между разрядмаи
 *
 * @param int $number
 *
 * @return float|string
 */
function change_number($number)
{
    $price_round = ceil($number);
    if ($price_round >= 1000) {
        $price_round = number_format($price_round, 0, '.', ' ');
    }

    return $price_round;
}

/**Преобразует теги 'html special chars' - преобразует в мнемноики
 * @param string $str
 *
 * @return string
 */
function esc($str)
{
    return htmlspecialchars($str);
}


/** Высчитывает сколько времени осталось до конца
 * @param string $ends_str
 * @return string
 * @throws Exception
 */
function time_to_end($ends_str)
{
    $date_then = DateTime::createFromFormat('Y-m-d H:i:s', "$ends_str 23:59:59");
    $date_now = new DateTime();
    $difference = $date_then->diff($date_now, false);
    if ($difference->y > 0) { // Если годов минимум 1
        return $difference->format('%y') . ' г';
    } elseif ($difference->m > 0) { // Если месяцев минимум 1
        return $difference->format('%m') . ' м';
    } elseif ($difference->d > 0) { // Если дней минимум 1
        return $difference->format('%d') . ' дн.';
    }  // Если меньше
    return $difference->format('%H час. %i мин.');
}


/**Сравнивает две даты
 * @param $ends_str
 * @return int
 * @throws Exception
 */
function time_class($ends_str)
{
    $date_then = DateTime::createFromFormat('Y-m-d H:i:s', "$ends_str 23:59:59");

    $date_now = new DateTime();

    if ($date_then < $date_now) {
        return 0;
    }
    $difference = $date_then->diff($date_now, false);

    if ($difference->h <= 1) {
        return 1;
    }
    return 2;
}


/** Возвращает последнюю ставку для лота или его стартовую цену
 * @param resource $link ресурс соединения с БД
 * @param int $id id лота
 * @param int $default начальная цена
 * @return bool
 */
function get_last_bid($link, $id, $default)
{
    settype($id, 'integer');
    $sql = "select bid_amount from bids
        where bid_lot = $id
        order by bid_amount desc
        limit 1";
    $result = query_scalar($link, $sql);
    if ($result === false) {
        return $default;
    }
    return $result;
}


/**Запрашивает все строки из БД
 * @param resource $link ресурс соединения
 * @param mysqli $sql запрос
 * @return array|bool|null
 *
 */
function query_all($link, $sql)
{
    $stmt = mysqli_query($link, $sql);
    if ($stmt) {
        $result = mysqli_fetch_all($stmt, MYSQLI_ASSOC);
        mysqli_free_result($stmt);
        return $result;
    }
    echo "<div><strong>MySQL Error :</strong> " . mysqli_error($link) . "</div>";
    return false;
}


/** Запрашивает одну строку из БД
 * @param resource $link ресурс соединения
 * @param mysqli $sql запрос
 * @return array|bool|null
 */
function query_one($link, $sql)
{
    $stmt = mysqli_query($link, $sql);
    if ($stmt) {
        $result = mysqli_fetch_assoc($stmt);
        mysqli_free_result($stmt);
        if ($result === null) {
            return false;
        }
        return $result;
    }
    echo "<div><strong>MySQL Error :</strong> " . mysqli_error($link) . "</div>";
    return false;
}


/** запрос значения ключа из первой строки массива из БД
 * @param resource $link ресурс соединения
 * @param mysqli $sql запрос
 * @return bool
 */
function query_scalar($link, $sql)
{
    $stmt = mysqli_query($link, $sql);
    if ($stmt) {
        $result = mysqli_fetch_row($stmt);
        mysqli_free_result($stmt);
        if ($result === null) {
            return false;
        }
        return $result[0];
    }
    echo "<div><strong>MySQL Error :</strong> " . mysqli_error($link) . "</div>";
    return false;
}


/** Проверяет расширение загружаемого файла
 * @param string $filename имя файла
 * @param string $tempName временный путь к файлу
 * @return bool|false|resource
 */
function checkFile($filename, $tempName)
{
    if (($pos = strrpos($filename, ".")) != false) {
        $ext = substr($filename, $pos);
        $found = false;
        if (strcasecmp($ext, ".png") === 0) {
            $found = imagecreatefrompng($tempName);
        } elseif (strcasecmp($ext, ".jpg") === 0 || strcasecmp($ext, ".jpeg") === 0) {
            $found = imagecreatefromjpeg($tempName);
        } elseif (strcasecmp($ext, ".gif") === 0) {
            $found = imagecreatefromgif($tempName);
        }
        return $found;
    }
    return false;
}


/**Сохраняет проверенный файл
 * @param string $checked проверенный файл
 * @param $save_as
 *
 */
function saveImages($checked, $save_as)
{
    if ($checked != false) {
        imagepng($checked, $save_as);
    }
}


/**сохраняет введенные в форму данные после перезагрузки страницы
 * @param string $name Строка, которую нужно сохранить
 * @return mixed|string
 */
function getPostVal($name)
{
    return $_POST[$name] ?? '';
}


/**
 * Создает подготовленное выражение на основе готового SQL запроса и переданных данных
 *
 * @param $link mysqli Ресурс соединения
 * @param $sql string SQL запрос с плейсхолдерами вместо значений
 * @param array $data Данные для вставки на место плейсхолдеров
 *
 * @return mysqli_stmt Подготовленное выражение
 */
function db_get_prepare_stmt($link, $sql, $data = [])
{
    $stmt = mysqli_prepare($link, $sql);

    if ($stmt === false) {
        $errorMsg = 'Не удалось инициализировать подготовленное выражение: ' . mysqli_error($link);
        die($errorMsg);
    }

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = 's';

            if (is_int($value)) {
                $type = 'i';
            } else {
                if (is_string($value)) {
                    $type = 's';
                } else {
                    if (is_double($value)) {
                        $type = 'd';
                    }
                }
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);

        if (mysqli_errno($link) > 0) {
            $errorMsg = 'Не удалось связать подготовленное выражение с параметрами: ' . mysqli_error($link);
            die($errorMsg);
        }
    }

    return $stmt;
}


/**
 * Проверяет существует ли логин, введенный в форму входа, в БД
 *
 * @param $link mysqli ресурс соединения с БД
 * @param $login string Ресурс соединения
 *
 * @return array|null true or false
 */
function checkLogin($link, $login)
{
    $login = mysqli_real_escape_string($link, $login);
    $res = mysqli_query($link, "SELECT `user_name` FROM `users` WHERE `user_name`='$login'  LIMIT 1");
    $result = mysqli_fetch_assoc($res);

    return $result;
}

/**
 * Загрузить и сохранить картинку
 * @param array $file $_FILES['item']
 * @return string|bool Имя файла или FALSE
 */
function saveUploadedFile(&$file)
{
    $upload = 'img/' . $_FILES['lot_picture']['name'];
    if (isset($file) && $file['error'] === 0) {
        $tmp_name = $_FILES['lot_picture']['tmp_name'];
        $size = getimagesize($tmp_name);

        if ($size[0] < 1200 || $size[1] < 1200) {
            $check = checkFile($upload, $tmp_name);

            if ($check !== false) {
                saveImages($check, $upload);
                return $upload;
            }
            return false;
        };
    };
}

