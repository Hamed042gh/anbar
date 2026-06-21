<?php

if (! function_exists('fa_digits')) {
    function fa_digits(string|int|float $value): string
    {
        return str_replace(
            ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'],
            ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'],
            (string) $value
        );
    }
}

if (! function_exists('fa_number')) {
    function fa_number(int|float $value, int $decimals = 0): string
    {
        return fa_digits(number_format($value, $decimals));
    }
}
