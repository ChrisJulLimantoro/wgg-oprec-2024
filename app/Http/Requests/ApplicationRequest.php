<?php

namespace App\Http\Requests;

use App\Http\Controllers\Religion;
use App\Http\Controllers\Diet;
use App\Models\Applicant;
use Illuminate\Foundation\Http\FormRequest;

class ApplicationRequest extends FormRequest
{
    private Applicant $model;
    private const NON_UPDATABLE_FIELDS = [
        'name', 
        'email', 
        'motivation', 
        'commitment', 
        'strength', 
        'weakness', 
        'experience', 
        'astor',
        'priority_division1',
        'priority_division2',
        'stage', 
    ];


    public function __construct(Applicant $model)
    {
        $this->model = $model;
    }
    
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        if ($this->has('astor')) {
            $this->merge([
                'astor' => true,
            ]);
        } else {
            $this->merge([
                'astor' => false,
            ]);
        }

        if (!$this->has('stage')) {
            $this->merge([
                'stage' => 2,
            ]);
        }

        if ($this->has('id')) {
            foreach (self::NON_UPDATABLE_FIELDS as $field) {
                $this->offsetUnset($field);
            }
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = $this->model->validationRules();
        $rules['priority_division1'] .= '|astor';
        $rules['priority_division2'] .= '|astor';
        $rules['religion'] = '|in:' . join(',', self::enumValues(Religion::class));
        $rules['diet'] = '|in:' . join(',', self::enumValues(Diet::class));

        if ($this->has('id')) {
            foreach (self::NON_UPDATABLE_FIELDS as $field) {
                unset($rules[$field]);
            }
        }

        return $rules;
    }

    public function messages()
    {
        $messages = $this->model->validationMessages();
        $messages['priority_division1.astor'] = 'Divisi prioritas 1 Astor harus Peran';
        $messages['priority_division2.astor'] = 'Divisi prioritas 2 Astor harus kosong';

        if ($this->has('id')) {
            foreach (self::NON_UPDATABLE_FIELDS as $field) {
                unset($messages[$field]);
            }
        }

        return $messages;
    }

    private static function enumValues($enum)
    {
        return array_column($enum::cases(), 'name');
    }
}
