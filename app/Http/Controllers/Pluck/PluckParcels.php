<?php

namespace App\Http\Controllers\Pluck;

use App\DB\Models\Parcel;

class PluckParcels implements Pluck
{
    public static function handleRequest($columns, $filters)
    {
        $query = Parcel::query()->where('user_id', '=', auth()->user()->id);

        if (!empty($filters)) {
            if (array_key_exists('id', $filters)) {
                $query = $query->where('id', $filters['id']);
            }

            if (array_key_exists('status', $filters) && $filters['status'] !== null) {
                $query = $query->where('status', $filters['status']);
            }

            if (array_key_exists('type', $filters) && $filters['type'] !== null) {
                $query = $query->where('type', $filters['type']);
            }
        }

        return $query;
    }
}
