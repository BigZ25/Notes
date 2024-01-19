<?php

namespace App\Http\Controllers;

use App\DB\Enum\JapanVatEnum;
use App\DB\Enum\ParcelTypeEnum;
use App\DB\Enum\ParcelStatusEnum;
use App\DB\Enum\UnitEnum;
use App\Libs\OlxApi\OlxApi;
use ReflectionClass;

class StateController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'enums' => [
//                    'JAPAN_VAT_ENUM' => $this->prepareEnumClass(JapanVatEnum::class, JapanVatEnum::getList()),
//                    'PARCEL_TYPE_ENUM' => $this->prepareEnumClass(ParcelTypeEnum::class, ParcelTypeEnum::getList()),
//                    'PARCEL_STATUS_ENUM' => $this->prepareEnumClass(ParcelStatusEnum::class, ParcelStatusEnum::getList()),
//                    'UNIT_ENUM' => $this->prepareEnumClass(UnitEnum::class, UnitEnum::getList()),
                ]
            ]
        ]);
    }

    protected function prepareEnumClass(string $class, array $data, $deleteNotFoundValues = false): array
    {
        $items = [];
        $reflection = new ReflectionClass($class);
        $constants = array_flip($reflection->getConstants());

        $dataShort = [];
        $instance = app($class);
        if (method_exists($instance, 'getShortList')) {
            $dataShort = $instance->getShortList();
        }

        foreach ($constants as $value => $constant) {
            if ($deleteNotFoundValues && !array_key_exists($value, $data)) {
                continue;
            }

            $items[$constant] = [
                'value' => $value,
                'label' => $data[$value] ?? 'Nazwa niezdefiniowana'
            ];

            if (!empty($dataShort)) {
                $items[$constant]['short'] = $dataShort[$value] ?? 'Nazwa niezdefiniowana';
            }
        }

        return $items;
    }
}
