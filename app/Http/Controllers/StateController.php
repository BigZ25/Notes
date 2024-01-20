<?php

namespace App\Http\Controllers;

use App\DB\Enum\ColorsEnum;
use ReflectionClass;

class StateController extends Controller
{
    public function index()
    {
        return response()->json([
            'data' => [
                'enums' => [
                    'COLORS_ENUM' => $this->prepareEnumClass(ColorsEnum::class, ColorsEnum::getList()),
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
