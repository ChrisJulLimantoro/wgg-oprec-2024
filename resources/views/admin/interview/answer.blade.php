@extends('admin.layout')
@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
    <h1 class="text-center text-5xl uppercase font-bold mb-5">Applicant's Answers</h1>
    <h2 class="text-center text-3xl uppercase font-bold mb-5">{{ $nrp }} - {{ $name }}</h2>
</div>
@foreach($sections as $sec)
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8 px-12">
    <h1 class="text-center text-3xl uppercase font-bold">Section : {{ $sec['name'] }}</h1>
    <h4 class="text-center text-lg uppercase font-bold mb-3">Interviewer : {{ $sec['interviewer'] }}</h4>
    @if(!$sec['interviewed'])
    <h4 class="text-center text-md uppercase font-bold mb-3 text-rose-500">Status : Not Interviewed</h4>
    @else
    @foreach($sec['questions'] as $q)
        <div class="mb-5 w-full">
            <div class="text-md font-bold uppercase w-full">{{ $q['number'] }}. {{ $q['question'] }}<br><i class="text-sm pl-5">desc : {{ $q['description'] }}</i></div>
            @if(!$q['answered'])
            <div class="text-md text-rose-500 w-full pl-5">Unanswered</div>
            @else
            <div class="text-md w-full italic text-end">score : {{ $q['score'] }}/5</div>
            <div class="text-sm w-full text-blue-700 italic pl-5">answer : {{ $q['answer'] }}</div>
            @endif
        </div>
    @endforeach
    @endif
</div>
@endforeach


@endsection