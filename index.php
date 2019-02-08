<?php

require_once("functions.php");
require_once("data.php");

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
print($layot);

?>

