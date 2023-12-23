@extends("admin.layout")
@section("style")
    <style>
        #alert{
            transition: 0.3s ease-in-out;
        }
    </style>
@endsection
@section("content")
{{-- @include('admin.partials.sidebar') --}}

<div class="flex w-full h-24 rounded-lg shadow-xl items-center justify-center mb-8">
    <h1 class="text-center uppercase font-bold text-3xl">Add Dates</h1>
</div>

<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
    <div class="flex flex-row w-3/4 mx-auto">
        <div
        class="relative mb-3 mr-4 w-3/4"
        data-te-datepicker-init
        data-te-inline="true"
        data-te-format="yyyy-m-dd"
        data-te-input-wrapper-init>
            <input
                type="text"
                id="date"
                class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                placeholder="Select a date" />
            <label
                for="floatingInput"
                class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                >Select a date</label
            >
        </div>
        <button
            type="button"
            data-te-ripple-init
            data-te-ripple-color="light"
            id="add-date"
            class="w-1/4 mb-3 inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
            Add Date
        </button>
    </div>
    <div class="flex flex-col w-3/4">
        <div class="overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="inline-block min-w-full py-2 sm:px-6 lg:px-8">
            <div class="overflow-hidden">
            <table class="min-w-full text-left text-sm font-light">
                <thead class="border-b font-medium dark:border-neutral-500">
                <tr>
                    <th scope="col" class="px-6 py-4">#</th>
                    <th scope="col" class="px-6 py-4">Tanggal</th>
                    <th scope="col" class="px-6 py-4">Action</th>
                </tr>
                </thead>
                <tbody>
                    @php
                        $no = 1;
                    @endphp
                    @foreach ($dates as $d)
                        <tr class="border-b dark:border-neutral-500 hover:bg-neutral-100">
                            <td scope="row" class="whitespace-nowrap px-6 py-4 text-md">
                                {{ $no }}
                            </td>
                            <td scope="row" class="whitespace-nowrap px-6 py-4 text-md">
                                <b>{{ $d['day'] }} | {{ $d['date'] }}</b>
                            </td>
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="rounded-lg p-2 hover:bg-neutral-300 w-9 del">
                                    <input type="hidden" value="{{ route('admin.date.delete',['id' => $d['id']]) }}" class="id">
                                    <svg class="m-auto w-[20px] h-[20px] fill-[#ff6b6b]" viewBox="0 0 448 512" xmlns="http://www.w3.org/2000/svg">
                                        <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                        <path d="M135.2 17.7C140.6 6.8 151.7 0 163.8 0H284.2c12.1 0 23.2 6.8 28.6 17.7L320 32h96c17.7 0 32 14.3 32 32s-14.3 32-32 32H32C14.3 96 0 81.7 0 64S14.3 32 32 32h96l7.2-14.3zM32 128H416V448c0 35.3-28.7 64-64 64H96c-35.3 0-64-28.7-64-64V128zm96 64c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16zm96 0c-8.8 0-16 7.2-16 16V432c0 8.8 7.2 16 16 16s16-7.2 16-16V208c0-8.8-7.2-16-16-16z"></path>
                                    </svg>
                                </div>
                            </td>
                        </tr>   
                    @php
                        $no+=1;
                    @endphp
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>
        </div>
    </div>
</div>

@endsection
@section("script")
<script>
    $(document).ready(function() {
        $("#add-date").on("click",function(){
            let date = $("#date").val();
            if(date != '' && date != null){
                $.ajax({
                    url : "{{ route('admin.date.add') }}",
                    method : "POST",
                    data : {
                        _token : "{{ csrf_token() }}",
                        date : date
                    },
                    success : function(res){
                        if(res.status == 200){
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: res.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                            setTimeout(function(){
                                window.location.reload();
                            },1500)
                        }else{
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: res.msg,
                                showConfirmButton: false,
                                timer: 1500
                            })
                        }
                    },
                })
            }
        })
        $(document).on("click",'.del',function(){
            let data = $(this).find('.id').val();
            // console.log(data);
            Swal.fire({
                title: 'Are you sure?',
                text: "You will delete this date!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3b71ca',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url : data,
                        method : "DELETE",
                        data : {
                            _token : "{{ csrf_token() }}",
                        },
                        success : function(res){
                            if(res.status == 200){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: res.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                                setTimeout(function(){
                                    window.location.reload();
                                },1500)
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: res.msg,
                                    showConfirmButton: false,
                                    timer: 1500
                                })
                            }
                        },
                    })
                }
            })
        })
    });
</script>
@endsection