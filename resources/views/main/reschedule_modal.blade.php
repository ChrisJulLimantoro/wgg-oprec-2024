<!--Vertically centered modal-->
<div data-te-modal-init
class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
id="modalCP{{ $i }}" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true"
role="dialog">

<div data-te-modal-dialog-ref
    class="m-5 pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">

    <div
        class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
        <div
            class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50">

            <!--Modal title-->
            <h5 class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200"
                id="exampleModalCenterTitle">
                Contact Person
            </h5>
            <!--Close button-->
            <button type="button"
                class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none"
                data-te-modal-dismiss aria-label="Close">
                <svg xmlns="http://www.w3.org/2000/svg" fill="black" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="black" class="h-6 w-6" style="stroke:black !important">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!--Modal body-->
        <div class="relative p-4">
            <label class="p-1">ID Line</label>
            <div class="relative mb-4 flex flex-wrap items-stretch">
                <input type="text" id="CP{{ $i }}"
                    class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                    value="{{ $schedules[$i]['admin']['line'] }}" disabled />

                <button
                    class="z-[2] inline-block rounded-r bg-primary px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:z-[3] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]"
                    data-te-ripple-init data-te-clipboard-init data-te-clipboard-target="#CP{{ $i }}"
                    type="button" id="button-addon{{ $i }}">
                    COPY
                </button>
            </div>

            @if ($applicant['reschedule'][$i] == 0)
                <!-- Reschedule button -->
                <input type="hidden" name="schedule_id" id="schedule_id" value="{{ $schedules[$i]['id'] }}"
                    form="reschedule-form{{ $i }}">
                <button id="btn-reschedule{{ $i }}" form="reschedule-form{{ $i }}"
                    type="submit"
                    class="btn-reschedule inline-block w-full rounded bg-danger px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-white transition duration-150 ease-in-out hover:bg-danger-600 focus:bg-danger-600 focus:outline-none focus:ring-0 active:bg-danger-700">
                    Ganti Jadwal
                </button>
                @endif
        </div>

    </div>
</div>

</div>