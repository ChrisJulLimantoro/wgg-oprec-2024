<?php

namespace App\Http\Requests;

use App\Models\Applicant;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        $selectedPriority = $this->route('selected_priority');

        if ($selectedPriority == 1) return true;

        $nrp = strtolower(session('nrp'));
        $applicant = Applicant::select(['priority_division2'])
            ->where('email', $nrp . '@john.petra.ac.id')->first();

        if (!$applicant->priority_division2) return false;

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
            'project' => 'required|string',
        ];
    }
}
