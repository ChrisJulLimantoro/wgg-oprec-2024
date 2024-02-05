@extends('admin.layout')

@section('content')
<div class="flex flex-col w-full py-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <h1 class="text-center text-4xl uppercase font-bold">Accepted</h1>
</div>
<div class="flex flex-col w-full pb-8 rounded-lg shadow-xl items-center justify-center mb-10">
    <!--Tabs navigation-->
    <ul
    class="mb-5 flex list-none flex-row flex-wrap border-b-0 pl-0 w-full"
    role="tablist"
    data-te-nav-ref>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#acara"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#acara"
                data-te-nav-active
                role="tab"
                aria-controls="acara"
                aria-selected="true"
                >Acara</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#perkap"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#perkap"
                role="tab"
                aria-controls="perkap"
                aria-selected="false"
                >Perlengkapan</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#regul"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#regul"
                role="tab"
                aria-controls="regul"
                aria-selected="false"
                >Keamanan</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#creative"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#creative"
                role="tab"
                aria-controls="creative"
                aria-selected="false"
                >Creative</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#sekret"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#sekret"
                role="tab"
                aria-controls="sekret"
                aria-selected="false"
                >Sekretariat</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#it"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#it"
                role="tab"
                aria-controls="it"
                aria-selected="false"
                >IT</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#sehat"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#sehat"
                role="tab"
                aria-controls="sehat"
                aria-selected="false"
                >Kesehatan</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#konsum"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#konsum"
                role="tab"
                aria-controls="konsum"
                aria-selected="false"
                >Konsumsi</a
            >
        </li>
        <li role="presentation" class="flex-auto text-center">
            <a
                href="#peran"
                class="my-2 block border-x-0 border-b-2 border-t-0 border-transparent px-7 pb-3.5 pt-4 text-xs font-medium uppercase leading-tight text-neutral-500 hover:isolate hover:border-transparent hover:bg-neutral-100 focus:isolate focus:border-transparent data-[te-nav-active]:border-primary data-[te-nav-active]:text-primary dark:text-neutral-400 dark:hover:bg-transparent dark:data-[te-nav-active]:border-primary-400 dark:data-[te-nav-active]:text-primary-400"
                data-te-toggle="pill"
                data-te-target="#peran"
                role="tab"
                aria-controls="peran"
                aria-selected="false"
                >Peran</a
            >
        </li>
    </ul>

    <!--Tabs content-->
    <div class="mb-2 w-full px-8">
        <div
        class="hidden opacity-100 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="acara"
        role="tabpanel"
        aria-labelledby="tabs-acara"
        data-te-tab-active>
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Acara</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-acara"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in acara"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-acara-button"
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
            <div id="datatable-acara" class="w-full py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="perkap"
        role="tabpanel"
        aria-labelledby="tabs-perkap">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Perlengkapan</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-perkap"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in perlengkapan"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-perkap-button"
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
            <div id="datatable-perkap" class="w-full  py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="regul"
        role="tabpanel"
        aria-labelledby="tabs-regul">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Keamanan</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-regul"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in regulasi"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-regul-button"
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
            <div id="datatable-regul" class="w-full py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="creative"
        role="tabpanel"
        aria-labelledby="tabs-creative">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Creative</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-creative"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in Creative"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-creative-button"
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
            <div id="datatable-creative" class="w-full py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="sekret"
        role="tabpanel"
        aria-labelledby="tabs-sekret">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Sekretariat</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-sekret"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in Sekretariat"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-sekret-button"
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
            <div id="datatable-sekret" class="w-full py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="it"
        role="tabpanel"
        aria-labelledby="tabs-it">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Information Technology</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-it"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in Information Technology"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-it-button"
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
            <div id="datatable-it" class="w-full py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="sehat"
        role="tabpanel"
        aria-labelledby="tabs-sehat">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Kesehatan</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-sehat"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in Kesehatan"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-sehat-button"
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
            <div id="datatable-sehat" class="w-full py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="konsum"
        role="tabpanel"
        aria-labelledby="tabs-konsum">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Konsumsi</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-konsum"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in Konsumsi"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-konsum-button"
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
            <div id="datatable-konsum" class="w-full py-5 rounded-xl"></div>
        </div>
        <div
        class="hidden opacity-0 transition-opacity duration-150 ease-linear data-[te-tab-active]:block"
        id="peran"
        role="tabpanel"
        aria-labelledby="tabs-peran">
            <h1 class="text-xl font-bold uppercase mb-1">Divisi Peran</h1>
            <hr class="h-[2px] bg-slate-200 dark:bg-gray-600 mb-8 border-none" />
            <div class="px-8 w-full mb-1">
                <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                    <input
                        id="search-peran"
                        type="search"
                        class="relative m-0 -mr-0.5 block w-[1px] min-w-0 flex-auto rounded-l border border-solid border-neutral-300 bg-transparent bg-clip-padding px-3 py-[0.25rem] text-base font-normal leading-[1.6] text-neutral-700 outline-none transition duration-200 ease-in-out focus:z-[3] focus:border-primary focus:text-neutral-700 focus:shadow-[inset_0_0_0_1px_rgb(59,113,202)] focus:outline-none dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200 dark:focus:border-primary"
                        placeholder="Search in Peran"
                        aria-label="Search"
                        aria-describedby="button-addon1" />
                        
                        <!--Search button-->
                    <button
                        class="relative z-[2] flex items-center rounded-r bg-primary px-6 py-2.5 text-xs font-medium uppercase leading-tight text-white shadow-md transition duration-150 ease-in-out hover:bg-primary-700 hover:shadow-lg focus:bg-primary-700 focus:shadow-lg focus:outline-none focus:ring-0 active:bg-primary-800 active:shadow-lg"
                        type="button"
                        id="search-peran-button"
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
            <div id="datatable-peran" class="w-full py-5 rounded-xl"></div>
        </div>
    </div>
</div>
@endsection()

@section('script')
    <script>
        const data = JSON.parse(@json($accepted));
        
        // Datatable document
        const acara = document.getElementById("datatable-acara");
        const perkap = document.getElementById("datatable-perkap");
        const regul = document.getElementById("datatable-regul");
        const creative = document.getElementById("datatable-creative");
        const sekret = document.getElementById("datatable-sekret");
        const it = document.getElementById("datatable-it");
        const sehat = document.getElementById("datatable-sehat");
        const konsum = document.getElementById("datatable-konsum");
        const peran = document.getElementById("datatable-peran");

        // Inisialisasi Datatable
        // Divisi Acara
        const instanceAcara = new te.Datatable(
            acara,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.acara.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi Perlengkapan
        const instancePerkap = new te.Datatable(
            perkap,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.perkap.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi Regulasi
        const instanceRegul = new te.Datatable(
            regul,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.regul.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi Creative
        const instanceCreative = new te.Datatable(
            creative,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.creative.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi Sekretariat
        const instanceSekret = new te.Datatable(
            sekret,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.sekret.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi IT
        const instanceIT = new te.Datatable(
            it,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.it.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi Kesehatan
        const instanceKes = new te.Datatable(
            sehat,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.kesehatan.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi konsum
        const instanceKonsum = new te.Datatable(
            konsum,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.konsum.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Divisi Peran
        const instancePeran = new te.Datatable(
            peran,
            {
                columns: [
                    { label: "NRP", field: "nrp", fixed : true, sort: true },
                    { label: "Name", field: "name", fixed : true, sort: true },
                    { label: "Major", field: "major", sort : false},
                    { label: "gpa", field: "gpa", sort : true },
                    { label: "Address", field: "address", sort: false},
                    { label: "Type", field: "type", sort: false},
                    { label: "Action", field: "action"},
                ],
                rows: data.peran.map((item) => {
                    return {
                        ...item,
                        action : `
                        <a href="${item.link}" target="_blank">
                            <button
                                type="button"
                                data-te-ripple-init
                                data-te-ripple-color="light"
                                class="message-btn inline-block rounded-full border border-primary bg-primary text-white p-1.5 uppercase leading-normal shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                                <svg class="w-3.5 h-3.5 fill-[#ffffff]" viewBox="0 0 192 512" xmlns="http://www.w3.org/2000/svg">

                                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                                <path d="M48 80a48 48 0 1 1 96 0A48 48 0 1 1 48 80zM0 224c0-17.7 14.3-32 32-32H96c17.7 0 32 14.3 32 32V448h32c17.7 0 32 14.3 32 32s-14.3 32-32 32H32c-17.7 0-32-14.3-32-32s14.3-32 32-32H64V256H32c-17.7 0-32-14.3-32-32z"></path>

                                </svg>
                            </button>
                        </a>
                        `,
                        type : item.type == 2 ? "Choice 1" : item.type == 4 ? "Choice 2" : "Kidnapped",
                    }
                }),
            },
            { hover: true, stripped : true }
        );

        // Search Function
        // Acara
        const inputAcara = document.getElementById('search-acara');

        const searchAcara = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instanceAcara.search(phrase, columns);
        };

        document
            .getElementById("search-acara-button")
            .addEventListener("click", (e) => {
            searchAcara(inputAcara.value);
            });

        inputAcara.addEventListener("keydown", (e) => {
            searchAcara(e.target.value);
        });

        // Perlengkapan
        const inputPerkap = document.getElementById('search-perkap');

        const searchPerkap = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instancePerkap.search(phrase, columns);
        };

        document
            .getElementById("search-perkap-button")
            .addEventListener("click", (e) => {
            searchPerkap(inputPerkap.value);
            });

        inputPerkap.addEventListener("keydown", (e) => {
            searchPerkap(e.target.value);
        });

        // Regulasi
        const inputRegul = document.getElementById('search-regul');

        const searchRegul = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instanceRegul.search(phrase, columns);
        };

        document
            .getElementById("search-regul-button")
            .addEventListener("click", (e) => {
            searchRegul(inputRegul.value);
            });

        inputRegul.addEventListener("keydown", (e) => {
            searchRegul(e.target.value);
        });

        // Creative
        const inputCreative = document.getElementById('search-creative');

        const searchCreative = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instanceCreative.search(phrase, columns);
        };

        document
            .getElementById("search-creative-button")
            .addEventListener("click", (e) => {
            searchCreative(inputCreative.value);
            });

        inputCreative.addEventListener("keydown", (e) => {
            searchCreative(e.target.value);
        });

        // Sekretariat
        const inputSekret = document.getElementById('search-sekret');

        const searchSekret = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instanceSekret.search(phrase, columns);
        };

        document
            .getElementById("search-sekret-button")
            .addEventListener("click", (e) => {
            searchSekret(inputSekret.value);
            });

        inputSekret.addEventListener("keydown", (e) => {
            searchSekret(e.target.value);
        });

        // IT
        const inputIT = document.getElementById('search-it');

        const searchIT = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instanceIT.search(phrase, columns);
        };

        document
            .getElementById("search-it-button")
            .addEventListener("click", (e) => {
            searchIT(inputIT.value);
            });

        inputIT.addEventListener("keydown", (e) => {
            searchIT(e.target.value);
        });

        // Kesehatan
        const inputKes = document.getElementById('search-sehat');

        const searchKes = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instanceKes.search(phrase, columns);
        };

        document
            .getElementById("search-sehat-button")
            .addEventListener("click", (e) => {
            searchKes(inputKes.value);
            });

        inputKes.addEventListener("keydown", (e) => {
            searchKes(e.target.value);
        });

        // Konsum
        const inputKonsum = document.getElementById('search-konsum');

        const searchKonsum = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instanceKonsum.search(phrase, columns);
        };

        document
            .getElementById("search-konsum-button")
            .addEventListener("click", (e) => {
            searchKonsum(inputKonsum.value);
            });

        inputKonsum.addEventListener("keydown", (e) => {
            searchKonsum(e.target.value);
        });

        // Peran
        const inputPeran = document.getElementById('search-peran');

        const searchPeran = (value) => {
            let [phrase, columns] = value.split(" in:").map((str) => str.trim());

            if (columns) {
            columns = columns.split(",").map((str) => str.toLowerCase().trim());
            }

            instancePeran.search(phrase, columns);
        };

        document
            .getElementById("search-peran-button")
            .addEventListener("click", (e) => {
            searchPeran(inputPeran.value);
            });

        inputPeran.addEventListener("keydown", (e) => {
            searchPeran(e.target.value);
        });
    </script>
@endsection()