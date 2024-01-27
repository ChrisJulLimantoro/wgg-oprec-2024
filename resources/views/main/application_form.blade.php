@extends('main.layout')

@section('content')
    @include('main.stepper', ['applicant' => $form])

    <h1 class="text-3xl font-bold text-center text-white">Biodata Pendaftar</h1>
    <section class="max-w-[940px] mx-auto pt-3 pb-16">
        <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
        <div
            class="block rounded-xl bg-white/10 backdrop-blur-md p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
            <form data-te-validation-init
                action="{{ !array_key_exists('id', $form) ? route('applicant.application.store') : route('applicant.application.update', ['id' => $form['id']]) }}"
                method="POST" id="application-form">
                @csrf
                @if (array_key_exists('id', $form))
                    @method('PATCH')
                @endif

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    {{-- {{ array_key_exists('name', $form) }} --}}
                    <div class="relative mb-8" data-te-validate="input"
                        @error('name') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('name') ?? ($form['name'] ?? '') }}"
                            {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                            {{ empty(old('name')) && !array_key_exists('name', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="Nama Lengkap"
                            name="name" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Nama Lengkap
                        </label>
                        <small data-te-invalid-feedback></small>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('email') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('email') ?? ($form['email'] ?? '') }}"
                            {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                            {{ empty(old('email')) && !array_key_exists('email', $form) ? '' : 'data-te-input-state-active readonly' }}
                            class="peer block min-h-[auto] w-full rounded border-0 {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0 !disabled:bg-white/50"
                            id="exampleInput124" aria-describedby="emailHelp124" placeholder="Email" name="email" />
                        <label for="exampleInput124"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Email
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('major_id') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                        <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
                        <select data-te-select-init name="major_id" {{ array_key_exists('id', $form) ? 'disabled' : '' }}>
                            <option value="" selected disabled></option>
                            @foreach ($majors as $major)
                                <option
                                    {{ old('major_id') === $major->id || data_get($form, 'major_id', '-1') === $major->id ? 'selected' : '' }}
                                    value="{{ $major->id }}">{{ $major->name }}</option>
                            @endforeach
                        </select>
                        <label data-te-select-label-ref>Jurusan</label>
                    </div>
                    <div class="relative mb-8" data-te-validate="input"
                        @error('gpa') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('gpa') ?? ($form['gpa'] ?? '') }}"
                            {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                            {{ empty(old('gpa')) && !array_key_exists('gpa', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput126" placeholder="IPK Terakhir" name="gpa" />
                        <label for="exampleInput126"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                            IPK Terakhir (ex: 3.87)
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('gender') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                        <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
                        <select data-te-select-init name="gender">
                            <option value="" selected disabled></option>
                            <option value="0"
                                {{ old('gender') === '0' || data_get($form, 'gender', '-1') === 0 ? 'selected' : '' }}>
                                Laki-laki</option>
                            <option value="1"
                                {{ old('gender') === '1' || data_get($form, 'gender', '-1') === 1 ? 'selected' : '' }}>
                                Perempuan</option>
                        </select>
                        <label data-te-select-label-ref>Jenis Kelamin</label>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('religion') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                        <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
                        <select data-te-select-init name="religion">
                            <option value="" selected disabled></option>
                            @foreach ($religions as $religion)
                                <option value="{{ $religion }}"
                                    {{ old('religion') == $religion || data_get($form, 'religion', '-1') === $religion ? 'selected' : '' }}>
                                    {{ $religion }}</option>
                            @endforeach
                        </select>
                        <label data-te-select-label-ref>Agama</label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('birthplace') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('birthplace') ?? ($form['birthplace'] ?? '') }}"
                            {{ empty(old('birthplace')) && !array_key_exists('birthplace', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="Tempat Lahir"
                            name="birthplace" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Tempat Lahir
                        </label>
                    </div>

                    <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
                    <div class="relative mb-8" data-te-validate="input"
                        @error('birthdate') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-datepicker-init data-te-input-wrapper-init data-te-format="yyyy-mm-dd">
                        <input type="text" value="{{ old('birthdate') ?? ($form['birthdate'] ?? '') }}"
                            {{ empty(old('birthdate')) && !array_key_exists('birthdate', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            placeholder="Tanggal Lahir" name="birthdate" />
                        <label for="floatingInput"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Tanggal Lahir (yyyy-mm-dd)
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('province') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('province') ?? ($form['province'] ?? '') }}"
                            {{ empty(old('province')) && !array_key_exists('province', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="Provinsi" name="province" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Provinsi
                        </label>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('city') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('city') ?? ($form['city'] ?? '') }}"
                            {{ empty(old('city')) && !array_key_exists('city', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="Kota/Kabupaten"
                            name="city" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Kota/Kabupaten
                        </label>
                    </div>
                </div>

                <div class="relative mb-8" data-te-validate="input"
                    @error('address') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                    data-te-input-wrapper-init>
                    <input type="text" value="{{ old('address') ?? ($form['address'] ?? '') }}"
                        {{ empty(old('address')) && !array_key_exists('address', $form) ? '' : 'data-te-input-state-active' }}
                        class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleInput125" placeholder="Alamat" name="address" />
                    <label for="exampleInput125"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-neutral-200">
                        Alamat
                    </label>
                </div>

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('postal_code') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('postal_code') ?? ($form['postal_code'] ?? '') }}"
                            {{ empty(old('postal_code')) && !array_key_exists('postal_code', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="Kode Pos"
                            name="postal_code" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Kode Pos
                        </label>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('phone') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('phone') ?? ($form['phone'] ?? '') }}"
                            {{ empty(old('phone')) && !array_key_exists('phone', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="No HP" name="phone" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            No HP
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-3 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('line') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('line') ?? ($form['line'] ?? '') }}"
                            {{ empty(old('line')) && !array_key_exists('line', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="ID Line" name="line" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            ID Line
                        </label>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('instagram') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('instagram') ?? ($form['instagram'] ?? '') }}"
                            {{ empty(old('instagram')) && !array_key_exists('instagram', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="Instagram"
                            name="instagram" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Instagram
                        </label>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('tiktok') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('tiktok') ?? ($form['tiktok'] ?? '') }}"
                            {{ empty(old('tiktok')) && !array_key_exists('tiktok', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="TikTok" name="tiktok" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            TikTok
                        </label>
                    </div>
                </div>

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('diet') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                        <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
                        <select data-te-select-init name="diet">
                            <option value="" selected disabled></option>
                            @foreach ($diets as $diet)
                                <option value="{{ $diet }}"
                                    {{ old('diet') === $diet || data_get($form, 'diet', '-1') === $diet ? 'selected' : '' }}>
                                    {{ $diet }}</option>
                            @endforeach
                        </select>
                        <label data-te-select-label-ref>Jenis Makanan</label>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('allergy') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                        data-te-input-wrapper-init>
                        <input type="text" value="{{ old('allergy') ?? ($form['allergy'] ?? '') }}"
                            {{ empty(old('allergy')) && !array_key_exists('allergy', $form) ? '' : 'data-te-input-state-active' }}
                            class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                            id="exampleInput123" aria-describedby="emailHelp123" placeholder="Alergi" name="allergy" />
                        <label for="emailHelp123"
                            class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                            Alergi
                        </label>
                    </div>
                </div>

                <div class="relative mb-8" data-te-validate="input"
                    @error('motivation') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                    data-te-input-wrapper-init>
                    <textarea {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                        {{ empty(old('motivation')) && !array_key_exists('motivation', $form) ? '' : 'data-te-input-state-active' }}
                        class="peer block min-h-[auto] w-full rounded border-0 {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlTextarea13" rows="2" placeholder="Motivasi" name="motivation">{{ old('motivation') ?? ($form['motivation'] ?? '') }}</textarea>
                    <label for="exampleFormControlTextarea13"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                        Motivasi
                    </label>
                </div>

                <div class="relative mb-8" data-te-validate="input"
                    @error('commitment') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                    data-te-input-wrapper-init>
                    <textarea {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                        {{ empty(old('commitment')) && !array_key_exists('commitment', $form) ? '' : 'data-te-input-state-active' }}
                        class="peer block min-h-[auto] w-full rounded border-0 {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlTextarea13" rows="2" placeholder="Komitmen" name="commitment">{{ old('commitment') ?? ($form['commitment'] ?? '') }}</textarea>
                    <label for="exampleFormControlTextarea13"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                        Komitmen
                    </label>
                </div>

                <div class="relative mb-8" data-te-validate="input"
                    @error('strength') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                    data-te-input-wrapper-init>
                    <textarea {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                        {{ empty(old('strength')) && !array_key_exists('strength', $form) ? '' : 'data-te-input-state-active' }}
                        class="peer block min-h-[auto] w-full rounded border-0 {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlTextarea13" rows="2" placeholder="Kelebihan" name="strength">{{ old('strength') ?? ($form['strength'] ?? '') }}</textarea>
                    <label for="exampleFormControlTextarea13"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                        Kelebihan
                    </label>
                </div>

                <div class="relative mb-8" data-te-validate="input"
                    @error('weakness') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                    data-te-input-wrapper-init>
                    <textarea {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                        {{ empty(old('weakness')) && !array_key_exists('weakness', $form) ? '' : 'data-te-input-state-active' }}
                        class="peer block min-h-[auto] w-full rounded border-0 {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlTextarea13" rows="2" placeholder="Kekurangan" name="weakness">{{ old('weakness') ?? ($form['weakness'] ?? '') }}</textarea>
                    <label for="exampleFormControlTextarea13"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                        Kekurangan
                    </label>
                </div>

                <div class="relative mb-8" data-te-validate="input"
                    @error('experience') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                    data-te-input-wrapper-init>
                    <textarea {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                        {{ empty(old('experience')) && !array_key_exists('experience', $form) ? '' : 'data-te-input-state-active' }}
                        class="peer {{ array_key_exists('id', $form) ? 'bg-gray-200' : 'bg-transparent' }} block min-h-[auto] w-full rounded border-0 px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                        id="exampleFormControlTextarea13" rows="2" placeholder="Pengalaman" name="experience">{{ old('experience') ?? ($form['experience'] ?? '') }}</textarea>
                    <label for="exampleFormControlTextarea13"
                        class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary">
                        Pengalaman Organisasi/Panitia
                    </label>
                </div>

                <div class="mb-8 flex min-h-[1.5rem] items-center justify-center pl-[1.5rem]">
                    <input {{ array_key_exists('id', $form) ? 'disabled' : '' }}
                        class="relative {{ array_key_exists('id', $form) ? 'bg-gray-200' : '' }} float-left -ml-[1.5rem] mr-[6px] h-[1.125rem] w-[1.125rem] appearance-none rounded-[0.25rem] border-[0.125rem] border-solid border-neutral-300 outline-none before:pointer-events-none before:absolute before:h-[0.875rem] before:w-[0.875rem] before:scale-0 before:rounded-full before:bg-transparent before:opacity-0 before:shadow-[0px_0px_0px_13px_transparent] before:content-[''] checked:border-primary checked:bg-primary checked:before:opacity-[0.16] checked:after:absolute checked:after:-mt-px checked:after:ml-[0.25rem] checked:after:block checked:after:h-[0.8125rem] checked:after:w-[0.375rem] checked:after:rotate-45 checked:after:border-[0.125rem] checked:after:border-l-0 checked:after:border-t-0 checked:after:border-solid checked:after:border-white checked:after:bg-transparent checked:after:content-[''] hover:cursor-pointer hover:before:opacity-[0.04] hover:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:shadow-none focus:transition-[border-color_0.2s] focus:before:scale-100 focus:before:opacity-[0.12] focus:before:shadow-[0px_0px_0px_13px_rgba(0,0,0,0.6)] focus:before:transition-[box-shadow_0.2s,transform_0.2s] focus:after:absolute focus:after:z-[1] focus:after:block focus:after:h-[0.875rem] focus:after:w-[0.875rem] focus:after:rounded-[0.125rem] focus:after:content-[''] checked:focus:before:scale-100 checked:focus:before:shadow-[0px_0px_0px_13px_#3b71ca] checked:focus:before:transition-[box-shadow_0.2s,transform_0.2s] checked:focus:after:-mt-px checked:focus:after:ml-[0.25rem] checked:focus:after:h-[0.8125rem] checked:focus:after:w-[0.375rem] checked:focus:after:rotate-45 checked:focus:after:rounded-none checked:focus:after:border-[0.125rem] checked:focus:after:border-l-0 checked:focus:after:border-t-0 checked:focus:after:border-solid checked:focus:after:border-white checked:focus:after:bg-transparent dark:border-neutral-600 dark:checked:border-primary dark:checked:bg-primary"
                        type="checkbox" id="astor" name="astor"
                        {{ !empty(old('astor')) || data_get($form, 'astor', false) ? 'checked' : '' }} />
                    <label class="inline-block pl-[0.15rem] hover:cursor-pointer" for="astor">
                        Centang jika merupakan ASTOR
                    </label>
                </div>

                <div class="grid sm:grid-cols-2 sm:gap-4">
                    <div class="relative mb-8" data-te-validate="input"
                        @error('priority_division1') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                        <select {{ !empty(old('astor')) || data_get($form, 'astor', false) ? 'disabled' : '' }}
                            {{ array_key_exists('id', $form) ? 'disabled' : '' }} data-te-select-init
                            id="priority-division1" name="priority_division1">
                            <option value="" selected disabled></option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division['id'] }}"
                                    {{ old('priority_division1') === $division['id'] || data_get($form, 'priority_division1', '-1') === $division['id'] ? 'selected' : '' }}>
                                    {{ $division['name'] }}</option>
                            @endforeach
                        </select>
                        <label data-te-select-label-ref>Divisi Prioritas 1</label>
                    </div>

                    <div class="relative mb-8" data-te-validate="input"
                        @error('priority_division2') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                        <select {{ !empty(old('astor')) || data_get($form, 'astor', false) ? 'disabled' : '' }}
                            {{ array_key_exists('id', $form) ? 'disabled' : '' }} data-te-select-init
                            id="priority-division2" name="priority_division2">
                            <option value="" selected></option>
                            @foreach ($divisions as $division)
                                <option value="{{ $division['id'] }}"
                                    {{ old('priority_division2') === $division['id'] || data_get($form, 'priority_division2', '-1') === $division['id'] ? 'selected' : '' }}>
                                    {{ $division['name'] }}</option>
                            @endforeach
                        </select>
                        <label data-te-select-label-ref>Divisi Prioritas 2</label>
                    </div>
                </div>

                @if (!array_key_exists('id', $form))
                    <div class="px-3 mb-8 text-white">
                        <p style="font-size: 110%;"><span class="text-red-400">Perhatian!</span><br />Pilihan <span
                                class="text-red-400">ASTOR</span> dan <span class="text-red-400">Divisi</span> hanya dapat
                            dipilih <span class="text-red-400">satu kali</span> dan <span class="text-red-400">tidak dapat
                                diubah</span>!</p>
                    </div>
                @endif

                <!--Submit button-->
                <button type="submit"
                    class="inline-block w-full rounded bg-[#e59980] px-6 pb-2 pt-2 mt-2 text-md font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-[#ba7d68] focus:bg-[#ba7d68]  focus:outline-none focus:ring-0 active:bg-primary-700"
                    data-te-ripple-init data-te-ripple-color="light">
                    {{ !array_key_exists('id', $form) ? 'SUBMIT' : 'UPDATE' }}
                </button>
            </form>
        </div>
    </section>
@endsection

@php
    $peran = array_filter($divisions, function ($division) {
        return $division['name'] == 'Peran';
    });
    $peran = array_values($peran)[0];
@endphp

@section('scripts')
    <script>
        $(document).ready(() => {
            $('form[data-te-validation-init]').attr('data-te-validated', true);
            $('input[data-te-input-state-active] ~ div').attr('data-te-input-state-active', true);
            $('textarea[data-te-input-state-active] ~ div').attr('data-te-input-state-active', true);

            $('#astor').on('change', function() {
                if ($(this).is(':checked')) {
                    $('#priority-division1').val('{{ $peran['id'] }}');
                    $('#priority-division1').attr('disabled', true);

                    $('#priority-division2').val('');
                    $('#priority-division2').attr('disabled', true);
                } else {
                    $('#priority-division1').val('');
                    $('#priority-division1').attr('disabled', false);

                    $('#priority-division2').attr('disabled', false);
                }
            });

            $('#application-form').submit(function(e) {
                e.preventDefault();
                $('#priority-division1').attr('disabled', false);
                $('#priority-division2').attr('disabled', false);
                $(this).unbind('submit').submit();
            });

            // flash message
            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ Session::get('success') }}',
                    didClose: () => {
                        window.location.href = '{{ route('applicant.documents-form') }}';
                    }
                });
            @endif
        });
    </script>
@endsection
