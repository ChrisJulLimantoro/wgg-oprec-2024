@extends('main.layout')

@section('content')
    @include('main.stepper', ['applicant' => $applicant])

    <div class="text-center">
        <h1 class="text-3xl font-bold mb-2">Berkas Pendaftar</h1>
        <div class="text-danger">
            Hanya bisa mengupload satu kali. Pastikan berkas sudah benar sebelum menekan tombol UPLOAD
        </div>
    </div>
    <section class="max-w-[940px] mx-auto pt-3 pb-16">
        <!-- TW Elements is free under AGPL, with commercial license required for specific uses. See more details: https://tw-elements.com/license/ and contact us for queries at tailwind@mdbootstrap.com -->
        <div
            class="block rounded-lg bg-white py-6 sm:px-6 px-4 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
            @foreach ($documentTypes as $type => $label)
                <div class="mb-4">
                    <label for="formFileMultiple" class="mb-2 inline-block text-neutral-700 dark:text-neutral-200">
                        {{ $label }}
                    </label>
                    <form class="grid sm:grid-cols-5 sm:gap-4 grid-cols-3 gap-2"
                        action="{{ route('applicant.document.store', ['type' => strtolower($type)]) }}">
                        @csrf
                        @if ($applicant['documents'] && array_key_exists(strtolower($type), $applicant['documents']))
                            <input
                                class="relative m-0 block sm:col-span-4 col-span-2 min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none disabled:opacity-60 dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                type="file" id="formFileDisabled" disabled />
                            <button type="button"
                                class="pointer-events-none inline-block rounded bg-primary sm:px-6 px-2.5 pb-1.5 pt-1.5 sm:text-sm text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] disabled:opacity-70 dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                                disabled>
                                UPLOAD
                            </button>
                        @else
                            <input
                                class="relative m-0 block sm:col-span-4 col-span-2 min-w-0 flex-auto rounded border border-solid border-neutral-300 bg-clip-padding px-3 py-[0.32rem] text-base font-normal text-neutral-700 transition duration-300 ease-in-out file:-mx-3 file:-my-[0.32rem] file:overflow-hidden file:rounded-none file:border-0 file:border-solid file:border-inherit file:bg-neutral-100 file:px-3 file:py-[0.32rem] file:text-neutral-700 file:transition file:duration-150 file:ease-in-out file:[border-inline-end-width:1px] file:[margin-inline-end:0.75rem] hover:file:bg-neutral-200 focus:border-primary focus:text-neutral-700 focus:shadow-te-primary focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:file:bg-neutral-700 dark:file:text-neutral-100 dark:focus:border-primary"
                                type="file" name="{{ strtolower($type) }}" accept=".PNG,.JPG,.JPEG" />
                            <button type="submit" data-te-ripple-init data-te-ripple-color="light"
                                class="inline-block rounded bg-primary sm:px-6 px-2.5 pb-1.5 pt-1.5 sm:text-sm text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                UPLOAD
                            </button>
                        @endif
                    </form>
                    <div
                        class="h-1 w-full bg-neutral-200 dark:bg-neutral-600 my-1 {{ $applicant['documents'] && array_key_exists(strtolower($type), $applicant['documents']) ? '' : 'hidden' }} progress-bar">
                        <div class="h-1 bg-primary"
                            {{ $applicant['documents'] && array_key_exists(strtolower($type), $applicant['documents']) ? '' : 'style="width: 100%"' }}>
                        </div>
                    </div>
                    <div class="preview mt-2">
                        @php
                            $imgSrc = '';
                            if ($applicant['documents'] && array_key_exists(strtolower($type), $applicant['documents'])) {
                                $imgSrc = asset('storage/uploads/' . strtolower($type) . '/' . data_get($applicant['documents'], strtolower($type)));
                            }
                        @endphp
                        <img src="{{ $imgSrc }}" alt="{{ $label }}"
                            class="{{ $applicant['documents'] && array_key_exists(strtolower($type), $applicant['documents']) ? '' : 'hidden' }} max-h-[400px]">
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(() => {
            $('form > input').on('change', function() {
                const [input] = $(this);
                if (!input) return;

                const [file] = input.files;
                if (!file) return;

                const preview = $(this).parent().siblings('.preview');

                preview.children('img').attr('src', URL.createObjectURL(file));
                preview.children('img').removeClass('hidden');
            });

            $('form').on('submit', function(e) {
                e.preventDefault();

                const storeUrl = $(this).attr('action');
                const type = storeUrl.split('/').pop();
                const formData = new FormData(this);
                $.ajax({
                    type: 'POST',
                    url: storeUrl,
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    accept: {
                        'json': 'application/json'
                    },
                    xhr: () => {
                        const xhr = new window.XMLHttpRequest();
                        const progressBar = $(this).siblings('.progress-bar');
                        progressBar.removeClass('hidden');
                        progressBar.children('div').css('width', '0%');
                        xhr.upload.addEventListener('progress', (e) => {
                            if (e.lengthComputable) {
                                const percent = Math.round((e.loaded / e.total) * 100);
                                progressBar.children('div').css('width', `${percent}%`);
                            }
                        });
                        return xhr;
                    },
                }).done((e) => {
                    const config = {
                        icon: 'success',
                        title: 'Success',
                        text: e.message,
                    };

                    if (e.stageCompleted) {
                        config.didClose = () => {
                            window.location.href = '{{ route('applicant.schedule-form') }}'
                        }
                    } else {
                        config.timer = 1700;
                        config.showConfirmButton = false;
                    }

                    Swal.fire(config);

                    $(this).children('input').attr('disabled', true);
                    $(this).children('button').attr('disabled', true);
                }).fail((e) => {
                    const errors = e.responseJSON.errors;
                    if (Object.keys(errors).length > 1) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please choose a file to be uploaded',
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: e.responseJSON.message,
                        });
                    }
                });

            });
        });
    </script>
@endsection
