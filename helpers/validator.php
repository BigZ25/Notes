<?php


function stringRules($required = true, int $length = 255): array
{
    return [
        ($required === true ? 'required' : 'nullable'),
        'string',
        'max:' . $length,
    ];
}


function integerRules($required = true, $min = null, $max = null, $gt = null): array
{
    $rules = [
        ($required === true ? 'required' : 'nullable'),
        'integer',
    ];

    if ($min !== null) {
        $rules[] = 'min:' . $min;
    }

    if ($max !== null) {
        $rules[] = 'max:' . $max;
    }

    if ($gt !== null) {
        $rules[] = 'gt:' . $gt;
    }

    return $rules;
}

function enumRules($class, $required = true): array
{
    $rules = [
        ($required === true ? 'required' : 'nullable'),
        'integer',
        'in:' . implode(',', array_keys($class::getList())),
    ];

    return $rules;
}


function emailRules($required = true, int $length = 255): array
{
    return [
        ($required === true ? 'required' : 'nullable'),
        'email',
        'max:' . $length,
    ];
}
