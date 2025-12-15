<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'items'              => ['required', 'array'],
            'items.*.id'         => ['required', 'exists:cart_items,id'],
            'items.*.quantity'   => ['required', 'integer', 'min:0'],
        ];
    }
}
