<?php

namespace App\DB\Enum;

class ColorsEnum implements Enum
{
    const RED = 0;
    const BLACK = 1;

    public static function getList($id = null)
    {
        $list = [
            self::RED => "czerwony",
            self::BLACK => "czarny",
        ];

        if (!is_null($id)) {
            return $list[$id] ?? null;
        }

        return $list;
    }
}
