<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOffer extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'left_box_id'   => 'required',
            'left_amount'   => 'required',
            'right_box_id'  => 'required',
            'right_amount'  => 'required',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'left_box_id.required'  => 'Поле "Левый бокс" обязательно должно быть заполнено.',
            'left_amount.required'  => 'Поле "Сумма на вход" обязательно должно быть заполнено.',
            'right_box_id.required' => 'Поле "Правый бокс" обязательно должно быть заполнено.',
            'right_amount.required' => 'Поле "Сумма на выход" обязательно должно быть заполнено.',
        ];
    }
}
