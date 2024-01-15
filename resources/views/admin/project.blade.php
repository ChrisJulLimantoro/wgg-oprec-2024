@extends('admin.layout')

@section('style')
    <style>
        .ck-editor__editable_inline {
            min-height: 175px;
        }

        .ck-editor__editable_inline * {
            font-size: 14px;
        }

        .ck-editor__editable_inline ol,
        .ck-editor__editable_inline ul {
            margin-inline: 16px;
        }

        .ck-editor__editable_inline a {
            color: #3b82f6;
            text-decoration: underline
        }
    </style>
@endsection

@section('content')
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <h1 class="text-center text-4xl uppercase font-bold mb-8">Project</h1>
        <div class="select w-1/2 mx-auto">
            <select id="division"
                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                <option value="none" selected disabled>Choose Division</option>

                @foreach ($divisions as $d)
                    @if (in_array($d['slug'], ['bph', 'open', 'close']))
                        @continue;
                    @endif
                    <option value="{{ $d['id'] }}" {{ data_get($division, 'id') === $d['id'] ? 'selected' : '' }}>
                        {{ $d['name'] }} </option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
        <div class="px-8 max-w-[700px] w-full mb-3">
            @if ($division)
                <form action="{{ route('admin.project.store', $division['id']) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="mb-6">
                        <label for="project" class="">Deskripsi Proyek</label>
                        <textarea id="editor" name="project" class="w-full min-h-[200px]"></textarea>
                        <div class="mx-1 text-danger">
                            @error('project')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <div class="mb-7">
                        <label for="deadline">Waktu Pengerjaan (dalam <span class="text-warning">jam</span>, dihitung mulai
                            dari
                            <span class="text-warning">jam mulai
                                interview</span> peserta)</label>
                        <div class="relative" data-te-input-wrapper-init>
                            <input type="number" min="1" name="project_deadline" id="deadline"
                                @if ($division['project_deadline']) value="{{ $division['project_deadline'] / 3600 }}" @endif
                                class="block w-full rounded bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                                id="exampleFormControlInputNumber" placeholder="Example label" />
                        </div>
                        <div class="mx-1 text-danger">
                            @error('project_deadline')
                                {{ $message }}
                            @enderror
                        </div>
                    </div>
                    <button type="submit"
                        class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 w-full text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                        UPDATE</button>
                </form>
            @endif
        </div>
    </div>
@endsection

@section('script')
    <script src="https://cdn.ckeditor.com/ckeditor5/40.2.0/classic/ckeditor.js"></script>

    <script>
        $(document).ready(() => {
            $('#division').on('change', function() {
                const divisionId = $(this).val();
                if (divisionId === 'none') return;

                window.location.href = '{{ route('admin.project') }}/' + divisionId;
            });
            @if (Session::has('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ Session::get('success') }}',
                    showConfirmButton: false,
                    timer: 1500,
                });
            @endif
        });
    </script>
    <script>
        const cke = ClassicEditor
            .create(document.querySelector('#editor'), {
                removePlugins: ['BlockQuote', 'EasyImage',
                    'ImageUpload', 'MediaEmbed', 'TableToolbar', 'Table', 'Indent', 'Heading'
                ],
            })
            .catch(error => {
                console.error(error);
            });
        @if ($division)
            cke.then(editor => {
                editor.setData(`{!! $division['project'] !!}`);
            });
        @endif
    </script>
@endsection
