@extends('admin.layout')
@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <h1 class="text-center text-4xl uppercase font-bold mb-2">Medical Form</h1>
</div>
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <div class="w-full px-6">
        <form data-te-validation-init
        action="{{ route('admin.medical-form.update', $admin['id']) }}"
        method="POST" id="medical-form">
        @csrf
        <div class="relative mb-6" data-te-validate="input"
            @error('diseases') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
            @error('diseases.*') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
            <div class="pl-1 mb-1">Apakah Anda memiliki riwayat penyakit berikut ?</div>
            <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
            <select data-te-select-init name="diseases[]" multiple>
                @php
                    $submittedDiseases = array_column(data_get($admin, 'diseases', []), 'id');
                @endphp
                @foreach ($diseases as $disease)
                    <option value="{{ $disease['id'] }}" class="w-full text-wrap"
                        @if (
                            (!empty(old('diseases')) && in_array($disease['id'], old('diseases'))) ||
                                in_array($disease['id'], $submittedDiseases)) selected @endif>
                        {{ $disease['name'] }}
                    </option>
                @endforeach
            </select>
            <label data-te-select-label-ref>Past Diseases</label>
        </div>

        <div>
            <div class="pl-1 mb-1">Penyakit lain-lain yang tidak disebutkan (jika ada luka yang baru
                didapat, bisa
                disebutkan)
            </div>
            <div class="relative mb-6" data-te-validate="input"
                @error('medical_history.other_disease') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                data-te-input-wrapper-init>
                <textarea
                    {{ empty(old('medical_history.other_disease')) && !array_key_exists('medical_history', $admin) ? '' : 'data-te-input-state-active' }}
                    class="peer block min-h-[auto] w-full rounded border-0 px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                    id="exampleFormControlTextarea13" rows="2" placeholder="penyakit lain-lain" name="medical_history[other_disease]">{{ old('medical_history.other_disease') ?? (data_get($admin, 'medical_history.other_disease') ?? '') }}</textarea>
                <label for="exampleFormControlTextarea13"
                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                    Other Diseases
                </label>
            </div>
        </div>

        <div>
            <div class="pl-1 mb-1">Beri penjelasan mengenai riwayat penyakit / penyakit yang kalian
                punya (contoh : asma
                karena…, dislokasi karena…)
            </div>
            <div class="relative mb-6" data-te-validate="input"
                @error('medical_history.disease_explanation') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                data-te-input-wrapper-init>
                <textarea
                    {{ empty(old('medical_history.disease_explanation')) && !array_key_exists('medical_history', $admin) ? '' : 'data-te-input-state-active' }}
                    class="peer block min-h-[auto] w-full rounded border-0 px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                    id="exampleFormControlTextarea13" rows="2" placeholder="" name="medical_history[disease_explanation]">{{ old('medical_history.disease_explanation') ?? (data_get($admin, 'medical_history.disease_explanation') ?? '') }}</textarea>
                <label for="exampleadminControlTextarea13"
                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                    Disease Explantion
                </label>
            </div>
        </div>

        <div>
            <div class="pl-1 mb-1">Apakah Anda memiliki alergi obat? Jika ya, sebutkan, jika tidak
                silahkan mengisi “-”</div>
            <div class="relative mb-8" data-te-validate="input"
                @error('medical_history.medication_allergy') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                data-te-input-wrapper-init>
                <textarea
                    {{ empty(old('medical_history.medication_allergy')) && !array_key_exists('medical_history', $admin) ? '' : 'data-te-input-state-active' }}
                    class="peer block min-h-[auto] w-full rounded border-0 px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                    id="exampleFormControlTextarea13" rows="2" placeholder="" name="medical_history[medication_allergy]">{{ old('medical_history.medication_allergy') ?? (data_get($admin, 'medical_history.medication_allergy') ?? '') }}</textarea>
                <label for="exampleFormControlTextarea13"
                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                    Medication Allergy
                </label>
            </div>
        </div>
        <button type="submit"
            class="inline-block w-full rounded bg-[#e59980] px-6 pb-2 pt-2 mt-2 text-md font-medium uppercase leading-normal transition duration-150 ease-in-out hover:bg-[#ba7d68] focus:bg-[#ba7d68]  focus:outline-none focus:ring-0 active:bg-primary-700"
            data-te-ripple-init data-te-ripple-color="light">
            SUBMIT
        </button>
        </form>
    </div>
</div>
@endsection()
@section('script')
<script>
    $(document).ready(() => {
        $('form[data-te-validation-init]').attr('data-te-validated', true);
        $('input[data-te-input-state-active] ~ div').attr('data-te-input-state-active', true);
        $('textarea[data-te-input-state-active] ~ div').attr('data-te-input-state-active', true);
        @if (session()->has('success'))
            Swal.fire({
                title: 'Success!',
                text: 'Medical form has been updated',
                icon: 'success',
                timer: 2000,
            });
        @endif
    });
</script>
@endsection