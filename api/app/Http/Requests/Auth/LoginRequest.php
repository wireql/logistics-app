<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Password;

class LoginRequest extends FormRequest
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
            'email' => ['required', 'email', 'exists:users,email', 'max:100'],
            'password' => ['required'],
        ];
    }

    public function messages(): array
    {
        return [
            'email.required' => 'Поле "Электронная почта" обязательно для заполнения.',
            'email.email' => 'Введите корректный адрес Электронной почты.',
            'email.exists' => 'Указанная Электронная почта не зарегистрирована в системе.',
            'email.max' => 'Электронная почта не должен превышать 100 символов.',

            'password.required' => 'Поле "Пароль" обязательно для заполнения.',
        ];
    }
}
