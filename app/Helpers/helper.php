<?php

if (!function_exists('format_price')) {

    function format_price($price, $precision = 2, $currency = 'Kč'): string
    {
        $price = number_format($price, $precision, ',', ' ');
        return $price . ' ' . $currency;
    }

}
