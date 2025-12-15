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
            'shipping_address' => ['required', 'string', 'max:500'],
            'payment_method'   => ['required', "in:$methods"],
        ];
    }
}
