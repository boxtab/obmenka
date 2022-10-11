<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBoxBalance extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'balance_date'      => ['required', 'date'],
            'box_id'            => ['required', 'integer'],
//            'balance_amount'    => ['required', 'numeric'],
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
            'balance_date.required'     => 'Поле "Дата" обязательно должно быть заполнено.',
            'box_id.required'           => 'Поле "Счет" обязательно должно быть заполнено.',
            'balance_amount.required'   => 'Поле "Остаток" обязательно должно быть заполнено.',

            'balance_date.date'         => 'Дата остатка должна быть в формате даты.',
            'box_id.integer'            => 'Id остатка должно быть целым числом.',
//            'balance_amount.numeric'    => 'Сумма остатка должно быть вещественным числом.',
        ];
    }
}
