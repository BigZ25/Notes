<?php

namespace App\Http\Controllers\Pluck;

use App\DB\Models\Auction;

class PluckAuctions implements Pluck
{
    public static function handleRequest($columns, $filters)
    {
        $query = Auction::query()->where('user_id', '=', auth()->user()->id);

        if (!empty($filters)) {
            if (array_key_exists('id', $filters)) {
                $query = $query->where('id', $filters['id']);
            }

            if (array_key_exists('parcel_id', $filters)) {
                $query = $query->whereHas('parcel', function ($query) use ($filters) {
                    $query->where('parcels.id', '=', $filters['parcel_id']);
                });
            }

            if (array_key_exists('not_packed', $filters) && (bool)$filters['not_packed'] === true) {
                if (array_key_exists('parcel_id', $filters)) {
                    $query = $query->orDoesntHave('parcel');
                } else {
                    $query = $query->doesntHave('parcel');
                }
            }

            if (array_key_exists('packed', $filters) && $filters['packed'] !== null) {
                if ((bool)$filters['packed'] === true) {
                    if (array_key_exists('parcel_id', $filters)) {
                        $query = $query->orHas('parcel');
                    } else {
                        $query = $query->has('parcel');
                    }
                } elseif ((bool)$filters['packed'] === false) {
                    if (array_key_exists('parcel_id', $filters)) {
                        $query = $query->orDoesntHave('parcel');
                    } else {
                        $query = $query->doesntHave('parcel');
                    }
                }
            }
        }

        return $query;
    }
}
