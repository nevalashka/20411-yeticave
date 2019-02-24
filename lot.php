<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$url_picture = "";

$category = ""; // тут мы объявляем переменную, чтобы потом использовать

if(isset($_GET['id'])) {
    $lot_id = $_GET['id'];
}

if (!$link) {    //тут проверям наше подключение к базе, если его нет, то пишем ошибку
    $content = error_content();   // в переменную контент вызываем функцию error_content, она скорее всего показывает ошибку
} else {
    $sql = 'SELECT `id`, `category` FROM category'; // если подключение есть, то мы делаем запрос уже в таблицу категории (хотя вроде в файле лотс.пхп нам не нужны категории)
    $result = mysqli_query($link, $sql);     //в переменную результ мы вызываем какую-то функцию которую нет в файле функций... или это стандартная функция в пхп?

   // if (!empty($result)) {//тут проверяем что результ не пустоуй?
        if(isset($_GET['id'])) {
            $lot_id = $_GET['id'];
        $lots_sql = 'SELECT * FROM lots l JOIN category c ON l.category_id = c.id WHERE l.id="'.$_GET['id'].'"';// тут делаем запрос в таблицу лотов и связываем с категориями

        echo $lots_sql;
        $lots_result = mysqli_query($link, $lots_sql); //тут опять что-то с таблицами, не понимаю почему другая переменная

        if (!empty($lots_result)) {  //опять проверяем что lots_result не пустой? в чем проблема, если он будет пустой? ну не будет контента, мы это увидим и так, зачем проверка-то
            $category = fetch_all($result); //тут сложное блядство с массивами
            $lots = fetch_all($lots_result); // тут тоже непонятно что и куда

            $content = include_template("lot.php",  //тут уже подстановка контента в переменную которая и будет показывать результат в странице
            [
                "categories" => $category,
                "name_lot" => $name_lot,
                "url_picture" => $url_picture, //вроде так, но на меня ругается пыха, что я не объявляю перменные
                "description" => $description // мне не сложно их записать, но контент от этого не появится на странице лотов....
            ]);
        }
        else {
            $content = error_content($link);  //тут ошибки
        }

    }
    else {
        $content = error_content($link); // и опять ошибки
    }
}
$layout = include_template("layout.php", [ //это футер и шапочка
    "content" => $content,
    "user_name" => $user_name,
    "title" => $title,
    "is_auth" => $is_auth,
    "categories" => $category
]);
print($layout);

?>
