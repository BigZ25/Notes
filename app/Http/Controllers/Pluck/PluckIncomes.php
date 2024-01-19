<?php

namespace App\Http\Controllers\Pluck;

use App\DB\Models\Income;

class PluckIncomes implements Pluck
{
    public static function handleRequest($columns, $filters)
    {
        $query = Income::query()->where('user_id','=',auth()->user()->id);

        if (!empty($filters)) {
            if (array_key_exists('id', $filters)) {
                $query = $query->where('id', $filters['id']);
            }
        }

        return $query;
    }
}
