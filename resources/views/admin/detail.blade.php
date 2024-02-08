@extends('admin.layout')
@section('content')
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
        <h1 class="text-center text-4xl uppercase font-bold">Detail Pendaftar</h1>
    </div>
    <div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10 px-8">
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <h1 class="text-center text-2xl uppercase font-bold italic mb-3">Personal Data</h1>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <div class="w-full px-8">
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">name : </b>{{ $applicant->name }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">nrp : </b>{{ substr($applicant->email,0,9) }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">major : </b>{{ $applicant->major->english_name }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">gpa : </b>{{ $applicant->gpa }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">gender : </b>{{ $applicant->gender == 0 ? 'Male': 'Female' }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">birth place : </b>{{ $applicant->birthplace }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">birth date : </b>{{ $applicant->birthdate }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">religion : </b>{{ $applicant->religion }}</h1>
        </div>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <h1 class="text-center text-2xl uppercase font-bold italic mb-3">Current Whereabout data</h1>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <div class="w-full px-8">
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">address : </b>{{ $applicant->address }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">city : </b>{{ $applicant->city }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">province : </b>{{ $applicant->province }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">postal code : </b>{{ $applicant->postal_code }}</h1>
        </div>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <h1 class="text-center text-2xl uppercase font-bold italic mb-3">contact data</h1>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <div class="w-full px-8">
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">email : </b>{{ $applicant->email }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">phone : </b>{{ $applicant->phone }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">line : </b>{{ $applicant->line }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">instagram : </b>{{ $applicant->instagram }}</h1>
            @if(isset($applicant->tiktok))
                <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">tiktok : </b>{{ $applicant->tiktok }}</h1>
            @endif
        </div>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <h1 class="text-center text-2xl uppercase font-bold italic mb-3">Medical data</h1>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <div class="w-full px-8">
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Food Diet : </b>{{ $applicant->diet }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">allergy : </b>{{ $applicant->allergy }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Disease History : </b>
                @foreach ($applicant->diseases as $disease)
                    {{ $disease->name }}{{ $loop->last ? '' : ', ' }}
                @endforeach
            </h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Other Diseases : </b>{{ $applicant->medical_history['other_disease'] }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Disease Explanation : </b>{{ $applicant->medical_history['disease_explanation'] }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Medication Allergy : </b>{{ $applicant->medical_history['medication_allergy'] }}</h1>
        </div>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <h1 class="text-center text-2xl uppercase font-bold italic mb-3">Application data</h1>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <div class="w-full px-8">
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Motivation : </b>{{ $applicant->motivation }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">strength : </b>{{ $applicant->strength }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">weakness : </b>{{ $applicant->weakness }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">commitment : </b>{{ $applicant->commitment }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Experience : </b>{{ $applicant->experience }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Astor : </b>{{ ['tidak','iya'][$applicant->astor] }}</h1>
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">First Division : </b>{{ $applicant->priorityDivision1['name'] }}</h1>
            @isset($applicant->priorityDivision2)
            <h1 class="uppercase text-lg mb-3"><b class="text-xl font-bold italic">Second Division : </b>{{ $applicant->priorityDivision2['name'] }}</h1>
            @endIsset
        </div>
        @foreach ($documentTypes as $type => $label)
        @php
            $imgSrc = '';
            if ($applicant['documents'] && array_key_exists(strtolower($type), $applicant['documents'])) {
                $imgSrc = route('upload', ['path' => strtolower($type) . '/' . data_get($applicant['documents'], strtolower($type))]);
            }
        @endphp
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        <h1 class="text-center text-2xl uppercase font-bold italic mb-3">{{ $label }} File <a href="{{ $imgSrc }}" target="_blank" class="text-blue-600 italic text-md"> >Open file< </a></h1>
        <div class="h-1 w-full bg-gradient-to-r from-gray-100 via-gray-400 to-gray-100 bg-repeat mb-4"></div>
        
        <img src="{{ $imgSrc }}" alt="{{ $label }}"
            class="{{ $applicant['documents'] && array_key_exists(strtolower($type), $applicant['documents']) ? '' : 'hidden' }} max-h-[400px] max-w mb-5"
            style="max-width: 100%">
        @endforeach
    </div>
@endsection