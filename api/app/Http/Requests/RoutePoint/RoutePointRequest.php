<?php

namespace App\Http\Requests\RoutePoint;

use Illuminate\Foundation\Http\FormRequest;

class RoutePointRequest extends FormRequest
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
            'address_from_id' => ['required', 'exists:addresses,id'],
            'address_to_id' => ['required', 'exists:addresses,id'],
            'delivery_date' => ['required', 'date', 'date_format:Y-m-d H:i:s'],
        ];
    }

    protected function prepareForValidation()
    {
        if ($this->has('delivery_date')) {
            $this->merge([
                'delivery_date' => \Carbon\Carbon::parse($this->delivery_date)->format('Y-m-d H:i:s'),
            ]);
        }
    }
}
