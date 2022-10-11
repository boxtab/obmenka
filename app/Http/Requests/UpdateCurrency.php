<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCurrency extends FormRequest
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
            'id'            => 'required',
            'input_class'   => 'required',
            'input_value'   => 'required',
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
            'id.required'           => 'Ответ сервера. Нет данных от браузера. На сервер не пришел id валюты.',
            'input_class.required'  => 'Ответ сервера. Нет данных от браузера. На сервер не пришел какое поле меняем.',
            'input_value.required'  => 'Ответ сервера. Нет данных от браузера. На сервер не пришел значение поля которое меняем.',
        ];
    }
}
