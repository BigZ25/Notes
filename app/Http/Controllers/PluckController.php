<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Pluck\Pluck;
use App\Http\Controllers\Pluck\PluckAdverts;
use App\Http\Controllers\Pluck\PluckAuctions;
use App\Http\Controllers\Pluck\PluckCosts;
use App\Http\Controllers\Pluck\PluckIncomes;
use App\Http\Controllers\Pluck\PluckParcels;
use Illuminate\Support\Facades\Schema;

class PluckController extends Controller
{
    public function index()
    {
        $entity = request()->input('entity') ?? null;
        $columns = request()->input('columns') ?? [];
        $filters = request()->input('filters') ?? [];
        $class = Pluck::class;

        switch ($entity) {
            case 'adverts':
                $class = PluckAdverts::class;
                break;
            case 'auctions':
                $class = PluckAuctions::class;
                break;
            case 'parcels':
                $class = PluckParcels::class;
                break;
            case 'incomes':
                $class = PluckIncomes::class;
                break;
            case 'costs':
                $class = PluckCosts::class;
                break;

        }

        $query = $class::handleRequest($columns, $filters);

        array_merge($columns, array_keys($query->getEagerLoads()));

        if (!empty($columns)) {
            $modelColumns = array_intersect($columns, Schema::getColumnListing($query->getModel()->getTable()));
            $extraColumns = array_diff($columns, $modelColumns);
            $data = array_map(function ($item) use ($columns) {
                return array_intersect_key($item, array_flip($columns));
            }, $query->get()->append($extraColumns)->toArray());
        } else {
            $data = $query->get()->toArray();
        }

        return response()->json(['data' => $data]);
    }
}
