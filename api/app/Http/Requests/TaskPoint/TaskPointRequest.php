<?php

namespace App\Http\Requests\TaskPoint;

use Illuminate\Foundation\Http\FormRequest;

class TaskPointRequest extends FormRequest
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
            'plan_delivery' => ['required', 'date'],
        ];
    }
}
