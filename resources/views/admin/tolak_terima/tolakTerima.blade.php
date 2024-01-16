@extends('admin.layout')

@section('style')
{{-- fontawesome --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endsection

@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <h1 class="text-center text-4xl uppercase font-bold">Tolak-Terima Anak</h1>
</div>  

<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
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
                { label: "action 1", field: "action1" },
                { label: "action 2", field: "action2" },
                { label: "Detail", field: "detail", sort: false },
                ],
                rows: data
                .map((item,i) => {
                return {
                    ...item,
                    detail:`
                    <a href="{{ route('admin.applicant.cv', '') }}/${item.id}" target="_blank"
                        type="button"
                        class="btn-detail block mb-2 rounded bg-success px-6 pb-2 pt-2.5 text-xs text-center font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#14a44d] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.3),0_4px_18px_0_rgba(20,164,77,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(20,164,77,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(20,164,77,0.2),0_4px_18px_0_rgba(20,164,77,0.1)]"
                        data-te-index="${i}"
                        >
                        Detail
                        </a>

                        <a href="{{ route('admin.applicant.answer', '') }}/${item.id}" target="_blank"
                        type="button"
                        class="btn-answer block rounded bg-danger px-6 pb-2 pt-2.5 text-xs text-center font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#dc4c64] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.3),0_4px_18px_0_rgba(220,76,100,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(220,76,100,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(220,76,100,0.2),0_4px_18px_0_rgba(220,76,100,0.1)]">
                        Answer
                        </a>
                    `,

                };
                }),
            },
            { hover: true }
            );

            $(document).on("click",".btn-terima",function(){
                const index = $(this).data("te-index");
                const prirority = $(this).data("te-priority");
                let applicant_id = data[index]['id'];
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apakah anda yakin menerima anak ini di divisi " + data[index]['prioritas'+prirority] + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#14a44d',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, accept it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : "{{ route('admin.tolak-terima.terima') }}",
                            method : "POST",
                            data : {
                                _token : "{{ csrf_token() }}",
                                id : applicant_id,
                                priority : prirority
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

            $(document).on("click",".btn-tolak",function(){
                const index = $(this).data("te-index");
                const prirority = $(this).data("te-priority");
                let applicant_id = data[index]['id'];
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Apakah anda yakin menolak anak ini di divisi " + data[index]['prioritas'+prirority] + "?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3b71ca',
                    confirmButtonText: 'Yes, reject it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url : "{{ route('admin.tolak-terima.tolak') }}",
                            method : "POST",
                            data : {
                                _token : "{{ csrf_token() }}",
                                id : applicant_id,
                                priority : prirority
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