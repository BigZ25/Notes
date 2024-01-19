<?php
declare(strict_types=1);

namespace App\DB\Enum;

interface Enum
{
    public static function getList($id = null);
}
