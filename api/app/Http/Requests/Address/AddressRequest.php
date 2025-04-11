<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressRequest extends FormRequest
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
            'country' => ['required', 'string', 'max:100'],
            'region' => ['required', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'street' => ['required', 'string', 'max:100'],
            'building' => ['required', 'string', 'max:20'],
            'flat' => ['nullable', 'string', 'max:20'],
            'latitude' => ['required', 'nullable', 'numeric'],
            'longitude' => ['required', 'nullable', 'numeric'],
            'address_category_id' => ['required', 'exists:address_categories,id'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'country.required' => 'Страна обязательна для заполнения.',
            'country.string' => 'Страна должна быть строкой.',
            'country.max' => 'Название страны не должно превышать 100 символов.',

            'region.required' => 'Регион обязателен для заполнения.',
            'region.string' => 'Регион должен быть строкой.',
            'region.max' => 'Название региона не должно превышать 100 символов.',

            'city.required' => 'Город обязателен для заполнения.',
            'city.string' => 'Город должен быть строкой.',
            'city.max' => 'Название города не должно превышать 100 символов.',

            'street.required' => 'Улица обязательна для заполнения.',
            'street.string' => 'Улица должна быть строкой.',
            'street.max' => 'Название улицы не должно превышать 100 символов.',

            'building.required' => 'Номер здания обязателен для заполнения.',
            'building.string' => 'Номер здания должен быть строкой.',
            'building.max' => 'Номер здания не должен превышать 20 символов.',

            'flat.string' => 'Номер квартиры должен быть строкой.',
            'flat.max' => 'Номер квартиры не должен превышать 20 символов.',

            'latitude.numeric' => 'Широта должна быть числом.',
            'longitude.numeric' => 'Долгота должна быть числом.',
            'latitude.required' => 'Широта обязателена для заполнения.',
            'longitude.required' => 'Долгота обязателена для заполнения.',

            'address_category_id.required' => 'Категория адреса обязательна.',
            'address_category_id.exists' => 'Выбранная категория адреса недействительна.',
        ];
    }
}
