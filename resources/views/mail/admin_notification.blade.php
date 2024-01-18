@extends('mail.layout')

@section('style')
    <style>
        .greetings {
            font-size: 14px;
            margin-bottom: 2px;
        }

        .greetings > *:not(:first-child) {
            margin-top: 0.75em;
            margin-bottom: 0.75em;
        }

        .table {
            margin-top: 20px;
            overflow-y: auto;
            text-align: center;
        }

        .closing {
            margin-top: 20px;
            margin-bottom: 10px;
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

        .divider {
            width: 100%;
            margin: 0;
        }

        .action-btn {
            background-color: #273656;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
@endsection

@section('content')
    <div class="">
        <div class="greetings">
            <p><b>Dear {{ $data['schedules']->admin->name }},</b></p>

            <p>You have a new interview scheduled to you</p>

            <p>
                Name:
                <b>{{ $data['applicant']->name }}</b>
                <br>
                NRP: <b>{{ substr($data['applicant']->email, 0, 9) }}</b>
            </p>

            <a href="{{ route('admin.applicant.cv', $data['applicant']) }}" target="_blank">
                <button class="action-btn">View CV</button>
            </a>
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Divisi</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Lokasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        @if ($data['schedules']->type == 0)
                            <td>{{ strtoupper($data['applicant']->priorityDivision1->slug . ' & ' . $data['applicant']->priorityDivision2->slug) }}
                            </td>
                        @elseif($data['schedules']->type == 1)
                            <td>
                                {{ strtoupper($data['applicant']->priorityDivision1->slug) }}
                            </td>
                        @elseif($data['schedules']->type == 2)
                            <td>
                                {{ strtoupper($data['applicant']->priorityDivision2->slug) }}
                            </td>
                        @endif

                        <td>{{ Datetime::createFromFormat('Y-m-d', $data['schedules']->date->date)->format('D, d M Y') }}
                        </td>
                        <td>
                            {{ str_pad($data['schedules']->time, 2, '0', STR_PAD_LEFT) . ':00 - ' . str_pad($data['schedules']->time + 1, 2, '0', STR_PAD_LEFT) . ':00 WIB' }}
                        </td>

                        @if ($data['schedules']->online == 1)
                            <td><a href="{{ $data['schedules']->admin->meet }}">Online</a></td>
                        @else
                            <td>{{ $data['schedules']->admin->spot ?? '-' }}</td>
                        @endif

                        <td>
                            <a href="{{ route('admin.interview.start', $data['schedules']->id) }}">
                                <button class="action-btn">Start Interview</button>
                            </a>
                        </td>
                    </tr>
                </tbody>
            </table>

        </div>

        <div class="closing">
            <p>Best Regards, <br><b>WGG 2024 IT Division</b></p>
        </div>
    </div>
@endsection
