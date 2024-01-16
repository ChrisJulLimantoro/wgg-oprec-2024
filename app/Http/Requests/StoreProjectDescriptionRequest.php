<?php

namespace App\Http\Requests;

use App\Models\Division;
use Illuminate\Foundation\Http\FormRequest;

class StoreProjectDescriptionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        if ($this->userHasFullAccess()) {
            return true;
        }

        return $this->updatingOwnDivision();
    }

    public function prepareForValidation(): void
    {
        $this->merge([
            'project_deadline' => ($this->project_deadline) ? $this->project_deadline * 3600 : null,
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'project' => 'required_with:project_deadline|string',
            'project_deadline' => 'required_with:project|integer|min:1',
        ];
    }

    private function userHasFullAccess(): bool
    {
        $userDivisionId = session('division_id');
        $divisionSlugsWithFullAccess = ['bph', 'it'];
        $divisionIdsWithFullAccess = Division::whereIn('slug', $divisionSlugsWithFullAccess)->pluck('id')->toArray();

        return in_array($userDivisionId, $divisionIdsWithFullAccess);
    }

    private function updatingOwnDivision(): bool
    {
        $userDivisionId = session('division_id');
        $pageDivision = $this->route()->parameter('division');

        return $pageDivision && $userDivisionId == $pageDivision->id;
    }
}
