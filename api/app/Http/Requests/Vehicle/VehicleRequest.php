<?php

namespace App\Http\Requests\Vehicle;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VehicleRequest extends FormRequest
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
            'brand' => ['required', 'max:50'],
            'model' => ['required', 'max:50'],
            'year' => ['required', 'digits:4', 'integer', 'min:1900', 'max:' . date('Y')],
            'vin_number' => ['required', 'max:17'],
            'register_number' => ['required', 'max:9'],
            'max_volume' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'max_weight' => ['required', 'numeric', 'regex:/^\d+(\.\d{1,2})?$/'],
            'vehicle_category_id' => ['required', 'exists:vehicle_categories,id'],
            'body_type_id' => ['required', 'exists:body_types,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'brand.required' => 'Поле "Марка" обязательно для заполнения.',
            'brand.max' => 'Поле "Марка" не должно превышать 50 символов.',

            'model.required' => 'Поле "Модель" обязательно для заполнения.',
            'model.max' => 'Поле "Модель" не должно превышать 50 символов.',

            'year.required' => 'Поле "Год выпуска" обязательно для заполнения.',
            'year.digits' => 'Поле "Год выпуска" должно содержать ровно 4 цифры.',
            'year.integer' => 'Поле "Год выпуска" должно быть числом.',
            'year.min' => 'Поле "Год выпуска" не может быть меньше 1900.',
            'year.max' => 'Поле "Год выпуска" не может быть больше текущего года.',

            'vin_number.required' => 'Поле "VIN-номер" обязательно для заполнения.',
            'vin_number.max' => 'Поле "VIN-номер" не должно превышать 17 символов.',

            'register_number.required' => 'Поле "Регистрационный номер" обязательно для заполнения.',
            'register_number.max' => 'Поле "Регистрационный номер" не должно превышать 9 символов.',

            'max_volume.required' => 'Поле "Максимальный объем" обязательно для заполнения.',
            'max_volume.decimal' => 'Поле "Максимальный объем" должно быть числом с 2 знаками после запятой.',

            'max_weight.required' => 'Поле "Максимальный вес" обязательно для заполнения.',
            'max_weight.decimal' => 'Поле "Максимальный вес" должно быть числом с 2 знаками после запятой.',

            'vehicle_category_id.required' => 'Выберите категорию автомобиля.',
            'vehicle_category_id.exists' => 'Выбранная категория автомобиля недействительна.',

            'body_type_id.required' => 'Выберите тип кузова.',
            'body_type_id.exists' => 'Выбранный тип кузова недействителен.',
        ];
    }

}
