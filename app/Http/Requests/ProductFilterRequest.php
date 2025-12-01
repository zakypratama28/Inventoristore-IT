<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductFilterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'q'         => 'nullable|string|max:255',
            'price_min' => 'nullable|numeric|min:0',
            'price_max' => 'nullable|numeric|min:0',
            'sort_by'   => 'nullable|in:name,price',
            'sort_dir'  => 'nullable|in:asc,desc',
        ];
    }

    public function filters(): array
    {
        return $this->only([
            'q',
            'price_min',
            'price_max',
            'sort_by',
            'sort_dir',
        ]);
    }
}
