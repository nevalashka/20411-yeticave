<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$category = "";

if (!$link) {
    $content = error_content();
} else {
    $sql = 'SELECT `id`, `category` FROM category';
    $result = mysqli_query($link, $sql);

        if(isset($_GET['id'])) {
            $lot_id = $_GET['id'];
        $lots_sql = 'SELECT * FROM lots l JOIN category c ON l.category_id = c.id WHERE l.id="'.$lot_id.'"';
        $lots_result = mysqli_query($link, $lots_sql);

        if (!empty($lots_result)) {
            $category = fetch_all($result);
            $lots = fetch_all($lots_result);

            $content = include_template("lot.php",
            [
                "lot" => $lots,
                "categories" => $category
            ]);
        }
        else {
            $content = error_content($link);
        }

    }
    else {
        $content = error_content($link);
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
