<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReportProfitDay extends FormRequest
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
            'filter_date' => 'required',
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
            'filter_date.required'  => 'Поле "Дата фильтра" обязательно должно быть заполнено.',
        ];
    }
}
