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
            'plan_delivery' => ['required', 'date'],
            'description' => ['max:255'],
            'vehicle_id' => ['required', 'exists:vehicles,id'],
            'user_id' => ['required', 'exists:users,id'],
        ];
    }
}
