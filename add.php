<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$category = "";

if (!$link) {
    $content = error_content();
} else {
    $sql_category = 'SELECT `id`, `category` FROM category';
    $result_category = mysqli_query($link, $sql_category);
    if($result_category) {
        $category = fetch_all($result_category);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $lot = $_POST;
            $lot['user_id'] = $user_id;
            // проверка всех полей
            // $lot['category'] == $category['id']  найти в массиве строку
            // если строка нашлась в массиве - ошибки по категориям нет, можно дальще проверять остальные поля
            // если строка не нашлась - значит в $errors мы записываем ошибку по категориям

            if($lot['category'] == $category['id']) {
                // если строка не нашлась в массиве - ошибка есть и мы ее записываем в $errors['category'] = 'Выберите категорию';
            }

            // на пустоту проверить name_lot, если пустой - пишем ошибку, если не путой - ошибку не пишем
            if(empty($lot['name_lot'])) {
                $errors['name_lot'] = "Введите название лота";
            }

            if(empty($lot['description'])) {
                $errors['description'] = "Введите описание лота";
            }

            if(!empty($_FILES['url_picture']['name'])) {
                $filename = "uploads/" . uniqid() . '.jpg';
                $lot['path'] = $filename;
                move_uploaded_file($_FILES['url_picture']['tmp_name'], $filename);
            }
            else {
                $errors['url_picture'] = "Загрузите изображение лота";
            }

            // start_price проверяем, действительно ли это число. Если это не число - пишем ошибку. $errors['start_price'] = "Введите начальную стоимость";

            // date_finish - проверяем удовлетворяет ли дата условиям (с помощью функции, также не вчерашнее число должно быть)

            // bid_step - такая же проверка как и start_price

            // если $errors пустой - тогда мы можем выполнять $sql_insert

            if(empty($errors)) {
                $sql_insert = 'INSERT INTO lots ( date_creation, category_id, user_id, name_lot, description, url_picture, start_price, date_finish, bid_step ) VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?);';

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
                    header("Location: lot.php?id=" . $lot_id);
                }
                else {
                    $content = error_content($link);
                }
            }
            else {
                $content = include_template('add.php', [
                    'categories' => $category,
                    'errors' => $errors
                ]);
            }
        }

        else {
            $content = include_template('add.php', [
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

