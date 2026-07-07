<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', sidebarOpen: true }"
    x-effect="document.documentElement.classList.toggle('dark', darkMode); localStorage.setItem('darkMode', darkMode)"
    :class="{ 'dark': darkMode }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Back-office Control panel' }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4 {
            font-family: 'Inter', sans-serif;
        }
        .admin-sidebar {
            background-color: #111b27;
        }
        .admin-header {
            background-color: #1e293b;
        }
    </style>
</head>
<body class="bg-gray-100 dark:bg-gray-950 text-gray-800 dark:text-gray-200 min-h-screen transition-colors duration-300 antialiased flex">

    <!-- Left Sidebar (Collapsible) -->
    <aside 
        class="w-80 min-h-screen text-gray-300 flex-shrink-0 transition-all duration-300 flex flex-col admin-sidebar border-r border-gray-800"
        x-show="sidebarOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="-translate-x-full"
        x-transition:enter-end="translate-x-0"
        x-transition:leave="transition ease-in duration-300"
        x-transition:leave-start="translate-x-0"
        x-transition:leave-end="-translate-x-full"
    >
        <!-- User Profile Frame at top -->
        <div class="p-8 flex flex-col items-center text-center space-y-3.5 border-b border-gray-800 relative">
            <div class="w-16 h-16 rounded-full bg-luxury-gold flex items-center justify-center text-white font-extrabold text-xl shadow-lg border border-gray-700">
                {{ substr(auth()->user()->name ?? 'A', 0, 1) }}
            </div>
            <div>
                <h3 class="font-bold text-sm text-white tracking-wide">{{ auth()->user()->name ?? 'Atelier Staff' }}</h3>
                <p class="text-[10px] text-luxury-gold font-bold uppercase tracking-widest mt-0.5">
                    @if(auth()->user() && auth()->user()->hasRole('admin'))
                        Admin Director
                    @elseif(auth()->user() && auth()->user()->hasRole('vendor'))
                        Vendor Weaver
                    @else
                        Atelier Associate
                    @endif
                </p>
            </div>
        </div>


        <!-- Sidebar search input -->
        <div class="px-6 py-4">
            <input type="text" placeholder="Search menu..." class="w-full px-4 py-2 bg-gray-900 border border-gray-800 rounded-xl text-xs text-white placeholder-gray-500 focus:outline-none focus:border-blue-500">
        </div>

        <!-- Menu Navigation Links -->
        <nav class="flex-grow px-4 py-4 space-y-1 text-xs font-semibold tracking-wider">
            <span class="px-4 text-[9px] uppercase tracking-[0.2em] text-gray-500 font-bold block mb-2.5">Pages</span>
            
            @if(auth()->user() && (auth()->user()->hasRole('admin') || auth()->user()->hasRole('employee')))
                <!-- Admin Pages -->
                <a href="/admin/dashboard" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <span class="flex items-center gap-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Home Dashboard
                    </span>
                </a>

                <a href="/admin/inventory" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.inventory') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <span class="flex items-center gap-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        Products & Inventory
                    </span>
                    <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7-7"></path></svg>
                </a>

                <a href="/admin/orders" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.orders') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <span class="flex items-center gap-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path></svg>
                        Orders & Sales
                    </span>
                    <svg class="w-3 h-3 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7-7"></path></svg>
                </a>

                <a href="/admin/employees" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.employees') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <span class="flex items-center gap-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Staff Attendance
                    </span>
                </a>

                <a href="/admin/reports" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('admin.reports') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <span class="flex items-center gap-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                        Financial Reports
                    </span>
                </a>
            @endif

            @if(auth()->user() && auth()->user()->hasRole('vendor'))
                <!-- Vendor Pages -->
                <a href="/vendor/dashboard" class="w-full flex items-center justify-between px-4 py-3 rounded-xl transition duration-200 {{ request()->routeIs('vendor.dashboard') ? 'bg-blue-600 text-white shadow' : 'text-gray-400 hover:bg-gray-900 hover:text-white' }}">
                    <span class="flex items-center gap-3.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                        Vendor Home
                    </span>
                </a>
            @endif

            <div class="border-t border-gray-800 my-4"></div>
            <a href="/" class="w-full flex items-center px-4 py-3 rounded-xl text-gray-400 hover:bg-gray-900 hover:text-white transition duration-200">
                <span class="flex items-center gap-3.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Back to Storefront
                </span>
            </a>

            <form method="POST" action="{{ route('logout') }}" class="w-full">
                @csrf
                <button type="submit" class="w-full text-left px-4 py-3 rounded-xl text-rose-450 hover:bg-rose-950/20 hover:text-rose-500 transition duration-200 flex items-center gap-3.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Log Out
                </button>
            </form>
        </nav>
    </aside>

    <!-- Right Side Body Frame (Header + Dynamic Page Content) -->
    <div class="flex-grow flex flex-col min-h-screen">
        
        <!-- Header Bar -->
        <header class="h-16 flex items-center justify-between px-8 text-white admin-header shadow-sm border-b border-gray-800">
            <div class="flex items-center gap-5">
                <!-- Toggle collapse sidebar -->
                <button @click="sidebarOpen = !sidebarOpen" class="p-2 rounded-xl bg-gray-900 border border-gray-850 hover:bg-gray-800 text-gray-400 hover:text-white transition">
                    <!-- Collapse arrows -->
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                </button>
                <div class="flex gap-4 text-gray-400">
                    <svg class="w-5 h-5 hover:text-white cursor-pointer transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <svg class="w-5 h-5 hover:text-white cursor-pointer transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                </div>
            </div>

            <div class="flex items-center gap-3">

                <!-- Dark Mode Toggle -->
                <button
                    @click="darkMode = !darkMode"
                    class="p-2 rounded-xl bg-gray-900 border border-gray-800 hover:bg-gray-800 text-gray-400 hover:text-white transition"
                    :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
                >
                    <!-- Moon icon (show when light mode) -->
                    <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
                    </svg>
                    <!-- Sun icon (show when dark mode) -->
                    <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
                    </svg>
                </button>

                <a href="/" class="p-2 bg-gray-900 border border-gray-800 rounded-lg hover:bg-gray-800 transition" title="View Storefront">
                    <svg class="w-4 h-4 text-gray-400 hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                </a>
            </div>
        </header>

        <!-- Main Body Content Slot -->
        <main class="flex-grow p-8 bg-gray-50 dark:bg-gray-900 overflow-y-auto">
            {{ $slot }}
        </main>
    </div>

    @livewireScripts
</body>
</html>
