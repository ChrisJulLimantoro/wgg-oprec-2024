<!DOCTYPE html>
<html lang="en" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>OPEN RECRUITMENT | WGG 2024</title>

    <!-- ThreeJs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/0.148.0/three.min.js"></script>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Asap:wght@400;600;700;800&display=swap" rel="stylesheet">

    <!-- tailwind -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tailwindcss/2.2.19/tailwind.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- jQuery -->
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>

    <!-- Swiper -->
    <link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
    <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

    <!-- Vanilla tilt -->
    <script type="text/javascript" src="{{ asset('assets/vanilla-tilt.js') }}"></script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/ScrollTrigger.min.js"></script>

    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                fontFamily: {
                    'asap': ["Asap"],
                    'dillan': ["dillan"],
                },
            },
        };
    </script>

    <style>
        @font-face {
            font-family: dillan;
            src: url('{{ asset('assets/dillan.otf') }}') format('truetype');
        }

        ::-webkit-scrollbar {
            width: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: rgb(23, 24, 56);
            background: linear-gradient(180deg, rgba(23, 24, 56, 1) 0%, rgba(126, 126, 194, 1) 49%, rgba(237, 214, 235, 1) 100%);
            border-radius: 8px;
        }

        ::-webkit-scrollbar-track {
            width: 0;
            background-color: transparent;
        }

        canvas {
            margin: auto;
            position: fixed;
            top: 0px;
            left: 0px;
            width: 100% !important;
            height: 100% !important;
            z-index: 0;
        }

        /* About WGG */
        .tampilan {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            backface-visibility: hidden;
            border-radius: 5px;
        }

        .depan {
            background: -webkit-linear-gradient(top,
                    hsla(54, 4%, 85%, 1) 0%,
                    hsla(54, 0%, 96%, 1) 50%,
                    hsla(54, 4%, 80%, 1) 100%);
            z-index: 20;
        }

        .belakang {
            background: -webkit-linear-gradient(top,
                    hsla(54, 0%, 96%, 1) 0%,
                    hsla(54, 0%, 56%, 1) 100%);
            transform: rotateY(-180deg);
        }

        #part2:after {
            content: "";
            position: absolute;
            bottom: -140px;
            left: -200px;
            height: 0;
            width: 80px;
            border-bottom: 175px solid hsla(0, 0%, 95%, 1);
            border-left: 200px solid transparent !important;
            border-right: 200px solid transparent !important;
        }

        #part2:before {
            content: "";
            position: absolute;
            top: -140px;
            right: -200px;
            width: 0;
            height: 0;
            border-right: 200px solid hsla(0, 0%, 90%, 1);
            border-top: 140px solid transparent;
            border-bottom: 140px solid transparent;
        }

        /* Our Division */
        .swiper-wrapper {
            transition: transform 0.5s ease-out;
        }

        .swiper-slide {
            width: 280px;
            height: 320px;
            border-radius: 15px;
        }

        .tilt-card {
            width: 280px;
            height: 320px;
            border-radius: 15px;
            box-shadow: 10px 10px 30px rgba(0, 0, 0, 0.5);
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            justify-content: center;
            align-items: center;
            border-top: 1px solid rgba(255, 255, 255, 0.5);
            border-left: 1px solid rgba(255, 255, 255, 0.5);
            backdrop-filter: blur(5px);
        }

        .acara:hover {
            background: rgba(245, 132, 3, 0.2);
        }

        .peran:hover {
            background: rgba(128, 0, 255, 0.2);
        }

        .it:hover {
            background: rgba(255, 0, 136, 0.2);
        }

        .creative:hover {
            background: rgba(0, 145, 255, 0.2);
        }

        .perkap:hover {
            background: rgba(0, 30, 255, 0.2);
        }

        .regul:hover {
            background: rgba(33, 82, 12, 0.2);
        }

        .konsum:hover {
            background: rgba(0, 255, 72, 0.2);
        }

        .kesehatan:hover {
            background: rgba(255, 247, 0, 0.2);
        }

        .sekret:hover {
            background: rgba(255, 0, 0, 0.2);
        }

        .swiper-slide .content {
            padding: 20px;
            text-align: center;
        }

        .swiper-slide .content img {
            width: 280px;
            opacity: 0.8;
            position: absolute;
            opacity: 0.15;
        }

        /* How To Join */
        .timeline {
            text-align: left;
            display: flex;
        }

        .timeline-container {
            display: grid;
            grid-template-columns: 30% auto;
            justify-content: center;
        }

        .timeline-container ul {
            display: flex;
            flex-direction: column;
            justify-content: center;
            list-style: none;
            padding: 0;
        }

        .timeline-container ul li {
            margin-top: 10px;
            height: 90px;
            position: relative;
            padding: 15px;
            animation-fill-mode: both;
            display: flex;
        }

        .timeline-container ul li p {
            padding: 0 50px;
        }

        .timeline-line {
            background: rgb(228, 228, 228);
            width: 4px;
            height: 100%;
            border-radius: 12px;
            position: relative;
            justify-self: end;
            animation-fill-mode: both;
        }

        .timeline-point {
            border: none;
            position: absolute;

            border-radius: 50%;
            background: rgb(228, 228, 228);
            width: 15px;
            height: 15px;

            top: 30px;
            left: -10px;
        }

        @media screen and (min-width: 990px) {
            .timeline {
                text-align: center;
            }

            .timeline-container {
                display: block;
            }

            .timeline-container ul {
                flex-direction: row;
                margin-top: 30px;
            }

            .timeline-container ul li {
                margin-top: 0px;
                position: relative;
                width: 100%;
                padding: 0px;
                animation-fill-mode: both;
            }

            .timeline-point {
                width: 20px;
                height: 20px;

                top: -45px;
                left: 45%;
            }

            .timeline-line {
                width: 100%;
                height: 8px;
                background: rgb(228, 228, 228);
                border-radius: 12px;
                position: relative;
                justify-self: end;
                animation-fill-mode: both;
            }
        }

        /* Contact */
        .wrapper .icon {
            position: relative;
            background: #ffffff;
            border-radius: 50%;
            padding: 15px;
            margin: 10px;
            width: 50px;
            height: 50px;
            font-size: 18px;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            cursor: pointer;
            transition: all 0.2s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .tooltip {
            position: absolute;
            top: 0;
            font-size: 14px;
            background: #ffffff;
            color: #ffffff;
            padding: 5px 8px;
            border-radius: 5px;
            box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
            opacity: 0;
            pointer-events: none;
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .tooltip::before {
            position: absolute;
            content: "";
            height: 8px;
            width: 8px;
            background: #ffffff;
            bottom: -3px;
            left: 50%;
            transform: translate(-50%) rotate(45deg);
            transition: all 0.3s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .wrapper .icon:hover .tooltip {
            top: -45px;
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .wrapper .icon:hover span,
        .wrapper .icon:hover .tooltip {
            text-shadow: 0px -1px 0px rgba(0, 0, 0, 0.1);
        }

        .wrapper .line:hover,
        .wrapper .line:hover .tooltip,
        .wrapper .line:hover .tooltip::before {
            background: green;
            color: #ffffff;
        }

        .wrapper .instagram:hover,
        .wrapper .instagram:hover .tooltip,
        .wrapper .instagram:hover .tooltip::before {
            background: #e4405f;
            color: #ffffff;
        }

        .wrapper .tiktok:hover,
        .wrapper .tiktok:hover .tooltip,
        .wrapper .tiktok:hover .tooltip::before {
            background: #333333;
            color: #ffffff;
        }

        @media screen and (max-width: 1024px) {
            #mail-container {
                top: 400px;
            }
        }

        @media screen and (max-width: 500px) {
            .swiper-wrapper {
                scale: 0.8;
            }

            #mail-container,
            #wrapper {
                scale: 0.8;
            }

            #mail-container {
                top: 300px;
            }
        }

        @media screen and (max-width: 300px) {

            .timeline,
            .swiper-wrapper {
                scale: 0.8;
            }

            .wrapper .icon {
                scale: 0.8;
            }

            #mail-container,
            #wrapper {
                scale: 0.6;
            }
        }
    </style>

</head>

<body class="p-0 m-0 overflow-x-hidden bg-[#171838] h-screen font-asap select-none relative">
    {{-- Baymax --}}
    <img class="baymax absolute" id="baymax" src="{{ asset('assets/baymax.png') }}" alt="" style="z-index:1000; width:125px;">

    <!-- Landing -->
    <div class="w-full h-full"></div>
    <div class="w-full h-1/4"></div>
    <div class="container absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 mx-auto text-center flex flex-col justify-center"
        style="z-index: 1;">
        <h2 class="font-dillan text-[8vw] font-bold -mt-20 mb-8 xl:-mt-48 xl:mb-6 xl:text-[4vw] text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] gs_reveal"
            id="judul1">
            OPEN RECRUITMENT</h2>
        <div class="font-dillan h-14 text-[10vw] font-bold typing-container text-white whitespace-nowrap xl:text-[5vw] drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] gs_reveal"
            id="typing-container">
        </div>
    </div>

    <!-- About -->
    <div class="w-screen flex relative z-10 px-[10vw] mt-48 sm:mt-32 2xl:mt-52 ">
        <div class="h-1/3"></div>
        <div class=" text-white m-auto text-center">
            <h1
                class="font-dillan text-[8vw] font-bold xl:text-[4vw] mt-[250px] md:mt-[150px] drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] gs_reveal gs_reveal_fromBottom">
                ABOUT WGG</h1>
            <div id="mail-container" class="absolute top-[300px] left-1/2 ml-[-200px]">
                <div id="isi-mail" class="shadow-lg w-[400px] h-[280px]" style="transform-style: preserve-3d;">
                    <div class="tampilan depan ">
                        <div class="img flex justify-center text-center items-center">
                            <img src="{{ asset('assets/logo-wgg.png') }}" alt="" class="scale-75 w-[300px]">
                        </div>
                    </div>
                    <div class="tampilan belakang">
                        <div id="part1" class="absolute top-0 left-0 h-0 w-20 z-10"
                            style="transform-origin: center top;  border-top: 175px solid hsla(0, 0%, 85%, 1);  border-left: 200px solid transparent; border-right: 200px solid transparent;">
                        </div>
                        <div id="part2" class="absolute top-0 left-0 w-0 h-0 z-[5]"
                            style="border-left: 200px solid hsla(0, 0%, 90%, 1); border-top: 140px solid transparent; border-bottom: 140px solid transparent;">
                        </div>
                        <div id="part3"
                            class="rounded-[5px] absolute top-[3px] left-0 w-[390px] h-[200px] overflow-hidden z-[1]"
                            style="background: -webkit-linear-gradient(top, hsla(54, 0%, 96%, 1) 0%, hsla(0, 0%, 98%, 1) 70%, hsla(0, 0%, 95%, 1) 100%); box-shadow: 0px 2px 5px hsla(0, 0%, 10%, 1); margin: 0 0 0 5px;">
                            <p class="text-black text-md leading-[1.5em] mt-[30px] mx-[50px] text-justify"
                                style=" text-shadow: 0px 1px 1px hsla(0, 0%, 100%, 1);"><span
                                    class="font-dillan">Welcome Grateful Generation</span>
                                atau yang kerap kita kenal
                                sebagai WGG adalah kegiatan orientasi mahasiswa baru di Universitas Kristen Petra. Pada
                                acara ini, para mahasiswa baru diajak untuk mengenal dan beradaptasi dengan lingkungan
                                kampus.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div id="wrapper" class="w-full h-[700px]"></div>
        </div>
    </div>

    <!-- Our Division -->
    <div class="w-screen flex relative z-10 mt-10 sm:mt-52 mb-20">
        <div class="m-auto text-center bg-white w-full ">
            <h1 class=" font-dillan text-[8vw] font-bold xl:text-[4vw] text-[#171838] ">OUR DIVISION</h1>
        </div>
    </div>
    <div class="w-screen max-h-screen flex relative z-10 mt-5 sm:mt-24 py-2 sm:py-8">
        <div class="text-center w-screen max-h-screen">
            <div class="swiper-container w-full h-full overflow-hidden py-2 sm:py-8">
                <div class="swiper-wrapper text-md text-white">
                    <div class="swiper-slide">
                        <div class="tilt-card acara">
                            <div class="content">
                                <img src="{{ asset('assets/logo-acara.png') }}" alt=""
                                    class="top-[-60px] left-[80px]">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">Acara</h3>
                                <p class="mt-2">Divisi yang mengonsep dan memimpin jalannya acara untuk mengantarkan
                                    pesan kepada
                                    mahasiswa baru.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card creative">
                            <div class="content">
                                <img src="{{ asset('assets/logo-creative.png') }}" alt=""
                                    class="top-[-70px] left-[50px]">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">Creative
                                </h3>
                                <p class="mt-2">Divisi yang menjadi tempat untuk berkarya serta melayani melalui ide
                                    yang
                                    divisualisasikan dalam bentuk ilustrasi, desain, dan video.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card it">
                            <div class="content">
                                <img src="{{ asset('assets/logo-it.png') }}" alt=""
                                    class="top-[-70px] left-[60px]">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">IT</h3>
                                <p class="mt-2">Divisi yang bertugas untuk mengelola database dan website mengenai
                                    informasi seputar
                                    WGG dan mengatur data serta absensi mahasiswa peserta WGG.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card kesehatan">
                            <div class="content">
                                <img src="{{ asset('assets/logo-kesehatan.png') }}" alt=""
                                    class="top-[-65px] left-[55px] scale-90">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">Kesehatan
                                </h3>
                                <p class="mt-2">Divisi yang memberikan bantuan yang berhubungan dengan kesehatan dan
                                    bertanggung
                                    jawab atas kesehatan mahasiswa dan panitia selama WGG.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card konsum">
                            <div class="content">
                                <img src="{{ asset('assets/logo-konsumsi.png') }}" alt=""
                                    class="top-[-75px] left-[50px]">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">Konsumsi
                                </h3>
                                <p class="mt-2">Divisi yang memfasilitasi konsumsi untuk menemani mahasiswa baru
                                    selama
                                    menjalani WGG
                                    2023.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card peran">
                            <div class="content">
                                <img src="{{ asset('assets/logo-peran.png') }}" alt=""
                                    class="top-[-70px] left-[60px] scale-75">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">Peran</h3>
                                <p class="mt-2">Divisi yang menjadi wadah untuk menyambut dan mendampingi mahasiswa
                                    baru
                                    dalam
                                    persiapan menghadapi dunia perkuliahan dengan dasar yang benar.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card perkap">
                            <div class="content">
                                <img src="{{ asset('assets/logo-perkap.png') }}" alt=""
                                    class="top-[-60px] left-[60px] scale-90">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">
                                    Perlengkapan</h3>
                                <p class="mt-2">Divisi yang mempersiapkan segala keperluan barang maupun ruangan, dan
                                    menjadi
                                    operator multimedia selama kegiatan WGG.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card regul">
                            <div class="content">
                                <img src="{{ asset('assets/logo-regulasi.png') }}" alt=""
                                    class="top-[-65px] left-[60px] scale-[0.8]">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">Regulasi
                                </h3>
                                <p class="mt-2">Divisi yang bertanggung jawab dalam pembuatan dan pelaksanaan
                                    peraturan,
                                    menjaga
                                    keamanan, serta mengarahkan peserta WGG.</p>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="tilt-card sekret">
                            <div class="content">
                                <img src="{{ asset('assets/logo-sekret.png') }}" alt=""
                                    class="top-[-70px] left-[60px]">
                                <h3 class="drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] font-dillan text-2xl">
                                    Sekretariat
                                </h3>
                                <p class="mt-2">Divisi yang menjadi pusat data dan informasi bagi mahasiswa baru
                                    maupun
                                    panitia WGG.
                                    Bertugas untuk menyampaikan informasi, merekap absensi, dan surat menyurat.</p>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- How To Join -->
    <div class="w-screen flex relative z-10 mt-32 sm:mt-24">
        <div class="mx-auto text-center ">
            <h1 class="font-dillan text-[8vw] font-bold xl:text-[4vw] text-white gs_reveal gs_reveal_fromRight"
                id="howtojoin">HOW TO JOIN?</h1>
        </div>
    </div>
    <div
        class="w-screen max-h-[85%] sm:max-h-[50%] xl:max-h-1/2 flex relative z-10 mt-10 md:mt-28 mb-14 2xl:mb-10 text-white justify-center">
        <section class="timeline items-start xl:items-center" id="timeline">
            <div class="timeline-container gs_reveal" id="timeline-container">
                <div class="timeline-line">
                    <span class="timeline-innerline"></span>
                </div>
                <ul>
                    <li>
                        <span class="timeline-point"></span>
                        <p class="font-semibold text-lg sm:text-xl">Isi Data Diri</p>
                    </li>
                    <li>
                        <span class="timeline-point"></span>
                        <p class="font-semibold text-lg sm:text-xl">Upload Berkas</p>
                    </li>
                    <li>
                        <span class="timeline-point"></span>
                        <p class="font-semibold text-lg sm:text-xl">Melakukan Interview</p>
                    </li>
                    <li>
                        <span class="timeline-point"></span>
                        <p class="font-semibold text-lg sm:text-xl">Submit Project</p>
                    </li>
                </ul>
            </div>
        </section>
    </div>

    <div class="w-screen flex relative z-10 p-6 mt-18 2xl:mt-10">
        <div class="mx-auto text-center ">
            <a href="{{ route('login') }}">
                <button
                    class="uppercase text-white bg-indigo-600 hover:bg-pink-600 py-4 px-16 xl:px-32 text-lg xl:text-2xl font-bold rounded-full transform transition-all duration-500 ease-in-out hover:scale-110">
                    JOIN NOW!
                </button>
            </a>
        </div>
    </div>

    <!-- Contact -->
    <div class="w-screen h-[200px] flex relative z-10 p-20 justify-center wrapper gap-2 sm:gap-5">
        <a href="">
            <li class="icon line">
                <span class="tooltip">@328readn</span>
                <span><i class="fab fa-line"></i></span>
            </li>
        </a>
        <a href="https://www.instagram.com/wgg.pcu?utm_source=ig_web_button_share_sheet&igsh=ZDNlZDc0MzIxNw==">
            <li class="icon instagram">
                <span class="tooltip">@wgg.pcu</span>
                <span><i class="fab fa-instagram"></i></span>
            </li>
        </a>
        <a href="https://www.tiktok.com/@wgg.pcu?is_from_webapp=1&sender_device=pc">
            <li class="icon tiktok">
                <span class="tooltip">@wgg.pcu</span>
                <span><i class="fab fa-tiktok"></i></span>
            </li>
        </a>
    </div>

    <!-- Background -->
    <script>
        // console.clear();

        function perlin() {
            return `

          uniform vec2 u_resolution;
          uniform vec2 u_mouse;
          uniform float u_time;
          uniform float u_xpos;
          uniform float u_ypos;

        vec3 mod289(vec3 x) {
          return x - floor(x * (1.0 / 289.0)) * 289.0;
        }

        vec4 mod289(vec4 x) {
          return x - floor(x * (1.0 / 289.0)) * 289.0;
        }

        vec4 permute(vec4 x) {
             return mod289(((x*34.0)+1.0)*x);
        }

        vec4 taylorInvSqrt(vec4 r)
        {
          return 1.79284291400159 - 0.85373472095314 * r;
        }

        float snoise(vec3 v)
          {
          const vec2  C = vec2(1.0/6.0, 1.0/3.0) ;
          const vec4  D = vec4(0.0, 0.5, 1.0, 2.0);

          vec3 i  = floor(v + dot(v, C.yyy) );
          vec3 x0 =   v - i + dot(i, C.xxx) ;

          vec3 g = step(x0.yzx, x0.xyz);
          vec3 l = 1.0 - g;
          vec3 i1 = min( g.xyz, l.zxy );
          vec3 i2 = max( g.xyz, l.zxy );

          vec3 x1 = x0 - i1 + C.xxx;
          vec3 x2 = x0 - i2 + C.yyy;
          vec3 x3 = x0 - D.yyy;

          i = mod289(i);
          vec4 p = permute( permute( permute(
                     i.z + vec4(0.0, i1.z, i2.z, 1.0 ))
                   + i.y + vec4(0.0, i1.y, i2.y, 1.0 ))
                   + i.x + vec4(0.0, i1.x, i2.x, 1.0 ));

          float n_ = 0.142857142857;
          vec3  ns = n_ * D.wyz - D.xzx;

          vec4 j = p - 49.0 * floor(p * ns.z * ns.z);

          vec4 x_ = floor(j * ns.z);
          vec4 y_ = floor(j - 7.0 * x_ );

          vec4 x = x_ *ns.x + ns.yyyy;
          vec4 y = y_ *ns.x + ns.yyyy;
          vec4 h = 1.0 - abs(x) - abs(y);

          vec4 b0 = vec4( x.xy, y.xy );
          vec4 b1 = vec4( x.zw, y.zw );

          vec4 s0 = floor(b0)*2.0 + 1.0;
          vec4 s1 = floor(b1)*2.0 + 1.0;
          vec4 sh = -step(h, vec4(0.0));

          vec4 a0 = b0.xzyw + s0.xzyw*sh.xxyy ;
          vec4 a1 = b1.xzyw + s1.xzyw*sh.zzww ;

          vec3 p0 = vec3(a0.xy,h.x);
          vec3 p1 = vec3(a0.zw,h.y);
          vec3 p2 = vec3(a1.xy,h.z);
          vec3 p3 = vec3(a1.zw,h.w);

          vec4 norm = taylorInvSqrt(vec4(dot(p0,p0), dot(p1,p1), dot(p2, p2), dot(p3,p3)));
          p0 *= norm.x;
          p1 *= norm.y;
          p2 *= norm.z;
          p3 *= norm.w;

          vec4 m = max(0.6 - vec4(dot(x0,x0), dot(x1,x1), dot(x2,x2), dot(x3,x3)), 0.0);
          m = m * m;
          return 42.0 * dot( m*m, vec4( dot(p0,x0), dot(p1,x1),
                                        dot(p2,x2), dot(p3,x3) ) );
          }
        `;
        }

        const sampleScale = 1.5;

        let width = window.innerWidth * sampleScale;
        let height = window.innerHeight * sampleScale;
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(45, width / height, 0.1, 100);

        let smoothScrollY = window.scrollY;

        camera.position.z = 10;
        scene.add(camera);

        const renderer = new THREE.WebGLRenderer({
            alpha: true
        });
        renderer.setSize(width, height);
        document.body.appendChild(renderer.domElement);

        const startTime = new Date().getTime();

        const uniforms = {
            time: new THREE.Uniform(1),
            width: new THREE.Uniform(width),
            height: new THREE.Uniform(height),
            scrollY: new THREE.Uniform(window.scrollTop)
        };

        const bgPlane = new THREE.PlaneGeometry(
            camera.position.z * 2,
            camera.position.z * 2
        );
        const bgMaterial = new THREE.ShaderMaterial({
            uniforms,
            transparent: true,
            fragmentShader: `
            uniform float width;
            uniform float height;
            uniform float time;
            uniform float scrollY;

            float wavePos(float waveIndex, vec2 p, float numWaves){
                float sixth = 1./numWaves;
                float reverse = 1.;
                if(mod(waveIndex, 2.) == 0.) reverse = -1.;
                return sixth * waveIndex + sin(time + waveIndex * 9.14516 + p.x * 8. * reverse) * .02;
            }

            void main() {
                float minWindowDimension = min(width, height);
                vec2 p = gl_FragCoord.xy / vec2(width, height);
                vec2 squareP = gl_FragCoord.xy / vec2(minWindowDimension, minWindowDimension);
                vec2 truePScale = vec2(width, height) / minWindowDimension;
                p.y = 1. - p.y;

                vec3 color = vec3(0.4, 0.2, 0.8);
                float alpha = 1.;
                float numWaves = 5.65;
                if(height > width) numWaves = 6.;


            if((height - gl_FragCoord.y) + scrollY < height * 1.){
                if(p.y < wavePos(1., p, numWaves)) color = vec3(0.1, 0.1, 0.2);
                else if(p.y < wavePos(2., p, numWaves)) color = vec3(0.3, 0.2, 0.6);
                else if(p.y < wavePos(3., p, numWaves)) color = vec3(0.5, 0.3, 0.7);
                else if(p.y < wavePos(4., p, numWaves)) color = vec3(0.7, 0.4, 0.6);
                else if(p.y < wavePos(5., p, numWaves)) color = vec3(0.8, 0.5, 0.6);
                else if(p.y > wavePos(5., p, numWaves)) color = vec3(0.9, 0.6, 0.5);
            } else {
                alpha = 0.;
            }

            gl_FragColor = vec4(color, alpha);
        }
            `
        });

        const bgMesh = new THREE.Mesh(bgPlane, bgMaterial);

        scene.add(bgMesh);

        const bushMaterial = new THREE.ShaderMaterial({
            uniforms,
            blending: THREE.NormalBlending,
            depthTest: false,
            transparent: true,
            vertexShader: `
              varying vec2 vUv;
              void main () {
                vUv = uv;
                gl_Position = projectionMatrix * modelViewMatrix * vec4(position.xyz, 1.0);
              }
                `,
            fragmentShader: `
        #ifdef GL_ES
        precision mediump float;
        #endif

        #define PI 3.14159265359

        uniform float width;
        uniform float height;
        uniform float time;
        uniform float rotation;
        uniform float numLeafs;
        uniform float leafSizePercent;
        uniform vec3 color;
        uniform vec3 centerColor;

        varying vec2 vUv;

        ${perlin()}

        void main() {
            vec2 p = vUv;
            p.y = 1. - p.y;
            vec2 center = vec2(.5, .5);

            float leafExtrusion = leafSizePercent;
            float leafRLength = (PI * 2.) / numLeafs;

            vec4 result = vec4(1.,1.,1.,0.);

            float angle = atan(center.x - p.x, center.y - p.y ) + rotation;
            float leaf = floor(angle / leafRLength);
            float leafR = leaf * leafRLength;

            float leafStartAngle = leafR - leafRLength * .5;
            float noiseScale = ((cos((angle - leafStartAngle) / leafRLength * PI * 2.) + 1.) / 2.) * leafExtrusion;

            float leafYNoise = ((snoise(vec3(cos(leafR), sin(leafR), time * .25)) + 1.) / 2.);

            float leafEnd = .25 + (leafYNoise * .5 + .5) * noiseScale;
            float distanceFromCenter = distance(p, center);

            vec3 mixedColor = mix(centerColor, color, distanceFromCenter * 4.);
            if(distanceFromCenter < leafEnd) result = vec4(mixedColor / 255., 1.);

            gl_FragColor = result;
        }
              `
        });
        const bush = (props) => {
            let {
                x,
                y,
                z,
                numLeafs,
                rotation,
                leafSizePercent,
                size,
                color,
                centerColor
            } = {
                ...{
                    x: 0,
                    y: 0,
                    z: 5,
                    numLeafs: 6,
                    rotation: 0,
                    leafSizePercent: 0.25,
                    size: 1.5,
                    color: {
                        x: 37,
                        y: 40,
                        z: 91
                    }
                },
                ...props
            };

            if (!centerColor) centerColor = color;
            const material = bushMaterial.clone();

            material.uniforms.time = uniforms.time;
            material.uniforms.width = uniforms.width;
            material.uniforms.height = uniforms.height;
            material.uniforms.numLeafs = new THREE.Uniform(numLeafs);
            material.uniforms.rotation = new THREE.Uniform(rotation + Math.PI / numLeafs);
            material.uniforms.leafSizePercent = new THREE.Uniform(leafSizePercent);
            material.uniforms.color = new THREE.Uniform(
                new THREE.Vector3(color.x, color.y, color.z)
            );
            material.uniforms.centerColor = new THREE.Uniform(
                new THREE.Vector3(centerColor.x, centerColor.y, centerColor.z)
            );

            const plane = new THREE.PlaneGeometry(size, size);
            const mesh = new THREE.Mesh(plane, material);
            mesh.position.x = x;
            mesh.position.y = -y;
            mesh.position.z = z;

            scene.add(mesh);
        };

        const darkBlueBush = (darkness = 0) => {
            let baseDarkness = 1 - darkness;
            let darkerDarkness = 0.9 - darkness;
            return {
                color: {
                    x: 37 * baseDarkness,
                    y: 40 * baseDarkness,
                    z: 91 * baseDarkness
                },
                centerColor: {
                    x: 31 * darkerDarkness,
                    y: 33 * darkerDarkness,
                    z: 76 * darkerDarkness
                }
            };
        };

        const lightBlueBush = {
            color: {
                x: 94,
                y: 48,
                z: 134
            },
            centerColor: {
                x: 65,
                y: 40,
                z: 126
            }
        };

        const lightBlueAltBush = {
            color: {
                x: 37 * 1.1,
                y: 40 * 1.1,
                z: 91 * 1.1
            },
            centerColor: {
                x: 31,
                y: 33,
                z: 76
            }
        };

        const darkerBlueBush = {
            color: {
                x: 37 * 0.75,
                y: 40 * 0.75,
                z: 91 * 0.75
            },
            centerColor: {
                x: 37 * 0.7,
                y: 40 * 0.7,
                z: 91 * 0.7
            }
        };

        const bushes = [{
                ...lightBlueAltBush,
                size: 1.8,
                x: 0,
                y: 1.7,
                z: 6.6,
                numLeafs: 5
            }, // font and center

            {
                ...darkBlueBush(0.05),
                size: 3,
                x: 1.4,
                y: 2.2,
                z: 6,
                numLeafs: 9,
                mirrorX: true
            },

            {
                ...lightBlueBush,
                size: 4,
                x: 2.2,
                y: 2.4,
                z: 4,
                numLeafs: 11,
                mirrorX: true
            },

            {
                ...darkerBlueBush,
                size: 9,
                x: 7.3,
                y: 1,
                z: 1,
                numLeafs: 11,
                mirrorX: true
            },

            {
                ...darkBlueBush(),
                size: 7,
                x: 6.2,
                y: 1.7,
                z: 2,
                numLeafs: 9,
                mirrorX: true
            },

            {
                ...darkBlueBush(-0.3),
                size: 4,
                x: 5,
                y: 1.85,
                z: 3,
                numLeafs: 5,
                mirrorX: true,
                rotation: Math.PI * 0.3
            },

            {
                ...darkerBlueBush,
                size: 2.5,
                x: 1,
                y: 2.3,
                z: 6.4,
                numLeafs: 9,
                mirrorX: false
            },
            {
                ...lightBlueAltBush,
                size: 3.5,
                x: -0.8,
                y: 3.2,
                z: 5,
                numLeafs: 9,
                mirrorX: false
            },

            {
                ...darkBlueBush(0.4),
                size: 2,
                x: -2.4,
                y: 2.2,
                z: 6.3,
                numLeafs: 9,
                mirrorX: false
            },

            {
                ...lightBlueAltBush,
                size: 2,
                x: -1,
                y: 3,
                z: 7.5,
                numLeafs: 9,
                mirrorX: false
            },
            {
                ...darkBlueBush(0.1),
                size: 1.5,
                x: 0.8,
                y: 2.5,
                z: 8,
                numLeafs: 9,
                mirrorX: false
            },
            {
                ...darkBlueBush(0.2),
                size: 2,
                x: -0.7,
                y: 2.8,
                z: 6.5,
                numLeafs: 9,
                mirrorX: false
            },

            {
                ...darkBlueBush(0.4),
                size: 2.5,
                x: -0.2,
                y: 2.8,
                z: 6.4,
                numLeafs: 9,
                mirrorX: false
            },

            {
                ...darkBlueBush(0.2),
                size: 4,
                x: 4,
                y: 3.1,
                z: 4.4,
                numLeafs: 9,
                mirrorX: true
            },
            {
                ...darkBlueBush(0.4),
                size: 4,
                x: 1.5,
                y: 3.6,
                z: 4.3,
                numLeafs: 9,
                mirrorX: true
            },
            {
                ...darkBlueBush(0.1),
                size: 3,
                x: 2.5,
                y: 3.9,
                z: 4.3,
                numLeafs: 7,
                mirrorX: true
            },
            {
                ...darkBlueBush(0.2),
                size: 3,
                x: 1.2,
                y: 3.5,
                z: 4.3,
                numLeafs: 7,
                mirrorX: false
            }
        ];

        for (let i = 0; i < bushes.length; i++) {
            let b = bushes[i];
            b.rotation = b.rotation || i * 13.14156;
            let doubledBush = {
                ...b,
                rotation: b.rotation + Math.PI
            };

            bush(b);
            if (bushes[i].mirrorX) bush({
                ...b,
                x: b.x * -1,
                rotation: b.rotation * -1
            });

            if (b.double !== false) {
                bush(doubledBush);
                if (bushes[i].mirrorX)
                    bush({
                        ...doubledBush,
                        x: doubledBush.x * -1,
                        rotation: doubledBush.rotation * -1
                    });
            }
        }

        window.addEventListener("resize", resize);

        function resize() {
            width = window.innerWidth * sampleScale;
            height = window.innerHeight * sampleScale;
            renderer.setSize(width, height);
            uniforms.width.value = width;
            uniforms.height.value = height;
            camera.aspect = width / height;
            camera.updateProjectionMatrix();
        }

        resize();

        function update() {
            renderer.render(scene, camera);
            smoothScrollY = window.scrollY;

            camera.position.y = -smoothScrollY * 0.006;

            bgMesh.position.y = camera.position.y;

            let now = new Date().getTime();
            let currentTime = now - startTime;
            uniforms.time.value = currentTime / 1000;
            uniforms.scrollY.value = smoothScrollY * sampleScale;

            window.requestAnimationFrame(update);
        }

        update();
    </script>

    <!-- Tulisan Oprec & Tema -->
    <script>
        const texts = ["WGG 2024", "Let There Be Light"];
        const typingContainer = document.getElementById("typing-container");
        let currentTextIndex = 0;
        let currentText = "";
        let isDeleting = false;
        let typingSpeed = 175;

        function type() {
            const text = texts[currentTextIndex];
            if (isDeleting) {
                currentText = text.substring(0, currentText.length - 1);
            } else {
                currentText = text.substring(0, currentText.length + 1);
            }

            typingContainer.innerHTML = currentText;

            let typingDelay = isDeleting ? typingSpeed / 2 : typingSpeed;

            if (!isDeleting && currentText === text) {
                typingDelay = 2500;
                isDeleting = true;
            } else if (isDeleting && currentText === "") {
                isDeleting = false;
                currentTextIndex++;
                if (currentTextIndex === texts.length) {
                    currentTextIndex = 0;
                }
            }

            setTimeout(type, typingDelay);
        }

        document.addEventListener("DOMContentLoaded", function() {
            type();
        });
    </script>

    <!-- Section About WGG -->
    <script>
        $(window).scroll(function() {
            var scr = $(window).scrollTop(),
                C = $("#isi-mail"),
                A = $("#part1"),
                E = $("#part3"),
                F = $("#part3 hgroup h2"),
                P = $("#mail-container");

            if (scr >= 1300) {
                C.css({
                    transition: "all 1s",
                    transform: "rotateY(180deg)"
                });
                A.css({
                    transition: "all 1s .5s",
                    transform: "rotateX(180deg)",
                    "z-index": "0"
                });
            } else if (scr <= 1300) {
                C.css({
                    transition: "all 1s .5s",
                    transform: "rotateY(0deg)"
                });
                A.css({
                    transition: "all 1s",
                    transform: "rotateX(0deg)",
                    "z-index": "10"
                });
            }

            if (scr >= 1300) {
                E.css({
                    transition: "all .5s 1s",
                    top: "-200px",
                    height: "350px"
                });
                P.css({
                    transition: "all 1s",
                    transform: "translateY(350px)"
                });
                F.css({
                    transition: "all 1s",
                    transform: "rotateZ(180deg)"
                });
            } else if (scr <= 1300) {
                E.css({
                    transition: "all .5s",
                    top: "3px",
                    height: "200px"
                });
                P.css({
                    transform: "translateY(0px)"
                });
                F.css({
                    transform: "rotateZ(0deg)"
                });
            }
        });
    </script>

    <!-- Vanilla tilt -->
    <script>
        VanillaTilt.init(document.querySelectorAll(".tilt-card"), {
            max: 25,
            speed: 400,
            glare: true,
            "max-glare": 0.8,
        });
    </script>

    <!-- GSAP & Swiper buat section Our Division -->
    <script>
        gsap.registerPlugin(ScrollTrigger);

        const initSwiper = () => {
            const swiper = new Swiper('.swiper-container', {
                loop: 'true',
                slidesPerView: 'auto',
                spaceBetween: 20,
                initialSlide: 3,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                scrollbar: {
                    el: '.swiper-scrollbar',
                    draggable: true,
                },
                breakpoints: {
                    768: {
                        spaceBetween: 50,
                    },
                    1096: {
                        spaceBetween: 100,
                    },
                },
            });


            gsap.from('.swiper-slide', {
                xPercent: -100,
                ease: 'power1.inOut',
                scrollTrigger: {
                    trigger: '.swiper-container',
                    scrub: true,

                },
            });
        };

        const showDemo = () => {
            initSwiper();
        };

        showDemo();
    </script>

    <!-- Animasi GSAP -->
    <script>
        function animateFrom(elem, direction) {
            direction = direction || 1;
            var x = 0,
                y = direction * 100;
            if (elem.classList.contains("gs_reveal_fromLeft")) {
                x = -200;
                y = 0;
            } else if (elem.classList.contains("gs_reveal_fromRight")) {
                x = 200;
                y = 0;
            } else if (elem.classList.contains("gs_reveal_fromBottom")) {
                x = 0;
                y = 150;
            } else if (elem.classList.contains("gs_reveal_fromTop")) {
                x = 0;
                y = -150;
            }
            elem.style.transform = "translate(" + x + "px, " + y + "px)";
            elem.style.opacity = "0";
            gsap.fromTo(
                elem, {
                    x: x,
                    y: y,
                    autoAlpha: 0
                }, {
                    duration: 3.0,
                    x: 0,
                    y: 0,
                    autoAlpha: 1,
                    ease: "expo",
                    overwrite: "auto"
                }
            );
        }

        function hide(elem) {
            gsap.set(elem, {
                autoAlpha: 0
            });
        }

        document.addEventListener("DOMContentLoaded", function() {
            gsap.registerPlugin(ScrollTrigger);

            gsap.utils.toArray(".gs_reveal").forEach(function(elem) {
                hide(elem);

                ScrollTrigger.create({
                    trigger: elem,
                    onEnter: function() {
                        animateFrom(elem);
                    },
                    onEnterBack: function() {
                        animateFrom(elem, -1);
                    },
                    onLeave: function() {
                        hide(elem);
                    }
                });
            });
        });
    </script>

    <!-- Update animation kalau beda device -->
    <script>
        function handleResize() {
            var element = document.getElementById('judul1');
            var element2 = document.getElementById('typing-container');
            var element3 = document.getElementById('timeline-container');
            var element4 = document.getElementById('howtojoin');

            var screenWidth = window.innerWidth;

            if (screenWidth < 1024) {
                element.classList.remove('gs_reveal_fromLeft');
                element.classList.add('gs_reveal_fromBottom');
                element2.classList.remove('gs_reveal_fromRight');
                element2.classList.add('gs_reveal_fromBottom');
                element3.classList.remove('gs_reveal_fromLeft');
                element3.classList.add('gs_reveal_fromTop');
                element4.classList.remove('gs_reveal_fromRight');
                element4.classList.add('gs_reveal_fromTop');
            } else {
                element.classList.remove('gs_reveal_fromBottom');
                element.classList.add('gs_reveal_fromLeft');
                element2.classList.remove('gs_reveal_fromBottom');
                element2.classList.add('gs_reveal_fromRight');
                element3.classList.remove('gs_reveal_fromTop');
                element3.classList.add('gs_reveal_fromLeft');
                element4.classList.remove('gs_reveal_fromTop');
                element4.classList.add('gs_reveal_fromRight');
            }
        }


        handleResize();

        window.addEventListener('resize', handleResize);
    </script>

    {{-- Baymax Follow Mouse --}}
    <script>
        var follow = 0;
        function startBaymaxFollow(){
            if(follow == 0){
                setInterval(followMouse, 30);
                follow = 1;
            }else{
                return;
            }

        }
        var baymax = document.querySelector("#baymax");
        document.addEventListener("mousemove", async function(e){
            await getMouse(e);
        }); 
        document.addEventListener("touchmove", async function(e){
            await getMouse(e);
        });

        document.addEventListener('click', function(){
            changeBaymaxSrc()
        })
        
        baymax.style.position = "absolute"; //css		
        var baymaxpos = {x:0, y:0};
        
        var mouse = {x:0, y:0}; //mouse.x, mouse.y
        
        var dir = "right";
        function getMouse(e){
            mouse.x = e.pageX;
            mouse.y = e.pageY;
            //Checking directional change
            if(mouse.x > baymaxpos.x){
                dir = "right";
            } else {
                dir = "left";
            }
        }

        function followMouse(){
            //1. find distance X , distance Y
            var distX = mouse.x - baymaxpos.x;
            var distY = mouse.y - baymaxpos.y;
            //Easing motion 
            //Progressive reduction of distance 
            baymaxpos.x += distX/5;
            baymaxpos.y += distY/2;
            
            // baymax.style.left = baymaxpos.x + "px";
            // baymax.style.top = baymaxpos.y + "px";

            baymax.style.left = (mouse.x + 10) + "px";
            baymax.style.top = (mouse.y + 10) + "px";
            
            //Apply css class 
            if (dir == "right"){
                baymax.setAttribute("class", "right");
                // changeBaymaxSrc(0)
            } else {
                baymax.setAttribute("class", "left");     
                // changeBaymaxSrc(1)   
            }
            
        }

        var source = {
            0 : "{{ asset('assets/baymax.png') }}",
            1 : "{{ asset('assets/baymax-touch.png') }}",
        }
        let now = 0
        function changeBaymaxSrc(){
            if(now == 0){
                now = 1
            }else{
                now = 0
            }
            baymax.src = source[now]
        }
        startBaymaxFollow();
        </script>
</body>

</html>
