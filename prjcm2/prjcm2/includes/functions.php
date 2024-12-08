<?php
if (!function_exists('validate_input')) {
    function validate_input($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }
    define('TAX_RATE', 0.15); // 15% de taxe

}

?>
