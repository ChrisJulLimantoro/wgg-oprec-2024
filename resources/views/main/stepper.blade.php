<ul
    class="relative m-0 flex list-none justify-between overflow-hidden p-0 transition-[height] duration-200 ease-in-out pb-3 mb-10">

    <!--First item-->
    <li data-te-stepper-step-ref data-te-stepper-step-active class="w-[4.5rem] flex-auto">
        @php
            $numClass = '';
            $textClass = '';
            $connR = '';
            if ($applicant['stage'] == 0) {
                $numClass = '!bg-[#804db3] text-white';
                $textClass = '!text-[#804db3]';
                $connR = 'after:bg-neutral-200';
            } elseif ($applicant['stage'] > 0) {
                $numClass = '!bg-[#e59980] text-white';
                $textClass = '!text-[#e59980]';

                if ($applicant['stage'] == 1) {
                    $connR = 'after:bg-[#804db3]';
                } else {
                    $connR = 'after:bg-[#e59980]';
                }
            }
        @endphp

        <a href="{{ route('applicant.application-form') }}">
            <div data-te-stepper-head-ref
                class="flex cursor-pointer items-center pl-2 leading-[0.5rem] no-underline after:ml-2 after:h-px after:w-full after:flex-1 after:content-[''] focus:outline-none dark:after:bg-neutral-600 {{ $connR }}">
                <div class="flex flex-col items-center">


                    <span data-te-stepper-head-icon-ref
                        class="my-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm font-medium {{ $numClass }}
                        ">
                        @if ($applicant['stage'] >= 1)
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="12" height="12"
                                fill="white"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                            </svg>
                        @else
                            1
                        @endif
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="font-medium after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300 {{ $textClass }}">
                        Biodata
                    </span>
                </div>

            </div>
        </a>
    </li>

    <!--Second item-->
    <li data-te-stepper-step-ref class="w-[4.5rem] flex-auto">
        @php
            $numClass = '';
            $textClass = '';
            $connL = '';
            $connR = '';
            if ($applicant['stage'] == 1) {
                #804db3
                #e59980
                $numClass = '!bg-[#804db3] !text-white';
                $textClass = 'font-medium !text-[#804db3]';
                $connL = 'before:bg-[#804db3]';
                $connR = 'after:bg-neutral-200';
            } elseif ($applicant['stage'] > 1) {
                $numClass = '!bg-[#e59980] !text-white';
                $textClass = 'font-medium !text-[#e59980]';
                $connL = 'before:bg-[#e59980]';

                if ($applicant['stage'] == 2) {
                    $connR = 'after:bg-[#804db3]';
                } else {
                    $connR = 'after:bg-[#e59980]';
                }
            } else {
                $numClass = '!bg-neutral-200 !text-neutral-500';
                $textClass = '!text-neutral-500';
                $connL = 'before:bg-neutral-200';
                $connR = 'after:bg-neutral-200';
            }
        @endphp

        <a href="{{ route('applicant.documents-form') }}">
            <div data-te-stepper-head-ref
                class="flex cursor-pointer items-center leading-[0.5rem] no-underline before:mr-2 before:h-px before:w-full before:flex-1 before:content-[''] after:ml-2 after:h-px after:w-full after:flex-1 after:content-[''] focus:outline-none dark:before:bg-neutral-600 dark:after:bg-neutral-600 {{ $connL }} {{ $connR }}">
                <div class="flex flex-col items-center">
                    <span data-te-stepper-head-icon-ref
                        class="my-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm font-medium {{ $numClass }}">
                        @if ($applicant['stage'] >= 2)
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="12" height="12"
                                fill="white"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                            </svg>
                        @else
                            2
                        @endif
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300 {{ $textClass }}">
                        Berkas
                    </span>
                </div>
            </div>
        </a>
    </li>

    <!--Third item-->
    <li data-te-stepper-step-ref class="w-[4.5rem] flex-auto">
        @php
            $numClass = '';
            $textClass = '';
            $connL = '';
            $connR = '';
            if ($applicant['stage'] == 2) {
                $numClass = '!bg-[#804db3] !text-white';
                $textClass = 'font-medium !text-[#804db3]';
                $connL = 'before:bg-[#804db3]';
                $connR = 'after:bg-neutral-200';
            } elseif ($applicant['stage'] > 2) {
                $numClass = '!bg-[#e59980] !text-white';
                $textClass = 'font-medium !text-[#e59980]';
                $connL = 'before:bg-[#e59980]';

                if ($applicant['stage'] == 3) {
                    $connR = 'after:bg-[#804db3]';
                } else {
                    $connR = 'after:bg-[#e59980]';
                }
            } else {
                $numClass = '!bg-neutral-200 !text-neutral-500';
                $textClass = '!text-neutral-500';
                $connL = 'before:bg-neutral-200';
                $connR = 'after:bg-neutral-200';
            }
        @endphp

        <a href="{{ route('applicant.schedule-form') }}">
            <div data-te-stepper-head-ref
                class="flex cursor-pointer items-center leading-[0.5rem] no-underline before:mr-2 before:h-px before:w-full before:flex-1 before:content-[''] after:ml-2 after:h-px after:w-full after:flex-1 after:content-[''] focus:outline-none dark:before:bg-neutral-600 dark:after:bg-neutral-600 {{ $connL }} {{ $connR }}">
                <div class="flex flex-col items-center">
                    <span data-te-stepper-head-icon-ref
                        class="my-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full text-sm font-medium
                        {{ $numClass }}">
                        @if ($applicant['stage'] >= 3)
                            <svg xmlns="http://www.w3.org/2000/svg"
                                width="12" height="12"
                                fill="white"
                                viewBox="0 0 448 512"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                <path
                                    d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z" />
                            </svg>
                        @else
                            3
                        @endif
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300 {{ $textClass }}">
                        Jadwal
                    </span>
                </div>
            </div>
        </a>
    </li>

    <!--Fourth item-->
    <li data-te-stepper-step-ref class="w-[4.5rem] flex-auto">
        @php
            $numClass = '';
            $textClass = '';
            $connL = '';
            if ($applicant['stage'] >= 3) {
                $numClass = '!bg-[#804db3] !text-white';
                $textClass = 'font-medium !text-[#804db3]';
                $connL = 'before:bg-[#804db3]';
            } else {
                $numClass = '!bg-neutral-200 !text-neutral-500';
                $textClass = '!text-neutral-500';
                $connL = 'before:bg-neutral-200';
            }
        @endphp

        <a href="{{ route('applicant.projects-form') }}">
            <div data-te-stepper-head-ref
                class="flex cursor-pointer items-center pr-2 leading-[0.5rem] no-underline before:mr-2 before:h-px before:w-full before:flex-1 before:content-[''] focus:outline-none dark:before:bg-neutral-600 dark:after:bg-neutral-600 {{ $connL }}">
                <div class="flex flex-col items-center">
                    <span data-te-stepper-head-icon-ref
                        class="my-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full bg-[#ebedef] text-sm font-medium text-[#40464f] {{ $numClass }}">
                        4
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="text-neutral-500 after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300 {{ $textClass }}">
                        Project
                    </span>
                </div>
            </div>
        </a>
    </li>
</ul>
