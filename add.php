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

            foreach ($required_fields as $field) {
                if (empty($lot[$field])) {
                    $errors[$field] = 'Поле не заполнено!';
        }
    }
            $error_category = false;
                foreach ($category as $val_category) {
                 if ($val_category['id'] == $lot['category']) {
                    $error_category = true;
             }
        }

            if(!$error_category) {
                $error_category['category'] = 'Укажите категорию лота';
            }

			if (!empty(($_FILES)) && ($_FILES['url_picture']['error']) == 0) {
                $file_extension = new SplFileInfo($_FILES['url_picture']['name']);
                $filename = uniqid().$file_extension;
				$tmp_name = $_FILES['url_picture']['tmp_name'];
				$path = 'img/'.$filename;
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$file_type = finfo_file($finfo, $tmp_name);
				if ($file_type !== "image/jpg" && $file_type !== "image/jpeg" && $file_type !== "image/png") {
					$errors['url_picture'] = 'Изображение должно быть в формате .jpg/jpeg или .png';
				} else {
					move_uploaded_file($tmp_name, $path);
					$lot['url_picture'] = $path;
				}
			} else {
				$errors['url_picture'] = "Загрузите изображение лота";
			}

            if (!validate_number($lot['bid_step'])) {
                $errors['bid_step'] = 'Введите число больше 0';
            }

            if (!validate_number($lot['start_price'])) {
                $errors['start_price'] = 'Введите число больше 0';
            }

            if (!check_date_format($lot['date_finish'])) {
                $errors['date_finish'] = 'Введите дату в формате ДД.ММ.ГГГГ';
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
                $content = include_template('add.php', [
                    'categories' => $category,
                    'errors' => $errors,
                    'lot' => $lot
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
