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
            'address_id' => ['required', 'exists:addresses,id'],
            'delivery_date' => ['date', 'date_format:Y-m-d H:i:s'],
            'route_point_status_id' => ['exists:route_point_statuses,id'],
            'route_point_category_id' => ['required', 'exists:route_point_categories,id'],
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
