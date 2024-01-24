<?php

namespace App\DB\Enum;

class ColorsEnum implements Enum
{
    const PRIMARY = 0;
    const SUCCESS = 2;
    const WARNING = 3;
    const DANGER = 4;
    const INFO = 5;

    public static function getList($id = null)
    {
        $list = [
            self::PRIMARY => 'primary',
            self::SUCCESS => 'success',
            self::WARNING => 'warning',
            self::DANGER => 'danger',
            self::INFO => 'info',
        ];

        if (!is_null($id)) {
            return $list[$id] ?? null;
        }

        return $list;
    }
}
