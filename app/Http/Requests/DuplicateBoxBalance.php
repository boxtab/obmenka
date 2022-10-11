<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DuplicateBoxBalance extends FormRequest
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
//            'acceptor_date' => 'required',
            'donor_date'    => 'required',
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
//            'acceptor_date.required' => 'Не указана дата в фильтре.',
            'donor_date.required'    => 'Не указана дата клонирования.',
        ];
    }
}
