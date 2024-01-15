<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- CDN for tailwind --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    {{-- CDN for JQUERY --}}
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>

    {{-- CDN for Tailwind Element --}}
    <link
      href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
      rel="stylesheet" />
    <link
      rel="stylesheet"
      href="https://cdn.jsdelivr.net/npm/tw-elements/dist/css/tw-elements.min.css" />
    <script src="https://cdn.tailwindcss.com/3.3.0"></script>
    <script>
      tailwind.config = {
        darkMode: "class",
        theme: {
          fontFamily: {
            sans: ["Roboto", "sans-serif"],
            body: ["Roboto", "sans-serif"],
            mono: ["ui-monospace", "monospace"],
          },
        },
        corePlugins: {
          preflight: false,
        },
      };
    </script>

    {{-- CDN for SweetAlert --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    {{-- CDN for AOS --}}
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

    <title>Admin | {{$title}}</title>
    <style>
        body{
            height:100vh;
            width:100vw;
            overflow : hidden;
            /* background : rgb(1,145,180); */
        }
        html{
            height:100vh;
            width:100vw;
        }

        /* #cursor{
            position: absolute;
            background: rgb(238,174,202);
            background: radial-gradient(circle, #D3DD18 0%, rgba(148,187,233,0) 40%);
            top:15vh;
            left:23vw;
            width:120vw;
            height:120vh;
            transform: translateX(-50%) translateY(-50%);
            transition: all 200ms ease-out;
            z-index:-2;
        }

        #cursor_2{
            position: absolute;
            background: rgb(238,174,202);
            background: radial-gradient(circle, #D3DD18 0%, rgba(148,187,233,0) 40%);
            top:85vh;
            left:77vw;
            width:150vw;
            height:150vh;
            transform: translateX(-50%) translateY(-50%);
            transition: all 200ms ease-out;
            z-index:-2;
        } */
        .button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 9px 12px;
            gap: 8px;
            height: 40px;
            width: 100%;
            border: none;
            background: #FF342B;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            }
            .svg-icon{
                fill:white;
            }
            .lable {
                line-height: 22px;
                font-size: 17px;
                color: #fff;
                font-weight:bold;
                font-family: sans-serif;
                letter-spacing: 1px;
            }

            .button:hover {
                background: #fff;
                color:#FF342B;
                border: 1px solid #FF342B;
            }

            .button:hover .lable{
                /* background: #fff; */
                color:#FF342B;
            }
            .button:hover  .svg-icon {
                animation: slope 1s linear infinite;
                fill:#FF342B;
            }
            .svg-icon:hover{
                fill:#FF342B;
            }
        
            @keyframes slope {
                0% {
                }

                50% {
                    transform: rotate(25deg);
                }

                100% {
                }
            }
            #text-logo {
                font-family: 'Shrikhand', cursive;
                stroke-dashoffset: 100%;
                stroke-dasharray: 100%;
                -webkit-animation: draw 6s forwards ease-in,up 2s 6s forwards ease-in;
                animation: draw 6s forwards ease-in,up 2s 6s forwards ease-in;
                background-clip: text;
            }
            #text-logo2 {
                font-family: 'Shrikhand', cursive;
                stroke-dashoffset: 100%;
                stroke-dasharray: 100%;
                -webkit-animation: draw 6s forwards ease-in,up 2s 6s forwards ease-in;
                animation: draw 6s forwards ease-in,up 2s 6s forwards ease-in;
                background-clip: text;
            }
                    
            @-webkit-keyframes draw {
                100% {
                    stroke-dashoffset: 0%;
                    fill: #000000;
                }
            }
                    
            @keyframes draw {
                100% {
                    stroke-dashoffset: 0%;
                    fill: #000000;
                }
            }
                    
            @-webkit-keyframes up{
                100%{
                    translate: translateY(-20vh);
                }
            }
            @keyframes up{
                100%{
                    translate: translateY(-20vh);
                }
            }
            #loginForm{
                backdrop-filter: blur(50px);
                background:rgba(255,255,255,0.1);
            }
    </style>
    <link
  href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900&display=swap"
  rel="stylesheet" />
  </head>
  <body>
    {{-- <div id="cursor"></div>
    <div id="cursor_2"></div> --}}
    <div class="w-screen h-screen flex justify-center items-center">
        <div class="m-auto w-1/2 h-1/2 p-10 bg-white rounded-xl shadow-2xl" id="loginForm" data-aos="zoom-in">
            <div class="w-full" data-aos="zoom-in" data-aos-delay="200">
                <div class="draw_text align-items-center justify-content-center">
                    <svg class="align-items-center w-full h-full mb-16 pt-10">
                        <text
                            x="3%"
                            y="40%"
                            fill="transparent"
                            stroke="#000"
                            id="text-logo"
                            strokeWidth="2"
                            style="font-size:4vw;"
                        >
                            OPEN RECRUITMENT
                        </text>
                        <text
                        x="21%"
                        y="97%"
                        fill="transparent"
                        stroke="#000"
                        id="text-logo2"
                        strokeWidth="3"
                        style="font-size:5vw;"
                        >
                            WGG 2024
                        </text>
                    </svg>
                </div>
            </div>
            <div class="w-full">
                <a href= '{{ $link }}' data-aos="zoom-in" data-aos-delay="1000">
                    <button class="button">
                        <svg
                            xmlns="http://www.w3.org/2000/svg"
                            width="16"
                            height="16"
                            class="svg-icon"
                            viewBox="0 0 16 16"
                        >
                            <path d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z"></path>
                        </svg>
                        <span class="lable">Login With Google</span>
                    </button>
                </a>
            </div>
        </div>
    </div>
  </body>
  <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
  <script>
    AOS.init();
    // var cursor = document.getElementById("cursor");
    // var cursor2 = document.getElementById("cursor_2")
    // document.body.addEventListener("mousemove", function(e) {
    //     cursor.style.left = e.clientX + "px",
    //     cursor.style.top = e.clientY + "px";
    //     cursor2.style.left = Math.abs(document.body.clientWidth - e.clientX) + "px";
    //     cursor2.style.top = Math.abs(document.body.clientHeight - e.clientY) + "px";
    // });
    $(document).ready(function(){
        @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oopss...',
                    text: '{{ Session::get('error') }}',
                    showConfirmButton: false,
                    timer: 2500
                });
        @endif
    });
    </script>
</html>