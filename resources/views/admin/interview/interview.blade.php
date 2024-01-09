@extends('admin.layout')
@section('content')
    <input type="hidden" id="applicant" value="{{ $applicant }}"> 
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
        <h1 class="text-center text-6xl uppercase font-bold mb-5">Interview applicant</h1>
        <h3 class="text-center text-4xl uppercase font-bold mb-3">Section : {{ $part }}</h3>
        <a href="{{ route('admin.applicant.cv',$applicant) }}" target="_blank" class="text-center text-2xl uppercase font-bold italic text-blue-500"> < Detail Applicant > </a>
    </div>
    <div class="flex flex-col w-full p-8 rounded-lg shadow-xl items-center justify-center mb-8">
        @php
            $count = 1;
        @endphp
        @foreach($questions as $q)
        <div class="w-full mb-10 text-start">
            <h3 class="text-2xl uppercase font-bold">Number {{ $count }} :</h3>
            <p class="text-md mb-3">{{ $q['question'] }}</p>
            <h3 class="text-xl font-bold">Deskripsi : </h3>
            <p class="text-md mb-3">{{ $q['description'] }}</p>
            <div class="w-full mb-5">
                <div class="grid grid-cols-2 mb-2">
                    <div class="flex text-start justify-start align-center">
                        <label class="font-serif ml-2 my-auto label-input font-bold text-lg" for="answer-{{ $count }}">Jawaban:</label>
                    </div>
                @if($q['answered'])
                    <div class="flex w-full justify-end items-end mb-2">
                        <input type="number" class="mr-1 rounded-lg score" value="{{ $q['score'] }}" name="score-{{ $count }}" id="score-{{ $count }}" min="0" max="5">
                    </div>
                </div>
                    <textarea id="answer-{{ $count }}" rows="3" class="border-2 py-2 pl-3 w-full rounded-lg shadow-xl hover:shadow-2xl hover:bg-gray-100 answer" placeholder="Answer goes here...">{{ $q['answer'] }}</textarea>
                    <input type="hidden" id="answered-{{ $count }}" value="{{ $q['answer_id'] }}">
                @else
                    <div class="flex w-full justify-end items-end mb-2">
                        <input type="number" class="mr-1 rounded-lg score" value="0" name="score-{{ $count }}" id="score-{{ $count }}" min="0" max="5">
                    </div>
                </div>
                    <textarea id="answer-{{ $count }}" rows="3" class="border-2 py-2 pl-3 w-full rounded-lg shadow-xl hover:shadow-2xl hover:bg-gray-100 answer" placeholder="Answer goes here..."></textarea>
                    <input type="hidden" id="answered-{{ $count }}" value="0">
                @endif
                <input type="hidden" id="question-{{ $count }}" value="{{ $q['id'] }}">
            </div>
        </div>
        @php
            $count++;
        @endphp
        @endforeach
        @if(!$next)
        <div class="w-full text-start">
            @isset($project)
            @foreach($project as $p)
                <h3 class="text-2xl uppercase font-bold">Project Department {{ $p['name'] }}:</h3>
                <p class="text-md mb-3">{{ $p['project'] }}</p>
            @endforeach
            @endisset
        </div>
        @endif
        <div class="w-full flex justify-center align-center gap-2">
            @if($prev)
            <a href="{{ route('admin.interview.session',['schedule_id' => $schedule,'page'=> $now-1 ]) }}">
                <button
                type="button"
                data-te-ripple-init
                data-te-ripple-color="light"
                class="inline-block rounded bg-danger px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-danger-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-danger-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-danger-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Prev
                </button>
            </a>
            @endif
            @if($next)
                <a href="{{ route('admin.interview.session',['schedule_id' => $schedule,'page'=> $now+1 ]) }}">
                    <button
                    type="button"
                    data-te-ripple-init
                    data-te-ripple-color="light"
                    class="inline-block rounded bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                        Next
                    </button>
                </a>
            @else
                <button
                type="button"
                data-te-ripple-init
                data-te-ripple-color="light"
                id="add-project"
                class="inline-block rounded bg-warning px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-warning-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-warning-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-warning-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Add Project
                </button>
                <button
                type="button"
                data-te-ripple-init
                data-te-ripple-color="light"
                id="finish"
                class="inline-block rounded bg-success px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-success-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-success-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-success-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    Finish
                </button>
            @endif
        </div>
    </div>
@endsection
@section('script')
    <script>
        $(document).ready(function(){
            $(document).on('change','.score',function(){
                var id = $(this).attr('id');
                var score = $(this).val();
                var question = id.split('-')[1];
                var applicant = $('#applicant').val();
                var answered = $('#answered-'+question).val();
                var question_id = $('#question-'+question).val();
                Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading()
                        if(answered == 0){
                            $.ajax({
                            url:  "{{ route('admin.interview.submit.score') }}",
                            method: "POST",
                            dataType: 'json', 
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "score" : score,
                                "question_id": question_id,
                                "applicant_id": applicant,
                            } ,
                            success: function(res){
                                console.log(res);
                                if(res.success){
                                    Swal.close();
                                    Swal.fire('Success', res.message, 'success');
                                    $('#answered-'+question).val(res.answer_id);
                                }else{
                                    Swal.fire('Error',res.message,'error')
                                }
                                
                            },
                            error: function(err){
                                Swal.close();
                                Swal.fire('Error', 'Error Selama Pengiriman Data', 'error');
                            }
                            })
                        }else{
                            $.ajax({
                            url:  "{{ route('admin.interview.update.score') }}",
                            method: "POST",
                            dataType: 'json', 
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "score" : score,
                                "answer_id": answered,
                            } ,
                            success: function(res){
                                console.log(res);
                                if(res.success){
                                    Swal.close();
                                    Swal.fire('Success', res.message, 'success');
                                }else{
                                    Swal.fire('Error',res.message,'error')
                                }
                                
                            },
                            error: function(err){
                                Swal.close();
                                Swal.fire('Error', 'Error Selama Pengiriman Data', 'error');
                            }
                            })
                        }
                    }
                });
            });
            $('.answer').change(function(){
                var id = $(this).attr('id');
                var answer = $(this).val();
                var question = id.split('-')[1];
                var applicant = $('#applicant').val();
                var score = $('#score-'+question).val();
                var answered = $('#answered-'+question).val();
                var question_id = $('#question-'+question).val();
                Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading()
                        if(answered == 0){
                            $.ajax({
                            url:  "{{ route('admin.interview.submit.answer') }}",
                            method: "POST",
                            dataType: 'json', 
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "answer" : answer,
                                "question_id": question_id,
                                "applicant_id": applicant,
                            } ,
                            success: function(res){
                                if(res.success){
                                    Swal.close();
                                    Swal.fire('Success', res.message, 'success');
                                    $('#answered-'+question).val(res.answer_id);
                                }else{
                                    Swal.fire('Error',res.message,'error')
                                }
                                
                            },
                            error: function(err){
                                Swal.close();
                                Swal.fire('Error', 'Error Selama Pengiriman Data', 'error');
                            }
                            })
                        }else{
                            $.ajax({
                            url:  "{{ route('admin.interview.update.answer') }}",
                            method: "POST",
                            dataType: 'json', 
                            data: {
                                "_token": "{{ csrf_token() }}",
                                "answer" : answer,
                                "answer_id": answered,
                            } ,
                            success: function(res){
                                console.log(res);
                                if(res.success){
                                    Swal.close();
                                    Swal.fire('Success', res.message, 'success');
                                }else{
                                    Swal.fire('Error',res.message,'error')
                                }
                                
                            },
                            error: function(err){
                                Swal.close();
                                Swal.fire('Error', 'Error Selama Pengiriman Data', 'error');
                            }
                            })
                        }
                    }
                });
            });
            $('#add-project').on('click',function(){
                var applicant = $('#applicant').val();
                Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                    url:  "{{ route('admin.interview.add.project') }}",
                    method: "POST",
                    dataType: 'json', 
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "applicant_id": applicant,
                    } ,
                    success: function(res){
                        console.log(res);
                        if(res.success){
                            Swal.close();
                            Swal.fire('Success', 'Berhasil Add Project', 'success');
                        }else{
                            Swal.fire('Error','Gagal Add Project','error')
                        }
                        
                    },
                    error: function(err){
                        Swal.close();
                        Swal.fire('Error', 'Error Selama Pengiriman Data', 'error');
                    }
                    })
                    }
                });
            })
            $('#finish').on('click',function(){
                var applicant = $('#applicant').val();
                Swal.fire({
                title: 'Saving...',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => {
                    Swal.showLoading()
                    $.ajax({
                    url:  "{{ route('admin.interview.finish') }}",
                    method: "POST",
                    dataType: 'json', 
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "applicant_id": applicant,
                    } ,
                    success: function(res){
                        console.log(res);
                        if(res.success){
                            Swal.close();
                            Swal.fire('Success', 'Interview Finished', 'success').then((result)=>{
                                window.location.href = "{{ route('admin.select.schedule') }}"
                            });
                        }else{
                            Swal.fire('Error','Finished Failed','error')
                        }
                        
                    },
                    error: function(err){
                        Swal.close();
                        Swal.fire('Error', 'Error Selama Pengiriman Data', 'error');
                    }
                    })
                    }
                });
            })
        });
    </script>
@endsection