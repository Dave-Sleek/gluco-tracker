<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSubscriptionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // or implement policy if needed
    }

    public function rules(): array
    {
        return [
            'plan' => 'required|string|in:monthly,yearly,one_time',
            'amount_paid' => 'required|numeric|min:100',
            'start_date' => 'required|numeric',
            'end_date' => 'required|numeric',
            'payment_reference' => 'required|string|unique:subscriptions,payment_reference',
        ];
    }
}
