<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$category = "";
$required_fields = ['email', 'password', 'name', 'contact'];

if (!$link) {
    $content = error_content();
} else {
    $sql_category = 'SELECT `id`, `category` FROM category';
    $result_category = mysqli_query($link, $sql_category);

    if($result_category) {
        $category = fetch_all($result_category);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $users = $_POST;

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

            if(empty($errors)) {
                $sql_insert = 'INSERT INTO users (registration_date, email, password, name, avatar, contact)
                VALUES (NOW(), ?, ?, ?, ?, ?)';

                $stmt = db_get_prepare_stmt($link, $sql_insert, [
                    $users['email'],
                    $users['password'],
                    $users['name'],
                    $users['avatar'],
                    $users['contact'],

                ]);

                $res = mysqli_stmt_execute($stmt);

                if ($res) {
                    $lot_id = mysqli_insert_id($link);
                    header("Location: login.php");
                }
                else {
                    $content = error_content($link);
                }
            }
            else {
                $content = include_template('sign-up.php', [
                    'categories' => $category,
                    'errors' => $errors,
                    'users' => $users
                ]);
            }
        }

        else {
            $content = include_template('sign-up.php', [
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
