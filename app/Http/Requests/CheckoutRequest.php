<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Enums\PaymentMethod;

class CheckoutRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        $methods = implode(',', array_column(PaymentMethod::cases(), 'value'));

        return [
            'shipping_name'        => ['required', 'string', 'max:255'],
            'shipping_phone'       => ['required', 'string', 'max:20'],
            'shipping_address'     => ['required', 'string', 'max:500'],
            'shipping_city'        => ['required', 'string', 'max:100'],
            'shipping_postal_code' => ['required', 'string', 'max:10'],
            'shipping_province'    => ['required', 'string', 'max:100'],
            'payment_method'       => ['required', "in:$methods"],
        ];
    }
}
