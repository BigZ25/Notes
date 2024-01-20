<?php

namespace App\DB\Enum;

class ColorsEnum implements Enum
{
    const PRIMARY = 0;
    const SECONDARY = 1;
    const SUCCESS = 2;
    const WARNING = 3;
    const DANGER = 4;
    const INFO = 5;
    const DARK = 6;

    public static function getList($id = null)
    {
        $list = [
            self::PRIMARY => 'primary',
            self::SECONDARY => 'secondary',
            self::SUCCESS => 'success',
            self::WARNING => 'warning',
            self::DANGER => 'danger',
            self::INFO => 'info',
            self::DARK => 'dark'
        ];

        if (!is_null($id)) {
            return $list[$id] ?? null;
        }

        return $list;
    }
}
