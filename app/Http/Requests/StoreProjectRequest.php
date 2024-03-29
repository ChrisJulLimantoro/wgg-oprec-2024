<?php

namespace App\Http\Requests;

use App\Http\Controllers\ProjectController;
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

        $nrp = strtolower(session('nrp'));
        $applicant = Applicant::with(['priorityDivision1', 'priorityDivision2'])
            ->select(['id', 'priority_division1', 'priority_division2'])
            ->where('email', $nrp . '@john.petra.ac.id')
            ->first()->toArray();

        if (!$applicant['priority_division2'] && $selectedPriority == 2) return false;

        $deadline = ProjectController::getProjectDeadline($applicant, $nrp, $selectedPriority);
        $nowTimestamp = now('Asia/Jakarta')->getTimestamp();

        if ($nowTimestamp > $deadline) return false;

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
            'project' => 'nullable|string|url:https,http',
        ];
    }
}
