<?php
date_default_timezone_set('Europe/Moscow');
ini_set('error_reporting', E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

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
