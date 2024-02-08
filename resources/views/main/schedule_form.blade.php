@extends('main.layout')

@section('content')
    @include('main.stepper', ['applicant' => $applicant])

    @php
        $onsiteOnly = ['Creative', 'Keamanan', 'Peran'];
    @endphp

    <h1 class="text-3xl font-bold text-center text-white">Pilih Jadwal Wawancara</h1>

    @if ($applicant['astor'])
        <section class="relative max-w-[940px] mx-auto pt-3 pb-16">
            <div
                class="block rounded-xl bg-white/10 backdrop-blur-md bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
                <div class="text-white">ASTOR tidak perlu melakukan interview.</div>
            </div>
        </section>
    @else
        <section class="relative max-w-[940px] mx-auto pt-3 pb-16">
            <div
                class="block rounded-xl bg-white/10 backdrop-blur-md bg-white p-6 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] dark:bg-neutral-700">
                <form data-te-validation-init action="{{ route('applicant.pick-schedule') }}" method="POST"
                    id="application-applicant">
                    @csrf

                    <input type="hidden" name="division[]" id="division_1"
                        value="{{ $applicant['priority_division1']['id'] }}">
                    @if ($applicant['priority_division2'])
                        <input type="hidden" name="division[]" id="division_2"
                            value="{{ $applicant['priority_division2']['id'] }}">
                    @endif

                    {{-- Wawancara pertama --}}
                    <p class="text-lg font-semibold mb-4 text-white">Wawancara Divisi
                        {{ strtoupper($applicant['priority_division1']['name']) }}

                        {{ $applicant['priority_division2'] && !$double_interview ? ' & ' . strtoupper($applicant['priority_division2']['name']) : '' }}

                        @if (in_array($applicant['priority_division1']['name'], $onsiteOnly))
                            <span class="text-red-400">(Onsite Only)</span>
                        @endif
                    </p>

                    <div
                        class="grid {{ $read_only && $reschedule[0] ? 'sm:grid-cols-5' : ($read_only ? 'sm:grid-cols-4' : 'sm:grid-cols-3') }} sm:gap-4 mb-4">
                        <div data-te-validate="input" class="mb-4"
                            @error('date_id') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                            @error('date_id.0') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                            <select data-te-select-init name="date_id[]" id="date_1"
                                value="{{ $read_only ? $schedules[0]['date']['date'] : old('date_id')[0] ?? '' }}"
                                {{ $read_only ? 'disabled' : '' }}>

                                @foreach ($dates as $d)
                                    <option value="{{ $d['id'] }}"
                                        @if ($read_only) {{ strval($schedules[0]['date_id']) === $d['id'] ? 'selected' : '' }} @endif
                                        @if (!empty(old('date_id'))) {{ old('date_id')[0] == $d['id'] ? 'selected' : '' }} @endif>
                                        {{ Datetime::createFromFormat('Y-m-d', $d['date'])->format('D, j M Y') }}
                                    </option>
                                @endforeach

                            </select>

                            <label data-te-select-label-ref>Hari</label>
                        </div>

                        <div data-te-validate="input" class="mb-4"
                            @error('online') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                            @error('online.0') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>

                            <select data-te-select-init name="online[]" id="online_1" value=""
                                {{ $read_only ? 'disabled' : '' }}>
                                <option value="0"
                                    @if ($read_only) {{ strval($schedules[0]['online']) === '0' ? 'selected' : '' }} @endif
                                    @if (!empty(old('online'))) {{ old('online')[0] == '0' ? 'selected' : '' }} @endif>
                                    Onsite</option>
                                @if (!in_array($applicant['priority_division1']['name'], $onsiteOnly))
                                    <option value="1"
                                        @if ($read_only) {{ strval($schedules[0]['online']) === '1' ? 'selected' : '' }} @endif
                                        @if (!empty(old('online'))) {{ old('online')[0] == '1' ? 'selected' : '' }} @endif>
                                        Online</option>
                                @endif
                            </select>

                            <label data-te-select-label-ref>Tipe</label>
                        </div>

                        <div data-te-validate="input" class="mb-4"
                            @error('time') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                            @error('time.0') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>

                            <select data-te-select-init name="time[]" id="time_1" {{ $read_only ? 'disabled' : '' }}>
                                @if ($read_only)
                                    <option value="{{ $schedules[0]['time'] }}" selected>
                                        {{ str_pad(strval($schedules[0]['time']), 2, '0', STR_PAD_LEFT) }}:00 -
                                        {{ str_pad(strval(intval($schedules[0]['time']) + 1), 2, '0', STR_PAD_LEFT) }}:00
                                    </option>
                                @endif
                            </select>

                            <label data-te-select-label-ref>Jam</label>
                        </div>

                        @includeWhen($read_only, 'main.interview_location_btn', ['i' => 0])

                        @includeWhen($read_only && $reschedule[0], 'main.reschedule_button', ['i' => 0])
                    </div>
                    {{-- End wawancara pertama --}}

                    {{-- Wawancara kedua --}}
                    @if ($double_interview)
                        <p class="text-lg font-semibold mt-10 md:mt-0 mb-4 text-white   ">Wawancara Divisi
                            {{ strtoupper($applicant['priority_division2']['name']) }}
                            @if (in_array($applicant['priority_division2']['name'], $onsiteOnly))
                                <span class="text-red-400">(Onsite Only)</span>
                            @endif
                        </p>

                        <div
                            class="grid {{ $read_only && $reschedule[1] ? 'sm:grid-cols-5' : ($read_only ? 'sm:grid-cols-4' : 'sm:grid-cols-3') }} sm:gap-4 mb-4">
                            <div data-te-validate="input" class="mb-4"
                                @error('date_id') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                                @error('date_id.1') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>
                                <select data-te-select-init name="date_id[]" id="date_2"
                                    {{ $read_only ? 'disabled' : '' }}>
                                    @foreach ($dates as $d)
                                        <option value="{{ $d['id'] }}"
                                            @if ($read_only) {{ strval($schedules[1]['date_id']) === $d['id'] ? 'selected' : '' }} @endif
                                            @if (!empty(old('date_id'))) {{ old('date_id')[1] == $d['id'] ? 'selected' : '' }} @endif>
                                            {{ Datetime::createFromFormat('Y-m-d', $d['date'])->format('D, j M Y') }}
                                        </option>
                                    @endforeach

                                    <label data-te-select-label-ref>Hari</label>
                                </select>
                            </div>

                            <div data-te-validate="input" class="mb-4"
                                @error('online') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                                @error('online.1') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>

                                <select data-te-select-init name="online[]" id="online_2"
                                    {{ $read_only ? 'disabled' : '' }}>
                                    <option value="0"
                                        @if ($read_only) {{ strval($schedules[1]['online']) === '0' ? 'selected' : '' }} @endif
                                        @if (!empty(old('online'))) {{ old('online')[1] == '0' ? 'selected' : '' }} @endif>
                                        Onsite</option>
                                    @if (!in_array($applicant['priority_division2']['name'], $onsiteOnly))
                                        <option value="1"
                                            @if ($read_only) {{ strval($schedules[1]['online']) === '1' ? 'selected' : '' }} @endif
                                            @if (!empty(old('online'))) {{ old('online')[1] == '1' ? 'selected' : '' }} @endif>
                                            Online</option>
                                    @endif
                                </select>

                                <label data-te-select-label-ref>Tipe</label>
                            </div>

                            <div data-te-validate="input" class="mb-4"
                                @error('time') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror
                                @error('time.1') data-te-validation-state="invalid" data-te-invalid-feedback="{{ $message }}" @enderror>

                                <select data-te-select-init name="time[]" id="time_2"
                                    {{ $read_only ? 'disabled' : '' }}>
                                    @if ($read_only)
                                        <option value="{{ $schedules[1]['time'] }}" selected>
                                            {{ str_pad(strval($schedules[1]['time']), 2, '0', STR_PAD_LEFT) }}:00 -
                                            {{ str_pad(strval(intval($schedules[1]['time']) + 1), 2, '0', STR_PAD_LEFT) }}:00
                                        </option>
                                    @endif
                                </select>

                                <label data-te-select-label-ref>Jam</label>
                            </div>

                            @includeWhen($read_only, 'main.interview_location_btn', ['i' => 1])

                            @includeWhen($read_only && $reschedule[1], 'main.reschedule_button', ['i' => 1])
                        </div>
                    @endif
                    {{-- End wawancara kedua --}}

                    <!--Submit button-->
                    <button type="submit"
                        class="inline-block w-full rounded bg-primary px-6 pb-2 pt-2 mt-2 text-md font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] {{ $read_only ? 'hidden' : '' }}"
                        data-te-ripple-init data-te-ripple-color="light">
                        PILIH
                    </button>

                    @if (!$read_only)
                        <p class="mt-5 text-center text-white">Jika tidak menemukan jadwal, bisa menghubungi OA Line WGG
                            <span class="text-[#e59980]">@328readn</span>
                        </p>
                    @endif
                </form>

                <form action="{{ route('applicant.reschedule') }}" method="POST" id="reschedule-form0"
                    class="reschedule-form">
                    @csrf
                </form>
                <form action="{{ route('applicant.reschedule') }}" method="POST" id="reschedule-form1"
                    class="reschedule-form">
                    @csrf
                </form>
            </div>
        </section>

        @includeWhen($read_only, 'main.interview_location_modal', ['i' => 0])
        @includeWhen($double_interview && $read_only, 'main.interview_location_modal', ['i' => 1])
        @includeWhen($read_only && $reschedule[0], 'main.reschedule_modal', ['i' => 0])
        @includeWhen($double_interview && $read_only && $reschedule[1], 'main.reschedule_modal', ['i' => 1])
    @endif
@endsection

@section('scripts')
    @if (!$applicant['astor'])
        <script>
            $(document).ready(async function() {
                $('form[data-te-validation-init]').attr('data-te-validated', true);
                $('select[data-te-input-state-active] ~ div').attr('data-te-input-state-active', true);

                @if (!$read_only)
                    let order = 0
                    order = 1
                    await getData($("#date_1").val(), $("#online_1").val(), $("#division_1").val())
                    order = 2
                    await getData($("#date_2").val(), $("#online_2").val(), $("#division_2").val())
                    order = 0
                @endif

                $("#date_1, #date_2").on("change", function() {
                    order = $(this).attr("id") === "date_1" ? 1 : 2
                    const division = $("#division_" + order).val()

                    if ($("#online_" + order).val() != "") {
                        const online = $("#online_" + order).val()
                        getData($(this).val(), online, division)
                    }
                })

                $("#online_1, #online_2").on("change", function() {
                    order = $(this).attr("id") === "online_1" ? 1 : 2
                    const division = $("#division_" + order).val()

                    if ($("#date_" + order).val() != "") {
                        const date = $("#date_" + order).val()
                        getData(date, $(this).val(), division)
                    }
                })

                async function getData(date, online, divisi) {
                    Swal.showLoading();
                    await $.ajax({
                        url: "{{ route('applicant.get-schedule') }}",
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            date: date,
                            online: parseInt(online),
                            division: divisi
                        },
                        success: function(response) {
                            $("#time_" + order).empty()
                            if (response.data.length == 0) {
                                $("#time_" + order).append(
                                    `<option value=''>` +
                                    "Tidak ada jadwal tersedia" +
                                    "</option>"
                                )
                            }

                            response.data.map((t) => {
                                $("#time_" + order).append(
                                    `<option value='` + t + `'>` +
                                    t.toString().padStart(2, '0') + ':00 - ' + (
                                        parseInt(t) + 1)
                                    .toString().padStart(2, '0') + ':00' +
                                    "</option>"
                                )
                            })
                        }
                    });
                    Swal.close();
                }

                //confirm reschedule
                $('.btn-reschedule').click(function(e, params) {
                    var localParams = params || {};

                    if (!localParams.send) {
                        e.preventDefault();
                    }

                    Swal.fire({
                        title: "Ganti Jadwal",
                        text: "Apakah Anda yakin ingin mengganti jadwal?",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonText: "Confirm",
                        cancelButtonText: "Cancel",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form = $(this).attr('form');
                            $('#' + form).submit();
                            // alert(id);
                            // $(e.currentTarget).trigger(e.type, { 'send': true });
                        }
                    });
                });

                @if (Session::has('success'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ Session::get('success') }}',
                        showConfirmButton: false,
                        timer: 1700
                    });
                @endif

                @if (Session::has('success_confirm'))
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: '{{ Session::get('success_confirm') }}',
                        showConfirmButton: true,
                    });
                @endif

                @if (Session::has('error'))
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: '{{ Session::get('error') }}',
                        showConfirmButton: false,
                        timer: 1700
                    });
                @endif

                @if (Session::has('previous_stage_not_completed'))
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ Session::get('previous_stage_not_completed') }}',
                });
                @endif

                // $("#modalLocationBtn0, #modalLocationBtn1, #btn-cp0, #btn-cp1").click(async function() {
                //     $("div[data-te-backdrop-show]").remove();
                // })
            })
        </script>
    @endif
@endsection
