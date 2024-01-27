<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Document</title>

    <style>
        @page {
            margin: 77px;
        }

        .page-break {
            page-break-after: always;
        }

        header {
            margin-bottom: 24px;
        }

        header table {
            width: 100%;
        }

        header td:first-of-type,
        header td:last-of-type {
            width: 70px;
        }

        header td:last-of-type img {
            float: right;
        }

        .h1 {
            text-align: center;
            font-size: 1.5em;
            font-weight: 800;
            margin: 0;
        }

        .h2 {
            text-align: center;
            margin-block: 0;
            font-size: 1.3em;
            font-weight: 600;
        }

        main {
            position: relative;
        }

        .photo {
            position: absolute;
            right: 0;
            top: 0;
        }

        .data {
            margin-bottom: 24px;
        }

        .data tr>.label {
            width: 153px;
        }

        .data tr>.value {
            width: 320px;
        }

        .data td {
            vertical-align: top;
        }

        .signature {
            width: 100%;
        }

        .signature tr td:last-child {
            width: 270px;
            text-align: center;
        }
    </style>
</head>

<body>
    <header>
        <table>
            <tbody>
                <tr>
                    <td>
                        <img src="{{ asset('assets/PCU Logogram.png') }}" alt="PCU" height="60">
                    </td>
                    <td>
                        <div class="h1">CURRICULUM VITAE</div>
                        <div class="h2">Welcome Grateful Generation 2024</div>
                    </td>
                    <td>
                        <img src="{{ asset('assets/wgg.png') }}" alt="" height="60">
                    </td>
                </tr>
            </tbody>
        </table>
    </header>
    <main>
        <section class="photo">
            <img src="{{ route('upload',['path' => 'photo/'.$applicant['documents']['photo'] ]) }}" alt="Foto Diri"
                width="110">
        </section>
        <section class="data">
            <table>
                <tbody>
                    <tr>
                        <td class="label">Nama Lengkap</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['name'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">NRP</td>
                        @php
                            $email = $applicant['email'];
                            $nrp = explode('@', $email)[0];
                        @endphp
                        <td>:</td>
                        <td class="value">{{ $nrp }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Jurusan</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['major']['name'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Jenis Kelamin</td>
                        <td>:</td>
                        <td class="value">{{ ['Laki-laki', 'Perempuan'][$applicant['gender']] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Agama</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['religion'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Tempat, Tanggal Lahir</td>
                        <td>:</td>
                        <td class="value">{{ sprintf('%s, %s', $applicant['birthplace'], $applicant['birthdate']) }}
                        <td></td>
                        </td>
                    </tr>
                    <tr>
                        <td class="label">Alamat</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['address'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">IPK Terakhir</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['gpa'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">No HP</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['phone'] }}</td>
                        <td></td>
                    </tr>
                    @if ($applicant['line'] && strlen($applicant['line']) > 2)
                        <tr>
                            <td class="label">ID Line</td>
                            <td>:</td>
                            <td class="value">{{ $applicant['line'] }}</td>
                            <td></td>
                        </tr>
                    @endif
                    @if ($applicant['instagram'] && strlen($applicant['instagram']) > 2)
                        <tr>
                            <td class="label">Instagram</td>
                            <td>:</td>
                            <td class="value">{{ $applicant['instagram'] }}</td>
                            <td></td>
                        </tr>
                    @endif
                    @if ($applicant['tiktok'] && strlen($applicant['tiktok']) > 2)
                        <tr>
                            <td class="label">TikTok</td>
                            <td>:</td>
                            <td class="value">{{ $applicant['tiktok'] }}</td>
                            <td></td>
                        </tr>
                    @endif
                    <tr>
                        <td class="label">Motivasi</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['motivation'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Kelebihan</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['strength'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Kekurangan</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['weakness'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Komitmen</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['commitment'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Pengalaman Organisasi / Panitia</td>
                        <td>:</td>
                        <td class="value">{{ $applicant['experience'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">ASTOR</td>
                        <td>:</td>
                        <td class="value">{{ ['Tidak', 'Iya'][$applicant['astor']] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Divisi Pilihan Pertama</td>
                        <td>:</td>
                        <td class="value">{{ $applicant->priorityDivision1['name'] }}</td>
                        <td></td>
                    </tr>
                    <tr>
                        <td class="label">Divisi Pilihan Kedua</td>
                        <td>:</td>
                        <td class="value">{{ data_get($applicant->priorityDivision2, 'name') }}</td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
        </section>
        <section>
            <div style="margin-bottom: 32px">
                Informasi yang telah saya berikan sebagaimana tertulis diatas, secara keseluruhan adalah jujur dan benar
                adanya, tanpa
                rekayasa apapun serta tanpa ada paksaan dari pihak manapun. Apabila dikemudian hari ditemukan
                ketidaksesuaian
                data, saya yang bertandatangan dibawah ini bersedia menerima segala konsekuensi yang diberikan.
            </div>
            <table class="signature">
                <tbody>
                    <tr>
                        <td></td>
                        <td>
                            <div style="margin-bottom: 120px">Surabaya, {{ date('d-m-Y', time()) }}</div>
                            <div>{{ $applicant['name'] }}</div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </section>
    </main>
    <div class="page-break"></div>
    <footer>
        <h2>Lampiran</h2>
        <div>
            <a href="{{ route('upload',['path' => 'ktm/'.$applicant['documents']['ktm'] ]) }}" target="_blank">
                <h3>KTM</h3>
            </a>
            <img src="{{ route('upload',['path' => 'ktm/'.$applicant['documents']['ktm'] ]) }}" alt="KTM"
                style="max-width: 100%; max-height: 85%">
        </div>
        <div class="page-break"></div>
        <div>
            <a href="{{ route('upload',['path' => 'skkk/'.$applicant['documents']['skkk'] ]) }}" target="_blank">
                <h3>SKKK</h3>
            </a>
            <img src="{{ route('upload',['path' => 'skkk/'.$applicant['documents']['skkk'] ]) }}" alt="SKKK"
                style="max-width: 100%; max-height: 85%">
        </div>
        <div class="page-break"></div>
        <div>
            <a href="{{ route('upload',['path' => 'grades/'.$applicant['documents']['grades'] ]) }}" target="_blank">
                <h3>Transkrip</h3>
            </a>
            <img src="{{ route('upload',['path' => 'grades/'.$applicant['documents']['grades'] ]) }}" alt="Transkrip"
                style="max-width: 100%; max-height: 85%">
        </div>
        <div class="page-break"></div>
        <div>
            <a href="{{ route('upload',['path' => 'schedule/'.$applicant['documents']['schedule'] ]) }}" target="_blank">
                <h3>Jadwal Hidup</h3>
            </a>
            <img src="{{ route('upload',['path' => 'schedule/'.$applicant['documents']['schedule'] ]) }}"
                alt="Jadwal Hidup" style="max-width: 100%; max-height: 85%">
        </div>
    </footer>
</body>

</html>
