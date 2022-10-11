<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBox extends FormRequest
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
            'type_box' => 'required|in:card,wallet',
            'unique_name' => empty($this->request->get('id')) ? 'required|max:128|unique:box,unique_name' : 'required|max:128',
            'direction_id' => 'required',
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
            'type_box.required' => 'Поле "Тип бокса" обязательно должно быть заполнено.',
            'type_box.in' => 'Поле "Тип бокса" может иметь значение "card" или "wallet".',
            'unique_name.unique' => 'Поле "Уникальный номер" должно быть уникальным.',
            'unique_name.required' => 'Поле "Уникальный номер" обязательно должно быть заполнено.',
            'unique_name.max' => 'Максимальное значение "Уникальный номер" 128 символов.',
            'direction_id.required' => 'Поле "Направление" обязательно должно быть заполнено.',
        ];
    }
}
