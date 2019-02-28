<?php
date_default_timezone_set('Europe/Moscow');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

$user_id = 1;


/**
 * Проверяет, что переданная дата соответствует формату ДД.ММ.ГГГГ
 * @param string $date строка с датой
 * @return bool
 */


function check_date_format($date) {
    $result = false;
    $regexp = '/(\d{2})\.(\d{2})\.(\d{4})/m';
    if (preg_match($regexp, $date, $parts) && count($parts) == 4) {
        $result = checkdate($parts[2], $parts[1], $parts[3]);
    }
    return $result;
}
check_date_format("04.02.2019"); // true
check_date_format("15.23.1989"); // false
check_date_format("1989-15-02"); // false

function db_get_prepare_stmt($link, $sql, $data = []) {
    $stmt = mysqli_prepare($link, $sql);

    if ($data) {
        $types = '';
        $stmt_data = [];

        foreach ($data as $value) {
            $type = null;

            if (is_int($value)) {
                $type = 'i';
            }
            else if (is_string($value)) {
                $type = 's';
            }
            else if (is_double($value)) {
                $type = 'd';
            }

            if ($type) {
                $types .= $type;
                $stmt_data[] = $value;
            }
        }

        $values = array_merge([$stmt, $types], $stmt_data);

        $func = 'mysqli_stmt_bind_param';
        $func(...$values);
    }

    return $stmt;
}


function time_count() {
    $time_current = date_create("now");
    $time_midnight = date_create("tomorrow midnight");
    $time_difference = date_diff ($time_current, $time_midnight);
    $time_before_midnight = date_interval_format ($time_difference, "%H:%I");
    return $time_before_midnight;
}

function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function price_format ($price) {
        $price_ceiled = ceil($price);
        if ($price_ceiled >= 1000) {
            $price_ceiled = number_format($price_ceiled, 0, ',', ' ');
        }
        return $price_ceiled . ' ₽';
}

function fetch_all($result) {
    $i = 0;
    $arr = [];
    while($var = mysqli_fetch_array($result)) {
        $arr[$i] = $var;
        $i++;
    }
    return $arr;
}

function error_content($link = '') {
    $error = mysqli_connect_error();
    if($link) {
        $error = mysqli_error($link);
    }
    $content = include_template('error.php', ['error' => $error]);
    return $content;
}

?>
