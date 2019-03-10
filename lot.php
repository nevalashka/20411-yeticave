<?php

require_once("init.php");
require_once("functions.php");
require_once("data.php");

$title = "Лот - YetiCave";

$category = "";

if (!$link) {
    $content = error_content();
} else {
    $sql = 'SELECT `id`, `category` FROM category';
    $result = mysqli_query($link, $sql);

        if(isset($_GET['id'])) {
            $lot_id = $_GET['id'];
            $lots_sql = 'SELECT * FROM lots l JOIN category c ON l.category_id = c.id WHERE l.id="'.$lot_id.'"';
            $lots_result = mysqli_query($link, $lots_sql);

            if (!empty($lots_result)) {
            $category = fetch_all($result);
            $lots = fetch_all($lots_result);

          //  $start_price_bid_step_sql = 'SELECT start_price, bid_step FROM lots WHERE lot_id = $_POST['id']';
        //    $bids_on_lot = 'SELECT bid_amount FROM bids WHERE lot_id = $_POST['id']';

                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $bid = $_POST;
                    if (empty($bid['bid']) && !validate_number($bid['bid'])) {
                        $errors['bid'] = 'Введите целое число больше 0';
                    }
                    if ($bid['bid'] <= $lot['bid_step']) {
                        $errors['bid'] = 'введите ставку больше, чем прошлая';
                    }
                    else {
                        $errors['bid'] = 'введите ставку больше, чем текущая цена лота плюс шаг ставки';
                    }
                    if(empty($bids_on_lot)) {
                  //      $sql_bid_insert = INSERT INTO bids (bid_amount, user_id, lot_id)
                    //        VALUES ($bid['start_price'].$bid['bid_step'], 'user_id', $lot_id);
                    }
                    else {
                      //  $sql_bid_insert = INSERT INTO bids (bid_amount, user_id, lot_id)
                        //    VALUES ($bid['bid_step'] /*В новую ставку записываем сумму последней ставки с введенным шагом, вообще не понял как взять последнию ставку */ );
                    }
                }
            $content = include_template("lot.php",[
                "lot" => $lots,
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
