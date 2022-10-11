<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncomeExpense extends FormRequest
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
            'income_expense'    => 'required',
            'dds_id'            => 'required',
            'box_id'            => 'required',
            'amount'            => 'required',
            'rate'              => 'required',
            'note'              => 'required',
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
            'income_expense.required'   => 'Поле "Приход/расход" обязательно должно быть заполнено.',
            'dds_id.required'           => 'Поле "Код ДДС" обязательно должно быть заполнено.',
            'box_id.required'           => 'Поле "Бокс" обязательно должно быть заполнено.',
            'amount.required'           => 'Поле "Сумма" обязательно должно быть заполнено.',
            'rate.required'             => 'Поле "Курс" обязательно должно быть заполнено.',
            'note.required'             => 'Поле "Комментарий" обязательно должно быть заполнено.',
        ];
    }
}
