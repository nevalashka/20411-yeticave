<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$title = "Вход - YetiCave";

session_start();

$category = "";
$required_fields = ['email', 'password'];

if (!$link) {
    $content = error_content();
} else {
    $sql_category = 'SELECT `id`, `category` FROM category';
    $result_category = mysqli_query($link, $sql_category);

    if($result_category) {
        $category = fetch_all($result_category);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $login = $_POST;
			}

        if (empty(login['email']) && !filter_var($login['email'], FILTER_VALIDATE_EMAIL))) {
                $errors['email'] = "Введите email пользователя";
            }

        if (empty(login['password'])) {
                $errors['password'] = "Введите пароль";
            }



        if(empty($errors)) {
            $sql_insert = 'INSERT INTO lots (date_creation, category_id, user_id, name_lot, description, url_picture, start_price, date_finish, bid_step )
                VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?)';

            $stmt = db_get_prepare_stmt($link, $sql_insert, [
                     $lot['category'],
                     $lot['user_id'],
                     $lot['name_lot'],
                     $lot['description'],
                     $lot['url_picture'],
                     $lot['start_price'],
                     $lot['date_finish'],
                     $lot['bid_step']
                ]);

                $res = mysqli_stmt_execute($stmt);

                if ($res) {
                    $lot_id = mysqli_insert_id($link);
                    header("Location: lot.php?id=". $lot_id);
                }
                else {
                    $content = error_content($link);
                }
            }
            else {
                $content = include_template('login.php', [
                    'categories' => $category,
                    'errors' => $errors,
                    'lot' => $lot
                ]);
            }
        }

        else {
            $content = include_template('login.php', [
                'categories' => $category
            ]);
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
