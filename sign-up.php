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

            if (!empty(($_FILES)) && ($_FILES['avatar']['error']) == 0) {
                $file_extension = new SplFileInfo($_FILES['avatar']['name']);
                $filename = uniqid().$file_extension;
                $tmp_name = $_FILES['avatar']['tmp_name'];
                $path = 'img/'.$filename;
                $finfo = finfo_open(FILEINFO_MIME_TYPE);
                $file_type = finfo_file($finfo, $tmp_name);
                if ($file_type !== "image/jpg" &&$file_type !== "image/jpeg" && $file_type !== "image/png") {
                    $errors['avatar']= 'Изображение должно быть в формате .jpg/jpeg или .png';
                } else {
                    move_uploaded_file($tmp_name, $path);
                    $users['avatar'] = $path;
                }
            } else {
                $errors['avatar'] = "Загрузите аватар";
            }

            if (empty($users['name'])) {
                $errors['name'] = "Укажите имя пользователя";
            }

            if (empty($users['contact'])) {
                $errors['contact'] = "Укажите контакты пользователя";
            }

            if (empty($users['email'])) {
                $errors['email'] = "Укажите email пользователя";
            }
            else {
                if (filter_var($users['email'], FILTER_VALIDATE_EMAIL)) {
                    $email = mysqli_real_escape_string($link, $users['email']);
                    $sql_search_email = "SELECT id FROM users WHERE email = '$email'";
                    $res_users = mysqli_query ($link, $sql_search_email);

                    if(mysqli_num_rows($res_users) > 0) {
                        $errors['email']= 'Пользователь с таким email уже зарегистрирован';
                    }
                }
                else {
                    $errors['email'] = 'Некорректный e-mail адрес';
                }
            }

            if (empty($users['password'])) {
                $errors['password'] = 'Укажите пароль пользователя';
            }

            if(empty($errors)) {
                $password = password_hash($users['password'], PASSWORD_DEFAULT);

                $sql_insert = 'INSERT INTO users (registration_date, email, password, name, avatar, contact)
                VALUES (NOW(), ?, ?, ?, ?, ?)';

                $stmt = db_get_prepare_stmt($link, $sql_insert, [
                    $users['email'],
                    $password,
                    $users['name'],
                    $users['avatar'],
                    $users['contact']

                ]);

                $res = mysqli_stmt_execute($stmt);

                if ($res) {
                    header("Location: login.php");
                }
                else {
                    $content = error_content ($link);
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
