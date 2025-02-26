<?php

namespace App\Http\Requests\Employee;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class EmployeeStoreRequest extends FormRequest
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
            'first_name' => ['required', 'max:100'],
            'middle_name' => ['required', 'max:100'],
            'last_name' => ['required', 'max:100'],
            'email' => ['required', 'email', 'unique:users,email', 'max:100'],
            'password' => ['required', Password::min(6)],
            'user_category_id' => ['required', 'exists:user_categories,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'first_name.required' => 'Имя обязательно для заполнения.',
            'first_name.max' => 'Имя не должно превышать 100 символов.',

            'middle_name.required' => 'Отчество обязательно для заполнения.',
            'middle_name.max' => 'Отчество не должно превышать 100 символов.',

            'last_name.required' => 'Фамилия обязательна для заполнения.',
            'last_name.max' => 'Фамилия не должна превышать 100 символов.',

            'email.required' => 'Email обязателен для заполнения.',
            'email.email' => 'Введите корректный email.',
            'email.unique' => 'Этот email уже используется.',
            'email.max' => 'Email не должен превышать 100 символов.',

            'password.required' => 'Пароль обязателен для заполнения.',
            'password.min' => 'Пароль должен содержать минимум 6 символов.',

            'user_category_id.required' => 'Категория пользователя обязательна.',
            'user_category_id.exists' => 'Выбранная категория пользователя не существует.',
        ];
    }

}
