<?php

namespace App\Http\Requests\Address;

use Illuminate\Foundation\Http\FormRequest;

class AddressUpdateRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'address_category_id' => ['sometimes', 'exists:address_categories,id'],
        ];
    }

    /**
     * Custom validation messages.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'Поле "Название" должно быть строкой.',
            'name.max' => 'Поле "Название" не может содержать более 255 символов.',
            'address_category_id.exists' => 'Выбранная "Категория адреса" недействительна.',
        ];
    }
}
