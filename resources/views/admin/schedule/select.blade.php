@extends("admin.layout")
@section("content")
    <div class="flex flex-col w-full h-full rounded-lg shadow-xl items-center justify-center mb-8 py-8">
        <h1 class="text-center uppercase font-bold text-3xl mb-5">Select Schedules</h1>
        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-4">
            <div class="grid grid-cols-2 gap-3 h-16">
                <div class="p-3 w-full h-full">
                    <div class="rounded-lg w-full h-full bg-red-500"> </div>
                </div>
                <div class="p-3 w-full h-full text-xl font-bold flex justify-center items-center">
                    <div class="my-auto">
                        Tidak Bisa
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 h-16">
                <div class="p-3 w-full h-full">
                    <div class="rounded-lg w-full h-full bg-green-500"> </div>
                </div>
                <div class="p-3 w-full h-full text-xl font-bold flex justify-center items-center">
                    <div class="my-auto">
                        Bisa
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3 h-16">
                <div class="p-3 w-full h-full">
                    <div class="rounded-lg w-full h-full bg-black"> </div>
                </div>
                <div class="p-3 w-full h-full text-xl font-bold flex justify-center items-center">
                    <div class="my-auto">
                        Ada Interview
                    </div>
                </div>
            </div>
        </div>
    </div> 

    <div class="grid lg:grid-cols-3 md:grid-cols-2 sm:grid-cols-2 gap-4 w-full h-full">
        @php
            $jad = 1;
        @endphp
        @foreach ($dates as $date)
            <div class="w-full h-full rounded-lg shadow-xl items-center justify-center p-8">
                <div class="py-4 text-center font-bold font-serif bg-gray-100 ring-2 ring-black rounded-sm shadow-lg hover:shadow-2xl z-10 mb-1 jadwal" id="jadwal-{{ $jad }}">
                    {{ $date['day'] }} ({{ $date['date'] }})
                </div>
                <div class="hidden" id="jamJadwal-{{ $jad }}">
                    <div class="grid-cols-2 grid bg-gray-50" >
                        @for($i = 0; $i < 6; $i++)
                            <div class="mt-0.5 rounded-sm grid grid-cols-3">
                                <div class="col-span-2 py-3 text-center">
                                    @php
                                        $time = 8 + $i;
                                        $str = $time < 10 ? '0'.str($time).':00' : str($time).':00';
                                        $str .= $time+1 < 10 ? ' - 0'.str($time+1).':00' : ' - '.($time+1).':00';
                                        echo $str;
                                        $stat = 0;
                                    @endphp
                                </div>
                                @foreach($date['schedules'] as $schedule)
                                    @if ($schedule['time'] == $time)
                                        @php
                                            $stat = $schedule['status'];
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($stat == 1)
                                    <div class="bg-green-500 time" id="time:{{ $date['id'] }}:{{ $time }}:1"></div>
                                @elseif($stat == 2)
                                    <div class="bg-black time" id="time:{{ $date['id'] }}:{{ $time }}:2"></div>
                                @else
                                    <div class="bg-red-500 time" id="time:{{ $date['id'] }}:{{ $time }}:0"></div>
                                @endif
                            </div>
                            <div class="mt-0.5 rounded-sm grid grid-cols-3">
                                <div class="col-span-2 py-3 text-center">
                                    @php
                                        $time = 14 + $i;
                                        echo str($time).':00 - '.($time+1).':00';
                                        $stat = 0;
                                    @endphp
                                </div>
                                @foreach($date['schedules'] as $schedule)
                                    @if ($schedule['time'] == $time)
                                        @php
                                            $stat = $schedule['status'];
                                        @endphp
                                    @endif
                                @endforeach
                                @if ($stat == 1)
                                    <div class="bg-green-500 time" id="time:{{ $date['id'] }}:{{ $time }}:1"></div>
                                @elseif($stat == 2)
                                    <div class="bg-black time" id="time:{{ $date['id'] }}:{{ $time }}:2"></div>
                                @else
                                    <div class="bg-red-500 time" id="time:{{ $date['id'] }}:{{ $time }}:0"></div>
                                @endif
                            </div>
                        @endfor
                    </div>
                </div>
            </div>
            @php
                $jad++;
            @endphp
        @endforeach
    </div>

    <script>
        $(document).ready(function(){
            $(document).on('click','.jadwal',function(){
                let id =  $(this).attr('id');
                let num = id.split('-')[1];
                $('#jamJadwal-'+num).slideToggle('slow');
            });
            $(document).on('click','.time',function(){
                let item = $(this);
                let id = $(this).attr('id');
                let date = id.split(':')[1];
                let time = id.split(':')[2];
                let status = id.split(':')[3];
                if(status != 2){
                    Swal.showLoading();
                    $.ajax({
                        url: "{{ route('admin.select.schedule.update') }}",
                        type: "POST",
                        data: {
                            "_token": "{{ csrf_token() }}",
                            "date_id": date,
                            "time": time,
                            "status": status
                        },
                        success: function(e){
                            console.log(e)
                            Swal.hideLoading();
                            if(e.success){
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Success',
                                    text: e.message,
                                    showConfirmButton: false,
                                    timer: 500
                                })
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: e.message,
                                    showConfirmButton: false,
                                    timer: 1000
                                })
                            }
                            statusBaru = status == 1 ? 0 : 1;
                            let idBaru = id.split(':')[0]+':'+id.split(':')[1]+':'+id.split(':')[2]+':'+statusBaru;
                            // console.log(d, id, idBaru);
                            if(status == 0){
                                // console.log($("#time:" + date + ":" + time + ":" + status).attr('id'));
                                item.removeClass('bg-red-500');
                                item.addClass('bg-green-500');
                                item.attr('id',idBaru);
                            }else{
                                // console.log($(this).attr('id'));
                                item.removeClass('bg-green-500');
                                item.addClass('bg-red-500');
                                item.attr('id',idBaru);
                            }
                        }
                    });
                }
            })
        })
    </script>


@endsection