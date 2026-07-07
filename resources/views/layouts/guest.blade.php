<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true' }"
    x-effect="document.documentElement.classList.toggle('dark', darkMode); localStorage.setItem('darkMode', darkMode)"
    :class="{ 'dark': darkMode }"
>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Textile') }} — Sign In</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body { font-family: 'Inter', sans-serif; }
        .login-brand { font-family: 'Playfair Display', serif; }

        /* Animated gradient background */
        .gradient-bg {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 40%, #0f172a 100%);
            background-size: 400% 400%;
            animation: gradientShift 10s ease infinite;
        }
        @keyframes gradientShift {
            0%   { background-position: 0% 50%; }
            50%  { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating orbs */
        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            animation: floatOrb 8s ease-in-out infinite;
        }
        .orb-1 { width: 500px; height: 500px; background: #6366f1; top: -100px; left: -100px; animation-delay: 0s; }
        .orb-2 { width: 400px; height: 400px; background: #8b5cf6; bottom: -80px; right: -80px; animation-delay: 3s; }
        .orb-3 { width: 300px; height: 300px; background: #c89b3c; top: 50%; left: 50%; animation-delay: 6s; }
        @keyframes floatOrb {
            0%, 100% { transform: translate(0, 0); }
            50%       { transform: translate(30px, -30px); }
        }

        /* Glass card */
        .glass-card {
            background: rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border: 1px solid rgba(255, 255, 255, 0.12);
        }
        .dark .glass-card {
            background: rgba(15, 23, 42, 0.7);
            border: 1px solid rgba(255, 255, 255, 0.08);
        }

        /* Light mode overrides */
        .light-bg {
            background: linear-gradient(135deg, #f0f4ff 0%, #e8e4ff 40%, #f0f4ff 100%);
        }
    </style>
</head>
<body class="antialiased min-h-screen transition-colors duration-300">

    <!-- Full-screen layout -->
    <div class="min-h-screen flex relative overflow-hidden"
         :class="darkMode ? 'gradient-bg' : 'bg-gradient-to-br from-slate-100 via-indigo-50 to-slate-100'"
    >
        <!-- Floating orbs (dark mode only) -->
        <template x-if="darkMode">
            <div aria-hidden="true">
                <div class="orb orb-1"></div>
                <div class="orb orb-2"></div>
                <div class="orb orb-3"></div>
            </div>
        </template>

        <!-- Dark Mode Toggle — top right corner -->
        <button
            @click="darkMode = !darkMode"
            class="absolute top-5 right-5 z-50 p-2.5 rounded-xl border transition-all duration-200 shadow-sm"
            :class="darkMode
                ? 'bg-white/10 border-white/20 text-white hover:bg-white/20'
                : 'bg-white border-gray-200 text-gray-600 hover:bg-gray-50 shadow'"
            :title="darkMode ? 'Switch to Light Mode' : 'Switch to Dark Mode'"
        >
            <!-- Moon -->
            <svg x-show="!darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"/>
            </svg>
            <!-- Sun -->
            <svg x-show="darkMode" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364-6.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"/>
            </svg>
        </button>

        <!-- Left decorative panel (hidden on mobile) -->
        <div class="hidden lg:flex lg:w-1/2 flex-col justify-between p-14 relative z-10">
            <!-- Brand -->
            <a href="/" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl flex items-center justify-center shadow-lg"
                     :class="darkMode ? 'bg-indigo-500' : 'bg-indigo-600'">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                    </svg>
                </div>
                <span class="login-brand text-xl font-bold"
                      :class="darkMode ? 'text-white' : 'text-gray-900'">
                    {{ config('app.name', 'Textile') }}
                </span>
            </a>

            <!-- Center tagline -->
            <div class="space-y-6">
                <h1 class="login-brand text-5xl font-bold leading-tight"
                    :class="darkMode ? 'text-white' : 'text-gray-900'">
                    Manage your<br>
                    <span :class="darkMode ? 'text-indigo-400' : 'text-indigo-600'">textile empire</span><br>
                    with elegance.
                </h1>
                <p class="text-base leading-relaxed max-w-md"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                    A complete back-office platform for managing products, orders, vendors, and inventory — all in one place.
                </p>

                <!-- Feature pills -->
                <div class="flex flex-wrap gap-2 pt-2">
                    @foreach(['Products & Inventory', 'Order Management', 'Vendor Portal', 'Analytics & Reports'] as $feature)
                    <span class="text-xs font-semibold px-3 py-1.5 rounded-full"
                          :class="darkMode
                              ? 'bg-white/10 text-gray-300 border border-white/10'
                              : 'bg-indigo-50 text-indigo-700 border border-indigo-100'">
                        ✦ {{ $feature }}
                    </span>
                    @endforeach
                </div>
            </div>

            <!-- Footer -->
            <p class="text-xs" :class="darkMode ? 'text-gray-600' : 'text-gray-400'">
                © {{ date('Y') }} {{ config('app.name') }}. All rights reserved.
            </p>
        </div>

        <!-- Right: Login Form panel -->
        <div class="w-full lg:w-1/2 flex items-center justify-center p-6 relative z-10">
            <div class="w-full max-w-md">

                <!-- Mobile brand (shown only on mobile) -->
                <div class="flex lg:hidden items-center gap-3 mb-8">
                    <div class="w-9 h-9 rounded-xl bg-indigo-600 flex items-center justify-center">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                        </svg>
                    </div>
                    <span class="login-brand text-xl font-bold"
                          :class="darkMode ? 'text-white' : 'text-gray-900'">
                        {{ config('app.name', 'Textile') }}
                    </span>
                </div>

                <!-- Card -->
                <div class="rounded-2xl p-8 shadow-2xl"
                     :class="darkMode
                         ? 'glass-card'
                         : 'bg-white border border-gray-100 shadow-xl'"
                >
                    <!-- Card header -->
                    <div class="mb-8">
                        <h2 class="text-2xl font-bold mb-1"
                            :class="darkMode ? 'text-white' : 'text-gray-900'">
                            Welcome back
                        </h2>
                        <p class="text-sm" :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                            Sign in to your account to continue
                        </p>
                    </div>

                    <!-- Slot: login form content -->
                    {{ $slot }}

                    <!-- Back to store link -->
                    <div class="mt-6 pt-6 border-t text-center"
                         :class="darkMode ? 'border-white/10' : 'border-gray-100'">
                        <a href="/"
                           class="text-xs font-medium transition"
                           :class="darkMode
                               ? 'text-gray-500 hover:text-gray-300'
                               : 'text-gray-400 hover:text-gray-600'">
                            ← Back to Storefront
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @livewireScripts
</body>
</html>
