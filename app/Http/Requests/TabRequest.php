<?php

namespace App\Http\Requests;

use App\DB\Enum\ColorsEnum;
use Illuminate\Foundation\Http\FormRequest;

class TabRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => stringRules(),
        ];
    }
}
