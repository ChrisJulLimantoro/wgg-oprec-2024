<?php

namespace App\Rules;

use App\Models\Division;
use Closure;
use Illuminate\Contracts\Validation\DataAwareRule;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Contracts\Validation\ValidationRule;

class AstorDivisionRule implements ValidationRule, DataAwareRule
{
    /**
     * The data under validation.
     *
     * @var array<string, mixed>
     */
    protected array $data = [];

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $isAstor = $this->data['astor'];

        if (!$isAstor) {
            return;
        }
        
        $peran = Division::where('name', 'Peran')->first();

        if ($attribute === 'priority_division1' && $value !== $peran->id) {
            $fail('Divisi prioritas 1 Astor harus Peran');
        }
        if ($attribute === 'priority_division2' && $value !== null) {
            $fail('Divisi prioritas 2 Astor harus kosong');
        }
    }

    /**
     * Set the data under validation.
     *
     * @param  array<string, mixed>  $data
     */
    public function setData(array $data): static
    {
        $this->data = $data;

        return $this;
    }
}
