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
            'division.*' => 'uuid|exists:divisions,id',
            'date_id.*' => 'required|uuid|exists:dates,id',
            'time.*' => 'required|integer|min:0|max:23',
            'online.*' => 'required|boolean',
        ];
    }

    public function messages(): array
    {
        return [
            'date_id.*.required' => 'Date is required',
            'date_id.*.uuid' => 'Date must be a uuid',
            'date_id.*.exists' => 'Date must be exists',
            'time.*.required' => 'Time is required',
            'time.*.integer' => 'Time must be an integer',
            'time.*.min' => 'Time must be at least 0',
            'time.*.max' => 'Time must be at most 23',
            'online.*.required' => 'Interview mode must be chosen',
            'online.*.boolean' => 'Interview mode must be either onsite / online',
        ];
    }
}
