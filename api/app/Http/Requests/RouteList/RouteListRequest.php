<?php

namespace App\Http\Requests\RouteList;

use Illuminate\Foundation\Http\FormRequest;

class RouteListRequest extends FormRequest
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
            'delivery_date' => ['required', 'date', 'date_format:Y-m-d H:i:s', 'after:now'],
            'description' => ['max:255'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'user_id' => ['required', 'exists:users,id'],
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
