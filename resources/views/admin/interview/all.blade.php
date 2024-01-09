@extends('admin.layout')
@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <h1 class="text-center text-4xl uppercase font-bold">Division Schedule</h1>
    @if(session('role') == 'it')
        <div class="px-10 mt-5 w-full">
            <h3 class="text-center text-xl uppercase font-bold mb-3">Choose Division</h3>
            <select class="w-full" data-te-select-init id="division">
                <option value="all">All</option>
                @foreach($division as $div)
                        <option value="{{ $div['id'] }}">{{ $div['name'] }}</option>
                @endforeach
            </select>
        </div>
    @endif
</div>
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-8">
    <div class="px-8 w-full mb-3">
        <div class="relative mb-4 flex w-full flex-wrap items-stretch">
        <input
            id="advanced-search-input"
            type="search"
            class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
            placeholder="Search"
            aria-label="Search"
            aria-describedby="button-addon1" />
    
        <!--Search button-->
        <button
            class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
            type="button"
            id="advanced-search-button"
            data-te-ripple-init
            data-te-ripple-color="light">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 20 20"
            fill="currentColor"
            class="h-5 w-5">
            <path
                fill-rule="evenodd"
                d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z"
                clip-rule="evenodd" />
            </svg>
        </button>
        </div>
    </div>
    <div id="datatable" class="w-full px-5 py-5"></div>
</div>
@endSection('content')
@section('script')
    <script>
        const customDatatable = document.getElementById("datatable");
        let data = JSON.parse(@json($interview));
        // console.log(data);
        const instance = new te.Datatable(
        customDatatable,
        {
            columns: [
            { label: "Date", field: "date" },
            { label: "Time", field: "time" },
            { label: "Name", field: "name" },
            { label: "Type", field: "type" },
            { label: "Online", field: "online" },
            { label: "Division 1", field: "priorityDivision1" },
            { label: "Division 2", field: "priorityDivision2" },
            { label: "Interviewer", field: "interviewer"},
            { label: "Action", field: "action"},
            ],
            rows: data.map((item) => {
                return {
                    ...item,
                    action : `
                    <a href="" target="_blank">
                        <button
                            type="button"
                            data-te-ripple-init
                            data-te-ripple-color="light"
                            class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                            <svg class="w-4 h-4 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                            <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                            </svg>
                        </button>
                    </a>
                    `,
                    type : item.type == 0 ? "Wawancara 2 Divisi" : "Wawancara Divisi ke "+item.type,
                    online : item.online == 0 ? "Onsite" : "Online",
                }
            }),
        },
        { hover: true }
        );
        const advancedSearchInput = document.getElementById('advanced-search-input');

        const search = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instance.search(phrase, columns);
        };

        document
            .getElementById("advanced-search-button")
            .addEventListener("click", (e) => {
            search(advancedSearchInput.value);
            });

        advancedSearchInput.addEventListener("keydown", (e) => {
            if (e.keyCode === 13) {
            search(e.target.value);
            }
        });

        $(document).ready(function(){
            $("#division").on('change',async function(){
                let division = $(this).val();
                let change = await $.ajax({
                    url : "{{ route('admin.interview.division') }}",
                    method : "POST",
                    data : {
                        division : division,
                        _token : "{{ csrf_token() }}"
                    },
                    success : function(data){
                        if(data.success){
                            return data.data;
                        }else{
                            return [['No data available']];
                        }
                    }
                });
                if(change.data && change.data.length > 0){
                    // console.log(instance);
                    instance.update({
                        columns: [
                            { label: "Date", field: "date" },
                            { label: "Time", field: "time" },
                            { label: "Name", field: "name" },
                            { label: "Type", field: "type" },
                            { label: "Online", field: "online" },
                            { label: "Division 1", field: "priorityDivision1" },
                            { label: "Division 2", field: "priorityDivision2" },
                            { label: "Interviewer", field: "interviewer"},
                            { label: "Action", field: "action"},
                            ],
                            rows: change.data.map((item) => {
                                return {
                                    ...item,
                                    action : `
                                    <a href="" target="_blank">
                                        <button
                                            type="button"
                                            data-te-ripple-init
                                            data-te-ripple-color="light"
                                            class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                            <svg class="w-4 h-4 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                            <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                            <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                            </svg>
                                        </button>
                                    </a>
                                    `,
                                    type : item.type == 0 ? "Wawancara 2 Divisi" : "Wawancara Divisi ke "+item.type,
                                    online : item.online == 0 ? "Onsite" : "Online",
                                }
                            }),
                    },{
                        hover : true,
                    });
                }else{
                    instance.update({
                        columns: [
                            { label : "No data available", field : "no_data" }
                        ],
                        rows : [
                            {
                                no_data : "No data available"
                            }
                        ]
                    },{
                        hover : true,
                    });
                }
            })
        })
    </script>
@endSection('script')