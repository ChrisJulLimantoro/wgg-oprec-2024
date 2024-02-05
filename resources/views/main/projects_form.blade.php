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
    @include('main.stepper', ['applicant' => $applicant])

    <div class="mb-4 pt-5">
        <div class="flex justify-center mb-2">
            <h1 class="text-3xl font-bold text-center text-white">Submit Project</h1>
        </div>

        <section class="flex justify-center max-w-[940px] mx-auto pt-3 pb-16">
            <div
                class="mb-3 w-[650px] mx-auto block rounded-xl bg-white/10 backdrop-blur-md bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
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
                    @if (!$applicant['astor'])
                        @if (isset($projectDescription))
                            <div
                                class="block w-full rounded-lg px-5 py-4 shadow-[5px_5px_10px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 mb-6">
                                <div class="mb-2 text-lg font-medium leading-tight text-white">
                                    Project Description
                                </div>
                                <div class="mb-4 text-sm text-white project-description">
                                    {!! $projectDescription !!}
                                </div>
                            </div>
                        @endif
                        <form action="{{ $selected ? route('applicant.project.store', $selected) : '' }}" method="POST"
                            class="w-full">
                            @csrf
                            <div class="w-full mb-8">
                                <label for="project" class="mb-5">Link Project (drive)</label>
                                <textarea id="project" name="project" @if (!$selected || $passedDeadline) disabled @endif
                                    class="w-full bg-transparent border-2 font-serif disabled:!bg-gray-400/25 text-sm rounded-lg block py-3 pl-3 shadow-lg enabled:hover:shadow-xl"
                                    rows="2" placeholder="Link Project">{{ data_get($applicant, 'documents.projects.' . $selected) }}</textarea>
                                <div class="text-xs mx-1 mt-1 text-white">Jangan lupa atur access file supaya dapat diakses
                                    oleh
                                    panitia
                                </div>
                            </div>
                            <button type="submit" data-te-ripple-init data-te-ripple-color="light" id="submitProject"
                                @if (!$selected || $passedDeadline) disabled @endif
                                class="w-full inline-block rounded bg-success disabled:opacity-75 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out enabled:hover:bg-success-600 focus:bg-success-600 focus:outline-none focus:ring-0 enabled:active:bg-success-700">
                                Submit Project
                            </button>
                        </form>
                    @else
                        <div
                            class="block w-full rounded-lg px-5 py-4 shadow-[5px_5px_10px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700 mb-6">
                            <div class="mb-4 text-white project-description">
                                Tidak ada Project untuk ASTOR
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
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
