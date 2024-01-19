<?php

namespace App\Http\Controllers\Pluck;

use App\DB\Models\Advert;

class PluckAdverts implements Pluck
{
    public static function handleRequest($columns, $filters)
    {
        $query = Advert::query()->with([
            'photos' => function ($query) {
                $query->selectRaw('id, `key` AS name, CONCAT("/storage/photos/",`key`) as url');
            }
        ])->where('user_id', '=', auth()->user()->id);

        if (!empty($filters)) {
            if (array_key_exists('id', $filters)) {
                $query = $query->where('id', $filters['id']);
            }
        }

        return $query;
    }
}
