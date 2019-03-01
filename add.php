<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$category = "";
$required_fields = ['name_lot', 'category', 'description', 'start_price', 'bid_step', 'date_finish'];

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
            foreach ($required_fields as $field) { //проверка всех полей
                if (empty($lot[$field])) {
                    $errors[$field] = 'Поле не заполнено!';
        }

    }

            $isExists = preg_match($category['id'], $lot['category']); // $lot['category'] == $category['id']  найти в массиве строку
				if (!$isExists) {
					$errors['category'] = "Укажите категорию лота"; // если строка нашлась в массиве - ошибки по категориям нет, можно дальще проверять остальные поля
            // если строка не нашлась - значит в $errors мы записываем ошибку по категориям
				}


            if(empty($lot['name_lot'])) { // на пустоту проверить name_lot, если пустой - пишем ошибку, если не пустой - ошибку не пишем
                $errors['name_lot'] = "Введите название лота";
            }

            if(empty($lot['description'])) {
                $errors['description'] = "Введите описание лота";
            }

			if (!empty(($_FILES)) && ($_FILES['url_picture']['error']) == 0) { // проверка файла
				$tmp_name = $_FILES['url_picture']['tmp_name'];
				$path = $_FILES['url_picture']['name'];
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$file_type = finfo_file($finfo, $tmp_name);
				if ($file_type !== "image/jpg" && $file_type !== "image/jpeg" && $file_type !== "image/png") {
					$errors['url_picture'] = 'Изображение должно быть в формате .jpg/jpeg или .png';
				} else {
					move_uploaded_file($tmp_name, 'img/' .$path);
					$lot['$path'] = 'img/' .$path;
				}
			} else {
				$errors['url_picture'] = "Загрузите изображение лота";
			}

			if (!empty($lot['start_price']) && (!FILTER_VALIDATE_INT($lot['start_price']))) { // start_price проверяем, действительно ли это число. Если это не число - пишем ошибку. $errors['start_price'] = "Введите начальную стоимость";
				$errors['start_price'] = 'Введите начальную стоимость';
			}
			if (!empty($lot['bid_step']) && (!FILTER_VALIDATE_INT($lot['bid_step']))) { // bid_step - такая же проверка как и start_price
				$errors['start_price'] = 'Цена должна быть числом';
			}


            if (!check_date_format($lot['date_finish'])) { // date_finish - проверяем удовлетворяет ли дата условиям (с помощью функции, также не вчерашнее число должно быть)
                $errors['date_finish'] = 'Введите дату в формате ДД.ММ.ГГГГ';
            }

            if(empty($errors)) { // если $errors пустой - тогда мы можем выполнять $sql_insert
                $sql_insert = 'INSERT INTO lots (date_creation, category_id, user_id, name_lot, description, url_picture, start_price, date_finish, bid_step )
                VALUES (NOW(), ?, ?, ?, ?, ?, ?, ?, ?);';

                $stmt = db_get_prepare_stmt($link, $sql_insert, [
                     $lot['category'],
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
