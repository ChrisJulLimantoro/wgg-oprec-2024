@extends('admin.layout')

@section('style')
{{-- fontawesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <h1 class="text-center text-4xl uppercase font-bold">Culik Anak</h1>
</div>  

<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
    <div class="relative px-5 flex w-full flex-wrap justify-end items-stretch">
        <input
            id="datatable-search-input"
            type="search"
            class="relative m-0 -mr-0.5 block min-w-0  rounded border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
            placeholder="Search"
            aria-label="Search"
            aria-describedby="button-addon1" />
    </div>
    <div id="datatable" class="w-full px-5 py-5"></div> 
</div>
    
@endsection

@section('script')
    <script>
        $(document).ready(function(){
            const customDatatable = document.getElementById("datatable");
            var data = JSON.parse(@json($applicant));

            

            var table = new te.Datatable(
            customDatatable,
            {
                columns: [
                { label: "No", field: "no" },
                { label: "NRP", field: "nrp" },
                { label: "Nama", field: "name" },
                { label: "prioritas 1", field: "prioritas1" },
                { label: "prioritas 2", field: "prioritas2" },
                { label: "action", field: "action" },
                { label: "Detail", field: "detail", sort: false },
                ],
                rows: data.map((item,i) => {
                    console.log(item.id)
                return {
                    ...item,
                    detail:`
                    <a href="{{ route('admin.applicant.cv', '') }}/${item.id}" target="_blank"
                        
                        class="btn-detail text-center block mb-2 rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#14a44d] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(20,164,77,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)]"
                        data-te-index="${i}" 
                        >
                        Detail
                        </a>

                        <a href="{{ route('admin.applicant.answer', '') }}/${item.id}" target="_blank"
                        type="button"
                        class="btn-answer text-center inline-block rounded bg-stone-600 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-stone-50 shadow-[0_4px_9px_-4px_rgba(51,45,45,0.7)] transition duration-150 ease-in-out hover:bg-stone-700 hover:shadow-[0_8px_9px_-4px_rgba(51,45,45,0.2),0_4px_18px_0_rgba(51,45,45,0.1)] focus:bg-stone-700 focus:shadow-[0_8px_9px_-4px_rgba(51,45,45,0.2),0_4px_18px_0_rgba(51,45,45,0.1)] focus:outline-none focus:ring-0 active:bg-stone-800 active:shadow-[0_8px_9px_-4px_rgba(51,45,45,0.2),0_4px_18px_0_rgba(51,45,45,0.1)] dark:bg-stone-700 dark:shadow-[0_4px_9px_-4px_#030202] dark:hover:bg-stone-800 dark:hover:shadow-[0_8px_9px_-4px_rgba(3,2,2,0.3),0_4px_18px_0_rgba(3,2,2,0.2)] dark:focus:bg-stone-800 dark:focus:shadow-[0_8px_9px_-4px_rgba(3,2,2,0.3),0_4px_18px_0_rgba(3,2,2,0.2)] dark:active:bg-stone-700 dark:active:shadow-[0_8px_9px_-4px_rgba(3,2,2,0.3),0_4px_18px_0_rgba(3,2,2,0.2)]">
                        Answer
                        </a>
                    `,

                };
                }),
            },
            { hover: true }
            );

            document.getElementById('datatable-search-input').addEventListener('input', (e) => {
                table.search(e.target.value);
            });

            
    
            $(document).on("click", ".btn-culik", function(){
                const index = $(this).data("te-index");
                let applicant_id = data[index]['id'];
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apakah anda yakin menculik anak ini ke divisi {{ session('role') }} ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b71ca',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Culik'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : "{{ route('admin.tolak-terima.culik') }}",
                            method : "POST",
                            data : {
                                _token : "{{ csrf_token() }}",
                                id : applicant_id,
                            },
                            success : function(res){
                                console.log(res);
                                if(res.success){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: res.message,
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
                                        text: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            }
                        })

                    }
                })
            })

            $(document).on("click", ".btn-cancel",function(){
                const index = $(this).data("te-index");
                let applicant_id = data[index]['id'];
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apakah anda yakin membatalkan penculikan anak ini ke divisi {{ session('role') }} ?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3b71ca',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Batalkan'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : "{{ route('admin.tolak-terima.cancel') }}",
                            method : "POST",
                            data : {
                                _token : "{{ csrf_token() }}",
                                id : applicant_id,
                                priority: 3,
                            },
                            success : function(res){
                                console.log(res);
                                if(res.success){
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Success',
                                        text: res.message,
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
                                        text: res.message,
                                        showConfirmButton: false,
                                        timer: 1500
                                    })
                                }
                            }
                        })

                    }
                })
            })
        });

    </script>
    
@endsection