<?php
if (!function_exists('nepali_number_format')) {
    // Format salary in Nepali number system (lakh/crore)
    function nepali_number_format($num) {
        $num = (string)$num;
        $len = strlen($num);
        if ($len > 3) {
            $last3 = substr($num, -3);
            $restUnits = substr($num, 0, $len - 3);
            $restUnits = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $restUnits);
            $formatted = $restUnits . "," . $last3;
        } else {
            $formatted = $num;
        }
        return $formatted;
    }
}
?>