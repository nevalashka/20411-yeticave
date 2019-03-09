<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

session_start();

$title = "Вход - YetiCave";

$errors = [];
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

            if (empty($login['email']) && !filter_var($login['email'], FILTER_VALIDATE_EMAIL)) {
                $errors['email'] = "Введите email пользователя";
            }

            if (empty($login['password'])) {
                $errors['password'] = "Введите пароль";
            }

            $email = mysqli_real_escape_string($link, $login['email']);
            $sql_mail = "SELECT * FROM users WHERE email = '$email'";
            $res = mysqli_query($link, $sql_mail);

            $user = $res ? mysqli_fetch_array($res, MYSQLI_ASSOC) : null;

            if(empty($errors) && !empty($user)) {
                if (password_verify($login['password'], $user['password'])) {
                    $_SESSION['user'] = $user;
                    header("Location: index.php");
                    exit();
                }
                else {
                    $errors['password'] = 'Неверный пароль';
                }
            }
            $content = include_template('login.php', [
               'categories' => $category,
               'login' => $login,
               'errors' => $errors
            ]);
        }
        else {
            $content = include_template('login.php', [
                'categories' => $category
            ]);
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
