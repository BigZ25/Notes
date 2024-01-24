<?php

namespace App\Http\Requests;

use App\DB\Enum\ColorsEnum;
use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'tab_id' => foreignKeyRules('tabs'),
            'title' => stringRules(false),
            'content' => stringRules(false),
            'color' => enumRules(ColorsEnum::class),
            'pos_x' => integerRules(),
            'pos_y' => integerRules(),
            'pos_z' => integerRules(),
            'width' => integerRules(),
            'height' => integerRules()
        ];
    }
}
