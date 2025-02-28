<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;

class VehicleUpdateRequest extends FormRequest
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
            'brand' => ['sometimes', 'max:50'],
            'model' => ['sometimes', 'max:50'],
            'year' => ['sometimes', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'vin_number' => ['sometimes', 'max:17'],
            'register_number' => ['sometimes', 'max:9'],
            'max_volume' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'max_weight' => ['sometimes', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'vehicle_status_id' => ['sometimes', 'exists:vehicle_statuses,id'],
            'vehicle_category_id' => ['sometimes', 'exists:vehicle_categories,id'],
            'body_type_id' => ['sometimes', 'exists:body_types,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'brand.max' => 'Название бренда не должно превышать 50 символов.',
            'model.max' => 'Название модели не должно превышать 50 символов.',

            'year.digits' => 'Год должен состоять из 4 цифр.',
            'year.integer' => 'Год должен быть числом.',
            'year.min' => 'Год не может быть меньше 1900.',
            'year.max' => 'Год не может быть больше текущего.',

            'vin_number.max' => 'VIN-номер не может превышать 17 символов.',

            'register_number.max' => 'Регистрационный номер не может превышать 9 символов.',

            'max_volume.numeric' => 'Максимальный объем должен быть числом.',
            'max_volume.regex' => 'Максимальный объем должен содержать не более двух знаков после запятой.',

            'max_weight.numeric' => 'Максимальный вес должен быть числом.',
            'max_weight.regex' => 'Максимальный вес должен содержать не более двух знаков после запятой.',

            'vehicle_status_id.exists' => 'Выбранный статус автомобиля недействителен.',
            'vehicle_category_id.exists' => 'Выбранная категория автомобиля недействительна.',
            'body_type_id.exists' => 'Выбранный тип кузова недействителен.',
        ];
    }
}
