<?php
declare(strict_types=1);

namespace App\Http\Controllers\Pluck;

interface Pluck
{
    public static function handleRequest($columns, $filters);
}
