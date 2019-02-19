<?php

require_once("functions.php");
require_once("data.php");
require_once("init.php");

if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
}

$content = include_template("index.php", [
    "categories" => $categories,
    "lots" => $lots
]);

$layout = include_template("layout.php", [
    "content" => $content,
    "user_name" => $user_name,
    "title" => $title,
    "is_auth" => $is_auth,
    "categories" => $categories
]);
print($layout);

?>
