<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class StoreUser extends FormRequest
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
            'surname' => [
                'required', 'min:3', 'max:255',
            ],
            'name' => [
                'required', 'min:3', 'max:255',
            ],
            'patronymic' => [
                'required', 'min:3', 'max:255',
            ],
            'birthday' => [
                'required',
            ],
            'email' => [
                'required', 'email', // Rule::unique((new User)->getTable())->ignore($this->route()->user->id ?? null)
            ],
            'password' => [
                $this->route()->user ? 'nullable' : 'required', 'confirmed', 'min:6'
            ],
            'work' => [
                'required', 'in:yes,no',
            ],
            'role_id' => [
                'required',
            ],
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
            'surname.required'      => 'Поле "Фамилия" обязательно должно быть заполнено.',
            'surname.min'           => 'Поле "Фамилия" не должно быть меньше 3 символов.',
            'surname.max'           => 'Поле "Фамилия" не должно быть больше 255 символов.',

            'name.required'         => 'Поле "Имя" обязательно должно быть заполнено.',
            'name.min'              => 'Поле "Имя" не должно быть меньше 3 символов.',
            'name.max'              => 'Поле "Имя" не должно быть больше 255 символов.',

            'patronymic.required'   => 'Поле "Отчество" обязательно должно быть заполнено.',
            'patronymic.min'        => 'Поле "Отчество" не должно быть меньше 3 символов.',
            'patronymic.max'        => 'Поле "Отчество" не должно быть больше 255 символов.',

            'birthday.required'     => 'Поле "Дата рождения" обязательно должно быть заполнено.',

            'email.required'        => 'Поле "Email" обязательно должно быть заполнено.',

            'password.required'     => 'Поле "Пароль" обязательно должно быть заполнено.',
            'password.min'          => 'Поле "Пароль" не должно быть меньше 6 символов.',

            'work.required'         => 'Поле "Работает" обязательно должно быть заполнено.',
            'work.in'               => 'Поле "Работает" может иметь значения только yes или no.',

            'role_id.required'      => 'Поле "Роль" обязательно должно быть заполнено.',
        ];
    }
}
