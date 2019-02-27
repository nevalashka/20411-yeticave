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

        $filename = uniqid() . '.jpg';
        $lot['path'] = $filename;
        move_uploaded_file($_FILES['url_picture']['tmp_name'], 'uploads/' . $filename);

        $sql = 'INSERT INTO lots (
        date_creation,
        category_id,
        user_id,
        name_lot,
        description,
        url_picture,
        start_price,
        date_finish,
        bid_step,
        )
        VALUES (NOW(), ?, 1, ?, ?, ?, ?, ?, ?, ?);';

        $stmt = db_get_prepare_stmt ($link, $sql,
                                    [
                                     $lot['date_creation'],
                                     $lot['category'],
                                     $lot['user_id'],
                                     $lot['name_lot'],
                                     $lot['description'],
                                     $lot['url_picture'],
                                     $lot['date_finish'],
                                     $lot['start_price'],
                                     $lot['bid_step']
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

// валидация полей

/*if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$lot = $_POST;

	$required = ['name_lot', 'description', 'category', 'start_price', 'date_finish', 'lot_img'];
	$dict = ['name_lot' => 'Название', 'description' => 'Описание', 'file' => 'Гифка'];
	$errors = [];
    foreach ($required as $key) {
		if (empty($_POST[$key])) {
            $errors[$key] = 'Это поле надо заполнить';
		}
	}

    if (isset($_FILES['url_picture']['name'])) {
		$tmp_name = $_FILES['url_picture']['tmp_name'];
		$path = $_FILES['url_picture']['name'];

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
		$file_type = finfo_file($finfo, $tmp_name);
        if ($file_type !== "image/gif") {
			$errors['file'] = 'Загрузите картинку в формате JPG';
		}
        else {
			move_uploaded_file($tmp_name, 'uploads/' . $path);
			$url_picture['path'] = $path;
		}
	}
    else {
		$errors['file'] = 'Вы не загрузили файл';
	}

    if (count($errors)) {
		$page_content = include_template('add.php',
                                         [
            'lot' => $lot,
            'errors' => $errors,
            'dict' => $dict
        ]);
	}
    else {
		$page_content = include_template('lot.php', ['lot' => $lot]);
	}

} else {
	$page_content = include_template('add.php', []);
}
*/


$layout = include_template("layout.php", [
    "content" => $content,
    "user_name" => $user_name,
    "title" => $title,
    "is_auth" => $is_auth,
    "categories" => $category
]);
print($layout);

?>

