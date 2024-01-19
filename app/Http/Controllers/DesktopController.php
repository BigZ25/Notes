<?php

namespace App\Http\Controllers;

use App\DB\Enum\ParcelStatusEnum;

class DesktopController
{
    public function index()
    {
        $notDeliveredParcelsIds = auth()->user()->parcels->whereIn('status',
            ParcelStatusEnum::notDeliveredList())->get()->pluck('id')->toArray();

        $costsSum = auth()->user()->costs->sum('price');
        $incomesSum = auth()->user()->incomes->sum('price');
        $balance = [
            'costs_sum' => $costsSum,
            'incomes_sum' => $incomesSum,
            'profit' => $incomesSum - $costsSum,
        ];
        $parcels = [
            'without_numeric_data' => auth()->user()->parcels->whereNull('price')->orWhereNull('vat')->orWhereNull('insurance')->count()
        ];
        $auctions = [
            'without_weights' => auth()->user()->auctions()->whereNull('weight')->count(),
            'without_value' => auth()->user()->auctions()->whereNull('value')->count(),
            'not_delivered_value' => (float)auth()->user()->auctions->whereHas('parcel',
                function ($parcelQuery) use ($notDeliveredParcelsIds) {
                    $parcelQuery->whereIn('id', $notDeliveredParcelsIds);
                })->orWhereDoesntHave('parcel')->sum('value')
        ];

        $chart = auth()->user()->monthlySummary()
            ->orderBy('period')
            ->select('period', 'sum_costs', 'sum_incomes', 'balance')
            ->get()
            ->toArray();

        return response()->json([
            'data' => [
                'balance' => $balance,
                'auctions' => $auctions,
                'parcels' => $parcels,
                'chart' => $chart
            ]
        ]);
    }
}
