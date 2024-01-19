<?php

namespace App\Http\Controllers\Pluck;

use App\DB\Models\Cost;

class PluckCosts implements Pluck
{
    public static function handleRequest($columns, $filters)
    {
        $query = Cost::query()->where('user_id','=',auth()->user()->id);

        if (!empty($filters)) {
            if (array_key_exists('id', $filters)) {
                $query = $query->where('id', $filters['id']);
            }
        }

        return $query;
    }
}
