<?php

namespace App\DB\Enum;

class ColorsEnum implements Enum
{
    const RED = 0;

    public static function getList($id = null)
    {
        $list = [
            self::RED => "czerwony",
        ];

        if (!is_null($id)) {
            return $list[$id] ?? null;
        }

        return $list;
    }
}
