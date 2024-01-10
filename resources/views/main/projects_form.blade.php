@extends('main.layout')

@section('styles')
    <style>
        .project-description a {
            color: #3b82f6;
            text-decoration: underline;
        }

        .project-description ul,
        .project-description ol {
            margin-left: 1.25rem;
        }

        .project-description ul {
            list-style-type: initial;
        }

        .project-description ol {
            list-style-type: decimal;
        }
    </style>
@endsection

@section('content')
    <div class="mb-4 pt-5">
        <div class="flex justify-center mb-5">
            <h1
                class="sm:text-7xl text-4xl lg:ml-0 md:ml-5 sm:ml-10 font-bold bg-clip-text inline whitespace-nowrap uppercase">
                Project</h1>
        </div>

        <div class="flex justify-center mt-10">
            <div class="mb-3 w-[650px] mx-auto">
                <div class="relative mb-4 flex w-full flex-wrap">
                    <div class="w-full mb-6">
                        <label class="text-xl font-bold">Pilih Divisi : </label>
                        <select id="selectDivision"
                            class=" w-full bg-transparent border-2 font-serif text-sm rounded-lg block py-3 pl-3 shadow-lg hover:shadow-xl">
                            <option value="" selected disabled class="font-serif">-- Pilih Divisi --</option>
                            <option value="1" {{ $selected == 1 ? 'selected' : '' }}>
                                {{ $applicant['priority_division1']['name'] }}</option>
                            @if ($applicant['priority_division2'])
                                <option value="2" {{ $selected == 2 ? 'selected' : '' }}>
                                    {{ $applicant['priority_division2']['name'] }}</option>
                            @endif
                        </select>
                    </div>
                    @if (isset($projectDescription))
                        <div
                            class="block w-full rounded-lg bg-white px-5 py-4 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 mb-6">
                            <div class="mb-2 text-lg font-medium leading-tight text-neutral-800 dark:text-neutral-50">
                                Project Description
                            </div>
                            <div class="mb-4 text-sm text-neutral-600 dark:text-neutral-200 project-description">
                                {!! $projectDescription !!}
                            </div>
                        </div>
                    @endif
                    <form action="{{ $selected ? route('applicant.project.store', $selected) : '' }}" method="POST"
                        class="w-full">
                        @csrf
                        <div class="w-full mb-8">
                            <label for="project" class="mb-3">Link Project (drive)</label>
                            <textarea id="project" name="project" @if (!$selected || $passedDeadline) disabled @endif
                                class="w-full bg-transparent border-2 font-serif disabled:!bg-gray-400/25 text-sm rounded-lg block py-3 pl-3 shadow-lg enabled:hover:shadow-xl"
                                rows="2" placeholder="Link Project">{{ data_get($applicant, 'documents.projects.' . $selected) }}</textarea>
                            <div class="text-xs mx-1 mt-1">Jangan lupa atur access file supaya dapat diakses oleh panitia
                            </div>
                        </div>
                        <button type="submit" data-te-ripple-init data-te-ripple-color="light" id="submitProject"
                            @if (!$selected || $passedDeadline) disabled @endif
                            class="w-full inline-block rounded bg-success disabled:opacity-75 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out enabled:hover:bg-success-600 enabled:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 enabled:active:bg-success-700 enabled:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:enabled:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:enabled:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            Submit Project
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
@endsection

@error('project')
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: '{{ $message }}',
        })
    </script>
@enderror

@section('scripts')
    <script>
        $(document).ready(() => {
            $('#selectDivision').change(function() {
                window.location.href = '{{ route('applicant.projects-form') }}' + '/' + $(this).val();
            });

            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}',
                })
            @endif
        });
    </script>
@endsection
