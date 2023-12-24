<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.0/jquery.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.css" />
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.js"></script>
    <title>Admin | {{$title}}</title>
    {{-- sweetalert cdn --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    @yield('style')
</head>
<body>
    <!-- Sidenav -->
    <nav
    id="sidenav-8"
    class="fixed left-0 top-0 z-[1035] h-full min-h-[100vh] w-60 -translate-x-full overflow-hidden bg-white shadow-[0_4px_12px_0_rgba(0,0,0,0.07),_0_2px_4px_rgba(0,0,0,0.05)] data-[te-sidenav-hidden='false']:translate-x-0 dark:bg-zinc-800 invisible md:visible"
    data-te-sidenav-init
    data-te-sidenav-hidden="false"
    data-te-sidenav-position="fixed"
    data-te-sidenav-mode="side"
    data-te-sidenav-accordion="true">
    <a
    class="mb-3 flex items-center justify-center border-b-2 border-solid border-gray-100 py-6 outline-none"
    href="#!"
    data-te-ripple-init
    data-te-ripple-color="primary">
    <span class="text-center font-bold">Welcome<br>Grateful<br>Generation</span>
    </a>
    <ul
    class="relative m-0 list-none px-[0.2rem] pb-12"
    data-te-sidenav-menu-ref>
    <li class="relative">
        <a
        class="flex cursor-pointer items-center truncate rounded-[5px] px-6 py-[0.45rem] text-[0.85rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
        data-te-sidenav-link-ref
        href="./main.php">
        <span
            class="mr-4 [&>svg]:h-3.5 [&>svg]:w-3.5 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="h-3.5 w-3.5">
            <path
                d="M11.47 3.84a.75.75 0 011.06 0l8.69 8.69a.75.75 0 101.06-1.06l-8.689-8.69a2.25 2.25 0 00-3.182 0l-8.69 8.69a.75.75 0 001.061 1.06l8.69-8.69z" />
            <path
                d="M12 5.432l8.159 8.159c.03.03.06.058.091.086v6.198c0 1.035-.84 1.875-1.875 1.875H15a.75.75 0 01-.75-.75v-4.5a.75.75 0 00-.75-.75h-3a.75.75 0 00-.75.75V21a.75.75 0 01-.75.75H5.625a1.875 1.875 0 01-1.875-1.875v-6.198a2.29 2.29 0 00.091-.086L12 5.43z" />
            </svg>
        </span>
        <span>Overview</span>
        </a>
    </li>
    <li class="relative pt-4">
        <span
        class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400"
        >Date</span
        >
        <a
        class="flex cursor-pointer items-center truncate rounded-[5px] px-6 py-[0.45rem] text-[0.85rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
        href="{{ route('admin.date') }}"
        data-te-sidenav-link-ref>
        <span
            class="mr-4 [&>svg]:h-5 [&>svg]:w-5 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 24 24"
            stroke-width="1.5"
            stroke="currentColor"
            class="h-5 w-5">
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                d="M12 4.5v15m7.5-7.5h-15" />
            </svg>
        </span>
        <span>Dates</span>
        </a>
    </li>
    <li class="relative pt-4">
        <span
        class="px-6 py-4 text-[0.6rem] font-bold uppercase text-gray-600 dark:text-gray-400"
        >Interview</span
        >
        <a
        href="{{ route('admin.select.schedule') }}"
        class="flex cursor-pointer items-center truncate rounded-[5px] px-6 py-[0.45rem] text-[0.85rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
        data-te-sidenav-link-ref>
        <span
            class="mr-4 [&>svg]:h-3.5 [&>svg]:w-3.5 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="h-3.5 w-3.5">
            <path
                fill-rule="evenodd"
                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                clip-rule="evenodd" />
            <path
                fill-rule="evenodd"
                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                clip-rule="evenodd" />
            </svg>
        </span>
        <span>Select Schedule</span>
        </a>
    </li>
    <li class="relative">
        <a
        href="{{ route('admin.question') }}"
        class="flex cursor-pointer items-center truncate rounded-[5px] px-6 py-[0.45rem] text-[0.85rem] text-gray-600 outline-none transition duration-300 ease-linear hover:bg-slate-50 hover:text-inherit hover:outline-none focus:bg-slate-50 focus:text-inherit focus:outline-none active:bg-slate-50 active:text-inherit active:outline-none data-[te-sidenav-state-active]:text-inherit data-[te-sidenav-state-focus]:outline-none motion-reduce:transition-none dark:text-gray-300 dark:hover:bg-white/10 dark:focus:bg-white/10 dark:active:bg-white/10"
        data-te-sidenav-link-ref>
        <span
            class="mr-4 [&>svg]:h-3.5 [&>svg]:w-3.5 [&>svg]:text-gray-400 dark:[&>svg]:text-gray-300">
            <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="h-3.5 w-3.5">
            <path
                fill-rule="evenodd"
                d="M2.25 13.5a8.25 8.25 0 018.25-8.25.75.75 0 01.75.75v6.75H18a.75.75 0 01.75.75 8.25 8.25 0 01-16.5 0z"
                clip-rule="evenodd" />
            <path
                fill-rule="evenodd"
                d="M12.75 3a.75.75 0 01.75-.75 8.25 8.25 0 018.25 8.25.75.75 0 01-.75.75h-7.5a.75.75 0 01-.75-.75V3z"
                clip-rule="evenodd" />
            </svg>
        </span>
        <span>Questions</span>
        </a>
    </li>
    </ul>
    </nav>

    {{-- NAVBAR --}}
    <!-- Main navigation container -->
    <nav
    class="flex-no-wrap relative flex w-full items-center justify-between bg-[#FBFBFB] py-2 shadow-md shadow-black/5 dark:bg-neutral-600 dark:shadow-black/10 lg:flex-wrap lg:justify-start lg:py-4 block md:hidden">
    <div class="flex w-full flex-wrap items-center justify-between px-3">
    <!-- Hamburger button for mobile view -->
    <button
        class="block border-0 bg-transparent px-2 text-neutral-500 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 sm:hidden"
        type="button"
        data-te-collapse-init
        data-te-target="#navbarSupportedContent12"
        aria-controls="navbarSupportedContent12"
        aria-expanded="false"
        aria-label="Toggle navigation">
        <!-- Hamburger icon -->
        <span class="[&>svg]:w-7">
        <svg
            xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 24 24"
            fill="currentColor"
            class="h-7 w-7">
            <path
            fill-rule="evenodd"
            d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
            clip-rule="evenodd" />
        </svg>
        </span>
    </button>

    <!-- Collapsible navigation container -->
    <div
        class="!visible hidden flex-grow basis-[100%] items-center sm:!flex sm:basis-auto"
        id="navbarSupportedContent12"
        data-te-collapse-item>
        <!-- Left navigation links -->
        <ul
        class="list-style-none mr-auto flex flex-col pl-0 sm:flex-row"
        data-te-navbar-nav-ref>
        <!-- Dashboard link -->
        <li class="mb-4 sm:mb-0 sm:pr-2" data-te-nav-item-ref>
            <a
            class="text-neutral-500 transition duration-200 hover:text-neutral-700 hover:ease-in-out focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 sm:px-2 [&.active]:text-black/90 dark:[&.active]:text-zinc-400"
            href="#"
            data-te-nav-link-ref
            >Dashboard</a
            >
        </li>
        <!-- Schedule link -->
        <li
        class="mb-4 pl-2 sm:mb-0 sm:pl-0 sm:pr-1"
        data-te-nav-item-ref
        data-te-dropdown-ref>
        <!-- Dropdown -->
        <a
            class="flex items-center text-neutral-500 transition duration-200 hover:text-neutral-700 hover:ease-in-out focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400 sm:px-2 [&.active]:text-black/90 dark:[&.active]:text-neutral-400"
            href="#"
            type="button"
            id="dropdownMenuButton2"
            data-te-dropdown-toggle-ref
            aria-expanded="false">
            Schedules
            <span class="ml-1 w-2">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="h-5 w-5">
                <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
                </svg>
            </span>
            </a>
            <ul
            class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
            aria-labelledby="dropdownMenuButton2"
            data-te-dropdown-menu-ref>
            <li>
                <a
                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                href="#"
                data-te-dropdown-item-ref
                >Action</a
                >
            </li>
            <li>
                <a
                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                href="#"
                data-te-dropdown-item-ref
                >Another action</a
                >
            </li>
            <li>
                <a
                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                href="#"
                data-te-dropdown-item-ref
                >Something else here</a
                >
            </li>
            </ul>
        </li>
        <!-- Inteerview link -->
        <li
        class="mb-4 pl-2 sm:mb-0 sm:pl-0 sm:pr-1"
        data-te-nav-item-ref
        data-te-dropdown-ref>
        <!-- Dropdown -->
        <a
            class="flex items-center text-neutral-500 transition duration-200 hover:text-neutral-700 hover:ease-in-out focus:text-neutral-700 disabled:text-black/30 motion-reduce:transition-none dark:text-neutral-200 dark:hover:text-neutral-400 dark:focus:text-neutral-400 sm:px-2 [&.active]:text-black/90 dark:[&.active]:text-neutral-400"
            href="#"
            type="button"
            id="dropdownMenuButton2"
            data-te-dropdown-toggle-ref
            aria-expanded="false">
            Interview
            <span class="ml-1 w-2">
                <svg
                xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20"
                fill="currentColor"
                class="h-5 w-5">
                <path
                    fill-rule="evenodd"
                    d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z"
                    clip-rule="evenodd" />
                </svg>
            </span>
            </a>
            <ul
            class="absolute z-[1000] float-left m-0 hidden min-w-max list-none overflow-hidden rounded-lg border-none bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
            aria-labelledby="dropdownMenuButton2"
            data-te-dropdown-menu-ref>
            <li>
                <a
                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                href="#"
                data-te-dropdown-item-ref
                >Action</a
                >
            </li>
            <li>
                <a
                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                href="#"
                data-te-dropdown-item-ref
                >Another action</a
                >
            </li>
            <li>
                <a
                class="block w-full whitespace-nowrap bg-transparent px-4 py-2 text-sm font-normal text-neutral-700 hover:bg-neutral-100 active:text-neutral-800 active:no-underline disabled:pointer-events-none disabled:bg-transparent disabled:text-neutral-400 dark:text-neutral-200 dark:hover:bg-neutral-600"
                href="#"
                data-te-dropdown-item-ref
                >Something else here</a
                >
            </li>
            </ul>
        </li>
        </ul>
    </div>

    <!-- Right elements -->
    <div class="relative flex items-center">
        <!-- Cart Icon -->
        <a
        class="mr-4 text-secondary-500 transition duration-200 hover:text-secondary-400 hover:ease-in-out focus:text-secondary-400 disabled:text-black/30 motion-reduce:transition-none"
        href="#">
        <span class="[&>svg]:w-5">
            <svg class="w-[24px] h-[24px] fill-[#ff6b6b]" viewBox="0 0 512 512" xmlns="http://www.w3.org/2000/svg">

                <!--! Font Awesome Free 6.4.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license (Commercial License) Copyright 2023 Fonticons, Inc. -->
                <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
            
            </svg>
        </span>
        </a>
    </div>
    </div>
    </nav>


    <div class="ml-0 md:ml-60 px-3 md:px-8 py-2 md:py-3">
        @yield('content')
    </div>
    <!-- Sidenav -->
    @yield('script')
    <script src="https://cdn.jsdelivr.net/npm/tw-elements/dist/js/tw-elements.umd.min.js"></script>
</body>
</html>