<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class StoreClient extends FormRequest
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
            'fullname'  => 'min:1|max:255|required|unique:clients,fullname,' . $this->id,
            'email'     => 'min:5|max:255|email|unique:clients,email,' . $this->id,
            'phone'     => 'min:1|max:18|unique:clients,phone,' . $this->id,
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
            'fullname.required' => 'Поле "ФИО" обязательно должно быть заполнено.',
            'fullname.min'      => 'Поле "ФИО"  должно быть больше 1 символа.',
            'fullname.max'      => 'Поле "ФИО"  должно быть меньше 255 символов.',
            'fullname.unique'   => 'Поле "ФИО" должно быть уникальным.',

            'email.unique'      => 'Поле "Email" должно быть уникальным.',
            'email.min'         => 'Поле "Email"  должно быть больше 5 символов.',
            'email.max'         => 'Поле "Email"  должно быть меньше 255 символов.',

            'phone.unique'      => 'Поле "Телефон" должно быть уникальным.',
            'phone.min'         => 'Поле "Телефон" должно быть больше 1 символа.',
            'phone.max'         => 'Поле "Телефон" должно быть меньше 18 символов.',
        ];
    }
}
