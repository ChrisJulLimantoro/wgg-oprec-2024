<?php

namespace App\Http\Requests;

use App\Http\Controllers\DocumentType;
use App\Rules\DocumentExistsRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreDocumentRequest extends FormRequest
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
        $documentTypes = array_column(DocumentType::cases(), 'name');
        $rules = [];
        foreach ($documentTypes as $documentType) {
            $allExcludeCurrentType = array_filter($documentTypes, function ($dt) use ($documentType) {
                return $dt !== $documentType;
            });

            $rules[strtolower($documentType)] = [
                'required_without_all:' . strtolower(join(',', $allExcludeCurrentType)),
                new DocumentExistsRule(),
                // ($documentType == DocumentType::Frontline_Test->name) ? File : File::image()->max('5mb'),
                // ($documentType == DocumentType::Frontline_Test->name) ? 'mimes:pdf' : 'mimes:jpg,png',
            ];
            if ($documentType == DocumentType::Frontline_Test->name) {
                $rules[strtolower($documentType)][] = File::types('pdf')->max('5mb');
            } else {
                $rules[strtolower($documentType)][] = File::image()->max('5mb');
            }
        }

        return $rules;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        $documentTypes = DocumentType::cases();
        $messages = [];
        foreach ($documentTypes as $documentType) {
            $messages[strtolower($documentType->name) . '.required_without_all'] = $documentType->value . ' file is required';
            $messages[strtolower($documentType->name) . '.image'] = $documentType->value . ' file must be an image';
            $messages[strtolower($documentType->name) . '.max'] = $documentType->value . ' file size must be less than 5mb';
            $messages[strtolower($documentType->name) . '.mimes'] =
                ($documentType->name == DocumentType::Frontline_Test->name)
                ? $documentType->value . ' file must be a file of type: jpg, png'
                : $documentType->value . ' file must be a file of type: pdf';
        }

        return $messages;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $exception = $validator->getException();

        throw (new $exception($validator))
            ->errorBag($this->errorBag)
            ->redirectTo($this->getRedirectUrl());
    }
}
