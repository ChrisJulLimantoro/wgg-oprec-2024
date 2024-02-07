@extends('mail.layout')

@section('style')
    <style>
        .greetings {
            font-size: 14px;
            margin-bottom: 2px;
        }

        .table {
            margin-top: 20px;
            overflow-y: auto;
            text-align: center;
        }

        .closing {
            margin-top: 20px;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse
        }

        table th {
            background-color: #273656;
            color: #fff;
            padding: 5px;
            font-weight: bold;
        }

        tr {
            border: none;
        }

        td,
        th {
            padding: 5px;
            border: 1px solid #273656;
        }

        p {
            margin: 0;
            color: #000 !important;
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="greetings">
            <p><b>Dear {{ $data['name'] }},</b></p><br />
            <p><b>{{ $data['slug'] }} Division has low available schedule count with only {{ $data['count'] }} schedules.</b></p><br>
            <p><b>Please kindly make new schedule at minimum of 20 schedules!</b></p>
        </div>

        <div class="closing">
            <p>Good luck!</p>
            <p>Don't be lazy to take any interview!</p>
            <p>Best Regards, WGG 2024 Committee</p>
        </div>
    </div>
@endsection
