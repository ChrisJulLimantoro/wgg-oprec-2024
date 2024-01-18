@extends('main.layout2')

@section('styles')
    <title>OPEN RECRUITMENT | WGG 2024</title>
@endsection

@section('content')
    <h1 class="font-dillan text-[10vw] font-bold xl:mt-[-200px] xl:text-[5vw] text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] tracking-wider gs_reveal"
        id="judul1">
        WGG 2024
    </h1>
    <h1 class="font-dillan text-[10vw] font-bold xl:text-[5vw] text-white drop-shadow-[0_1.2px_1.2px_rgba(0,0,0,0.8)] tracking-wider gs_reveal"
        id="judul2">
        COMING SOON</h1>
@endsection

@section('script')
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
                x = 100;
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
            var element2 = document.getElementById('judul2');

            var screenWidth = window.innerWidth;

            if (screenWidth < 1024) {
                element.classList.remove('gs_reveal_fromLeft');
                element.classList.add('gs_reveal_fromBottom');
                element2.classList.remove('gs_reveal_fromRight');
                element2.classList.add('gs_reveal_fromBottom');
            } else {
                element.classList.remove('gs_reveal_fromBottom');
                element.classList.add('gs_reveal_fromLeft');
                element2.classList.remove('gs_reveal_fromBottom');
                element2.classList.add('gs_reveal_fromRight');
            }
        }


        handleResize();

        window.addEventListener('resize', handleResize);
    </script>
@endsection
