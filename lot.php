<?php

require_once("init.php");
require_once("functions.php");

$title = "Лот - YetiCave";

$category = "";
$id = '';
$errors = [];

if (!$link) {
    $content = error_content();
} else {
    $sql = 'SELECT `id`, `category` FROM category';
    $result = mysqli_query($link, $sql);

        if(isset($_GET['id'])) {
            $lot_id = intval($_GET['id']);

            $start_price_bid_step_sql = "SELECT * FROM lots WHERE id = '$lot_id'";
            $bids_table = "SELECT * FROM bids b JOIN users u ON b.user_id = u.id WHERE b.lot_id = '$lot_id' ORDER BY b.id DESC";
            $bids_on_lot = $bids_table." LIMIT 1";

            $lots_sql = 'SELECT * FROM lots l JOIN category c ON l.category_id = c.id WHERE l.id="'.$lot_id.'"';
            $lots_result = mysqli_query($link, $lots_sql);

            $bids_result = mysqli_query($link, $bids_table);

            if (!empty($lots_result && $bids_table)) {
                $category = fetch_all($result);
                $lots = fetch_all($lots_result);

                $bids_fetch = fetch_all($bids_result);

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $bid = $_POST;
                    if (empty($bid['bid']) && !validate_number($bid['bid'])) {
                        $errors['bid'] = 'Введите целое число больше 0';
                    }
                    else {
                        $errors['bid'] = 'введите ставку больше, чем текущая цена лота плюс шаг ставки';
                    }
                    if(empty($bids_on_lot)) {
                        if ($bid['bid'] >= $bid['bid_step']) {
                            $sql_bid_insert = "INSERT INTO bids (bid_amount, user_id, lot_id)
                           VALUES ('".$bid["bid"]."','".$user_id."', '".$lot_id."')";
                        }
                    } else {
                        $errors['bid'] = 'введите ставку больше шага ставки';
                    }
                    if ($bids_on_lot . $lots['bid_step'] <= $bid['bid']) {
                    $sql_bid_insert = "INSERT INTO bids (bid_amount, user_id, lot_id)
                    VALUES ('".$bid["bid"]."', '".$user_id."', '".$lot_id."')";
                    }
                    else {
                        $errors['bid'] = 'введите ставку больше';
                    }
                }
            $content = include_template("lot.php",[
                "lot" => $lots,
                "bids_fetch" => $bids_fetch,
                "errors" => $errors,
                "categories" => $category]);
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



