<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\ValidatorAwareRule;
use Illuminate\Validation\Validator;

class DocumentExistsRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $applicantDocuments = request()->route('applicant')->documents;

        if ($applicantDocuments && array_key_exists($attribute, $applicantDocuments)) {
            $fail('You cannot upload the same document twice');
        }
    }
}
