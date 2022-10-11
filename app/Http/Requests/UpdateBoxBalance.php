<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBoxBalance extends FormRequest
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
            'id'        => ['required', 'integer'],
            'amount'    => ['required', 'numeric'],
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
            'id.required'       => 'Ответ сервера. Нет данных от браузера. На сервер не пришел id остатка.',
            'amount.required'   => 'Ответ сервера. Нет данных от браузера. На сервер не пришла сумма которую нужно измнить для остатка.',
            'id.integer'        => 'Id остатка должно быть целым числом.',
            'amount.numeric'    => 'Сумма остатка должно быть вещественным числом.',
        ];
    }
}
