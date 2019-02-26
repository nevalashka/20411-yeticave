<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$categories = "";

if (!$link) {
    $content = error_content();
} else {
    $sql = 'SELECT `id`, `category` FROM category';
    $result = mysqli_query($link, $sql);
    if($result) {
        $category = fetch_all($result);
    }
    else {
        $content = error_content($link);
    }
    $content = include_template('add.php',
                                [
                                    'categories' => $category
                                ]);
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $lot = $_POST['lot'];

        $filename = uniqid() . '.jpg';
        $lot['path'] = $filename;
        move_uploaded_file($_FILES['url_picture']['tmp_name'], 'uploads/' . $filename);

        $sql = 'INSERT INTO lots (date_creation, user_id, category, name_lot, description, url_picture, start_price)
        VALUES (NOW(), 1, ?, ?, ?, ?, ?)';
        $stmt = db_get_prepare_stmt ($link, $sql,
                                    [$lot['category'],
                                     $lot['lot_name'],
                                     $lot['description'],
                                     $lot['url_picture']
                                    ]);
        $res = mysqli_stmt_execute($stmt);

        if ($res) {
            $gif_id = mysqli_insert_id($link);

            header("Location: lot.php?id=" . $lot_id);
        }
        else {
            $content = error_content($link);
        }
    }

}

$layout = include_template("layout.php", [
    "content" => $content,
    "user_name" => $user_name,
    "title" => $title,
    "is_auth" => $is_auth,
    "categories" => $category
]);
print($layout);

?>

