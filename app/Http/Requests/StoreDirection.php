<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDirection extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(Request $request): array
    {
        return [
            'payment_system_id' => [
                'required',
                Rule::unique('direction')->ignore($request->id)->where(function ($query) use ($request) {
                    return $query->where('payment_system_id', $request->payment_system_id)
                        ->where('currency_id', $request->currency_id);
                })
            ],
            'currency_id' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'payment_system_id.required' => 'Поле "Платежная система" обязательно должно быть заполнено.',
            'payment_system_id.unique' => 'Платежная система и код валюты должны быть уникальными',
            'currency_id.required' => 'Поле "Код валюты" обязательно должно быть заполнено.',
        ];
    }
}
