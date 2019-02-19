<?php

require_once("functions.php");
require_once("data.php");
require_once("init.php");

if (!$link) {
    $error = mysqli_connect_error();
    $content = include_template('error.php', ['error' => $error]);
} else {
    $sql = 'SELECT `id`, `category` FROM category';
    $result = mysqli_query($link, $sql);

    if ($result) {
        $category = mysqli_fetch_all($result, MYSQLI_ASSOC);
    }
    else {
        $error = mysqli_error($link);
        $content = include_template('error.php', ['error' => $error]);
    }
}

print(include_template('index.php', ['content' => $content, 'categories' => $categories]));


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
