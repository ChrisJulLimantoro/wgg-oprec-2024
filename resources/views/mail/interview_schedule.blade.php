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
            <p><b>Dear {{ $data['applicant']->name }},</b></p><br />
            <p>Thankyou for your enthusiasm to join WGG 2024 Open Recruitment!</p>
            <p>Kindly review your interview schedules below as the next step for your selection</p>
        </div>

        <div class="table">
            <table>
                <thead>
                    <tr>
                        <th>Divisi</th>
                        <th>Tanggal</th>
                        <th>Jam</th>
                        <th>Lokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data['schedules'] as $s)
                    {{-- @dd($s); --}}
                        <tr>
                            <td>
                                @if ($s->type == 0)
                                    {{ strtoupper($data['applicant']->priorityDivision1->slug . ' & ' . $data['applicant']->priorityDivision2->slug) }}
                                @elseif($s->type == 1)
                                    {{ strtoupper($data['applicant']->priorityDivision1->slug) }}
                                @elseif($s->type == 2)
                                    {{ strtoupper($data['applicant']->priorityDivision2->slug) }}
                                @endif
                            </td>
                            <td>{{ Datetime::createFromFormat('Y-m-d', $s->date->date)->format('D, d M Y') }}</td>
                            <td>
                                {{ str_pad($s->time, 2, '0', STR_PAD_LEFT) . ':00 - ' . str_pad($s->time + 1, 2, '0', STR_PAD_LEFT) . ':00 WIB' }}
                            </td>

                            @if ($s->online == 1)
                                <td><a href="{{ $s->admin->meet }}">Online</a></td>
                            @else
                                <td>{{ $s->admin->spot ?? '-' }}</td>
                            @endif
                        </tr>
                    @endforeach
                </tbody>
            </table>

        </div>

        <div class="closing">
            <p>Good luck!</p>
            <p>If you have any questions, you may contact <b>@wgg.pcu</b> on IG</p>
            <p>Best Regards, WGG 2024 Committee</p>
        </div>
    </div>
@endsection
