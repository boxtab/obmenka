<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopDestinationsGroup extends FormRequest
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
            'description' =>'required|max:32',
            'month_year' => 'required',
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
            'description.required'    => 'Поле "Группы источников дохода" обязательно должно быть заполнено.',
            'description.max'         => 'Поле "Группы источников дохода" не должно быть больше 32 символов.',
            'month_year.required'     => 'Поле "Месяц, год" должно быть уникальным.',
        ];
    }
}
