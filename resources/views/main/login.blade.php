@extends('main.layout2')
@section('styles')
    <title>Pendaftar | {{ $title }}</title>

    <style>
        .button {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 9px 12px;
            gap: 8px;
            height: 40px;
            width: 100%;
            border: none;
            background: #755eb0;
            border-radius: 20px;
            cursor: pointer;
            transition: all 0.3s ease-in-out;
            z-index: 300;
        }

        .svg-icon {
            fill: white;
        }

        .lable {
            line-height: 22px;
            color: #fff;
            font-weight: bold;
            letter-spacing: 1px;
        }

        .button:hover {
            background: #fff;
            color: #755eb0;
            border: 1px solid #755eb0;
        }

        .button:hover .lable {
            /* background: #fff; */
            color: #755eb0;
        }

        .button:hover .svg-icon {
            animation: slope 1s linear infinite;
            fill: #755eb0;
        }

        #loginForm {
            backdrop-filter: blur(50px);
            background: rgba(255, 255, 255, 0.1);
        }
    </style>
@endsection
@section('content')
    {{-- <div id="cursor"></div>
    <div id="cursor_2"></div> --}}
    <div class="m-auto w-full h-full xl:w-1/2 xl:h-1/2 p-10 bg-white rounded-xl shadow-2xl" id="loginForm" data-aos="zoom-in">
        <div class="w-full" data-aos="zoom-in" data-aos-delay="200">
            <div class="align-items-center justify-center font-dillan">
                <h1 class="font-dillan text-[6vw] font-bold xl:text-[4vw] text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]"
                    id="judul1">
                    OPEN RECRUITMENT
                </h1>
                <h1 class="font-dillan text-[8vw] font-bold xl:text-[5vw] text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)]"
                    id="judul2">
                    WGG 2024</h1>
            </div>
        </div>
        <div class="w-full mt-8">
            {{-- <a href= '{{ $link }}'> --}}
                <button onclick="startGoogleSignIn()" class="button font-asap" id="login">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" class="svg-icon"
                        viewBox="0 0 16 16">
                        <path
                            d="M15.545 6.558a9.42 9.42 0 0 1 .139 1.626c0 2.434-.87 4.492-2.384 5.885h.002C11.978 15.292 10.158 16 8 16A8 8 0 1 1 8 0a7.689 7.689 0 0 1 5.352 2.082l-2.284 2.284A4.347 4.347 0 0 0 8 3.166c-2.087 0-3.86 1.408-4.492 3.304a4.792 4.792 0 0 0 0 3.063h.003c.635 1.893 2.405 3.301 4.492 3.301 1.078 0 2.004-.276 2.722-.764h-.003a3.702 3.702 0 0 0 1.599-2.431H8v-3.08h7.545z">
                        </path>
                    </svg>
                    <span class="lable text-sm xl:text-lg">Login With Google</span>
                </button>
            {{-- </a> --}}
        </div>
        <script src="https://accounts.google.com/gsi/client" async defer></script>
        {{-- <div id="g_id_onload"
            data-client_id="{{ env('GOOGLE_CLIENT_ID') }}"
            data-context="signin"
            data-ux_mode="redirect"
            data-login_uri="{{ route('processLogin') }}"
            data-auto_prompt="false">
        </div>

        <div class="g_id_signin"
            data-type="standard"
            data-shape="rectangular"
            data-theme="outline"
            data-text="signin_with"
            data-size="large"
            data-logo_alignment="left"
        >
        </div> --}}
        <!-- Add this to your HTML body -->
        <div id="g_id_onload" data-client_id="{{ env('GOOGLE_CLIENT_ID') }}" data-context="signin" data-auto_prompt="false"></div>
        <div class="g_id_signin" data-type="standard" data-shape="rectangular" data-theme="outline" data-text="signin_with" data-size="large" data-logo_alignment="left"></div>

    </div>
@endsection

@section('script')
    <script>
        AOS.init();
        $(document).ready(function() {
            @if (Session::has('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oopss...',
                    text: '{{ Session::get('error') }}',
                    showConfirmButton: false,
                    timer: 2500
                });
            @endif
            $('#login').click(function() {
                $('.g_id_signin').click();
            });
        });
    </script>
    <!-- Add this to your HTML body or in a separate script -->
<script>
    // Load the Google Sign-In API
    google.accounts.id.initialize({
    client_id: 'YOUR_CLIENT_ID', // Replace with your client ID
    callback: handleCredentialResponse, // Your callback function
    cancel_on_tap_outside: false,
    });

    // Callback function to handle the response
    function handleCredentialResponse(response) {
    if (response.credential) {
        // Successfully obtained user credentials
        console.log('Credential:', response.credential);

        // You can now send the credential to your server for verification
        // Example: sendCredentialToServer(response.credential);
    } else {
        // Handle the case where the user canceled the sign-in
        console.log('Sign-in canceled');
    }
    }

    // Function to initiate Google Sign-In
    function startGoogleSignIn() {
    var signinOptions = {
        prompt_parent_id: 'g_id_onload', // ID of the container where the button will be rendered
        bubbleId: 'g_id_signin', // ID of the button container
    };

    google.accounts.id.prompt(signinOptions);
    }
</script>
    </html>
@endsection
