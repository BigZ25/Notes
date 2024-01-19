<?php

include('validator.php');
include('files.php');
include('responses.php');

function decimalRegexRule($decimals = 2): string
{
    return 'regex:/^\d{1,10}(\.\d{1,' . $decimals . '})?$/';
}

function passwordRegexRule(): string
{
    return 'regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{8,}$/';
}

function formatPriceShow($value, $currency = 'zł', $decimals = 2)
{
    return number_format($value, $decimals, ',', ' ') . ' ' . $currency;
}

function formatDateShow($value)
{
    return date("d.m.Y", strtotime($value));
}

function currentUnixTimestamp()
{
    return strtotime(date("Y-m-d H:i:s"));
}

