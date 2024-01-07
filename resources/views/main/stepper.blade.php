<ul 
    class="relative m-0 flex list-none justify-between overflow-hidden p-0 transition-[height] duration-200 ease-in-out pb-3 mb-10">

    <!--First item-->
    <li data-te-stepper-step-ref data-te-stepper-step-active class="w-[4.5rem] flex-auto">
        @php
            $numClass = '';
            $textClass = '';
            $connR = '';
            if ($applicant['stage'] == 1) {
                $numClass = '!bg-blue-100 !text-blue-500';
                $textClass = '!text-blue-500';
                $connR = 'after:bg-neutral-200';
            } else if ($applicant['stage'] > 1){
                $numClass = '!bg-green-100 !text-green-600';
                $textClass = '!text-green-500';

                if ($applicant['stage'] == 2) {
                    $connR = 'after:bg-blue-200';
                }
                else {
                    $connR = 'after:bg-green-200';
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
                        1
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
            if ($applicant['stage'] == 2) {
                $numClass = '!bg-blue-100 !text-blue-500';
                $textClass = 'font-medium !text-blue-500';
                $connL = 'before:bg-blue-200';
                $connR = 'after:bg-neutral-200';
            } else if ($applicant['stage'] > 2) {
                $numClass = '!bg-green-100 !text-green-500';
                $textClass = 'font-medium !text-green-500';
                $connL = 'before:bg-green-200';

                if ($applicant['stage'] == 3) {
                    $connR = 'after:bg-blue-200';
                }
                else {
                    $connR = 'after:bg-green-200';
                }
            }
            else {
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
                        2
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
            if ($applicant['stage'] == 3) {
                $numClass = '!bg-blue-100 !text-blue-500';
                $textClass = 'font-medium !text-blue-500';
                $connL = 'before:bg-blue-200';
                $connR = 'after:bg-neutral-200';
            } else if ($applicant['stage'] > 3) {
                $numClass = '!bg-green-100 !text-green-500';
                $textClass = 'font-medium !text-green-500';
                $connL = 'before:bg-green-200';

                if ($applicant['stage'] == 4) {
                    $connR = 'after:bg-blue-200';
                }
                else {
                    $connR = 'after:bg-green-200';
                }
            }
            else {
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
                        3
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
            if ($applicant['stage'] == 4) {
                $numClass = '!bg-blue-100 !text-blue-500';
                $textClass = 'font-medium !text-blue-500';
                $connL = 'before:bg-blue-200';
            } 
            else {
                $numClass = '!bg-neutral-200 !text-neutral-500';
                $textClass = '!text-neutral-500';
                $connL = 'before:bg-neutral-200';
            }
        @endphp

        <a href="{{ route('applicant.interview-detail') }}">
            <div data-te-stepper-head-ref
                class="flex cursor-pointer items-center pr-2 leading-[0.5rem] no-underline before:mr-2 before:h-px before:w-full before:flex-1 before:content-[''] focus:outline-none dark:before:bg-neutral-600 dark:after:bg-neutral-600 {{ $connL }}">
                <div class="flex flex-col items-center">
                    <span data-te-stepper-head-icon-ref
                        class="my-3 flex h-[1.938rem] w-[1.938rem] items-center justify-center rounded-full bg-[#ebedef] text-sm font-medium text-[#40464f] {{ $numClass }}">
                        4
                    </span>
                    <span data-te-stepper-head-text-ref
                        class="text-neutral-500 after:flex after:text-[0.8rem] after:content-[data-content] dark:text-neutral-300 {{ $textClass }}">
                        Interview
                    </span>
                </div>
            </div>
        </a>
    </li>
</ul>
