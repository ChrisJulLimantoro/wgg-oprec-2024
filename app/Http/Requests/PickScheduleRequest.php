<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class PickScheduleRequest extends FormRequest
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
            'time' => 'required',
            'online' => 'required',
            'date_id' => 'required',
            'division' => 'required',
            'division.*' => 'uuid|exists:divisions,id',
            'date_id.*' => 'uuid|exists:dates,id',
            'time.*' => 'integer|min:0|max:23',
            'online.*' => 'boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'time.required' => 'Time is required',
            'date_id.required' => 'Date is required',
            'online.required' => 'Interview mode must be chosen',
            'date_id.*.uuid' => 'Date must be a uuid',
            'date_id.*.exists' => 'Date must be exists',
            'time.*.integer' => 'Time must be an integer',
            'time.*.min' => 'Time must be at least 0',
            'time.*.max' => 'Time must be at most 23',
            'online.*.boolean' => 'Interview mode must be either onsite / online',
        ];
    }
}
