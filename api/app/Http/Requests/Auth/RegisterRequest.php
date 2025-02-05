<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'max:255'],
            'last_name' => ['required', 'max:255'],
            'company_name' => ['required', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:100'],
            'password' => ['required', 'confirmed', Password::min(6)],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Поле "Имя" обязательно для заполнения.',
            'first_name.max' => 'Поле "Имя" не должно превышать 255 символов.',

            'last_name.required' => 'Поле "Фамилия" обязательно для заполнения.',
            'last_name.max' => 'Поле "Фамилия" не должно превышать 255 символов.',

            'company_name.required' => 'Поле "Название компании" обязательно для заполнения.',
            'company_name.max' => 'Поле "Название компании" не должно превышать 255 символов.',

            'email.required' => 'Поле "Электронная почта" обязательно для заполнения.',
            'email.email' => 'Введите корректный адрес Электронной почты',
            'email.unique' => 'Эта Электронная почта уже зарегистрирована.',
            'email.max' => 'Электронная почта не должен превышать 100 символов.',

            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
            'password.confirmed' => 'Пароли не совпадают.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',
        ];
    }

}
