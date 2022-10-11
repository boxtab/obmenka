<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopDestinations extends FormRequest
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
            'descr' => empty($this->request->get('id'))
                ? 'required|max:64|unique:top_destinations,descr'
                : 'required|max:64',
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
            'descr.required'    => 'Поле "Топ направлений" обязательно должно быть заполнено.',
            'descr.max'         => 'Поле "Топ направлений" не должно быть больше 64 символов.',
            'descr.unique'      => 'Поле "Топ направлений" должно быть уникальным.',
        ];
    }
}
