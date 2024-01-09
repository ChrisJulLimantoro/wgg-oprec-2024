@extends('admin.layout')
@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <h1 class="text-center text-4xl uppercase font-bold mb-2">Meeting Spot</h1>
</div>
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <div class="w-3/4">
        <h1 class="text-start text-lg font-bold mb-2">Meeting Link</h1>
        <div class="grid grid-cols-6 gap-3">
            <div class="relative mb-8 col-span-5" data-te-input-wrapper-init>
                <input
                    type="text"
                    class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                    id="meet"
                    placeholder="Meeting Link"
                    @isset($admin['meet'])
                    value="{{ $admin['meet'] }}"
                    @endisset
                    />
                <label
                    for="exampleFormControlInputHelper"
                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                    >Meeting Link
                </label>
                <div
                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                    data-te-input-helper-ref>
                    For Online meeting input either google meet
                </div>
            </div>
            <div>
                <button
                    id="meet-submit"
                    type="button"
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    class="w-full inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Submit
                </button>
            </div>
        </div>
        <h1 class="text-start text-lg font-bold mb-2">Meeting Spot</h1>
        <div class="grid grid-cols-6 gap-3">
            <div class="relative mb-8 col-span-5" data-te-input-wrapper-init>
                <input
                    type="text"
                    class="peer block min-h-[auto] w-full rounded border-0 bg-transparent px-3 py-[0.32rem] leading-[1.6] outline-none transition-all duration-200 ease-linear focus:placeholder:opacity-100 peer-focus:text-primary data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:peer-focus:text-primary [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0"
                    id="spot"
                    placeholder="Meeting Spot"
                    @isset($admin['spot'])
                    value="{{ $admin['spot'] }}"
                    @endisset
                    />
                <label
                    for="Spot"
                    class="pointer-events-none absolute left-3 top-0 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-200 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:text-neutral-200 dark:peer-focus:text-primary"
                    >Meeting Spot
                </label>
                <div
                    class="absolute w-full text-sm text-neutral-500 peer-focus:text-primary dark:text-neutral-200 dark:peer-focus:text-primary"
                    data-te-input-helper-ref>
                    For Onsite spot
                </div>
            </div>
            <div>
                <button
                    id="spot-submit"
                    type="button"
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    class="w-full inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Submit
                </button>
            </div>
        </div>
    </div>
</div>
@endSection()
@section('script')
<script>
    $(document).ready(function(){
        let id = @json($admin['id']);
        $('#meet-submit').on('click',async function(){
            let success = await ajaxUpdate($('#meet').val(),null);
            if(!success) {
                $('#meet').val('');
            }
        })
        $('#spot-submit').on('click',async function(){
            let success = await ajaxUpdate(null,$('#spot').val());
            if(!success) {
                $('#spot').val('');
            }
        })
        async function ajaxUpdate(meet,spot){
            let data = {
                _token: '{{ csrf_token() }}'
            };
            if(meet) data.meet = meet;
            if(spot) data.spot = spot;
            let success = await $.ajax({
                url: '{{ route('admin.meeting-spot.update',['admin' => $admin['id']]) }}',
                type: 'PATCH',
                data: data,
                success: async function(data){
                    if(data.success){
                        await Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Meeting spot updated',
                            showConfirmButton: false,
                            timer: 1500
                        })
                        return true;
                    }else{
                        await Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Something went wrong!',
                        })
                        return false;
                    }
                },
                error: async function(data){
                    await Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Something went wrong!',
                    })
                    return false;
                }
            })
            if(success){
                return true
            }else{
                return false
            }
        }
    })
</script>
@endSection()