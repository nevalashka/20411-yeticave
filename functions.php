<?php
function include_template($name, $data) {
    $name = 'templates/' . $name;
    $result = '';

    if (!is_readable($name)) {
        return $result;
    }

    ob_start();
    extract($data);
    require $name;

    $result = ob_get_clean();

    return $result;
}

function price_format ($price) {
        $price_ceiled = ceil($price);
        if ($price_ceiled >= 1000) {
            $price_ceiled = number_format($price_ceiled, 0, ',', ' ');
        }
        return $price_ceiled . ' ₽';
    }
?>
