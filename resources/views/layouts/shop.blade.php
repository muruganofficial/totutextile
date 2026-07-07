<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    x-data="{ darkMode: localStorage.getItem('darkMode') === 'true', scrolled: false }"
    x-effect="document.documentElement.classList.toggle('dark', darkMode); localStorage.setItem('darkMode', darkMode)"
    :class="{ 'dark': darkMode }"
    @scroll.window="scrolled = (window.pageYOffset > 20)">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Luxora | Haute Couture & Premium Designer Fabrics' }}</title>

    <!-- Google Fonts: Playfair Display, Inter, Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
        h1, h2, h3, h4, .font-serif-luxury {
            font-family: 'Playfair Display', serif;
        }
        button, a, .font-sans-action {
            font-family: 'Poppins', sans-serif;
        }
        .luxury-glass {
            background: rgba(250, 250, 250, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(17, 24, 39, 0.05);
        }
        .dark .luxury-glass {
            background: rgba(17, 24, 39, 0.75);
            backdrop-filter: blur(20px);
            -webkit-backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .text-gold {
            color: #C89B3C;
        }
        .bg-gold {
            background-color: #C89B3C;
        }
        .border-gold {
            border-color: #C89B3C;
        }
    </style>
</head>
<body class="bg-luxury-offwhite text-luxury-charcoal dark:bg-[#0B0C10] dark:text-gray-100 min-h-screen transition-colors duration-300 antialiased">

    <!-- Global Header / Luxury Shrinking Navbar -->
    <header 
        class="sticky top-0 z-40 w-full transition-all duration-500 ease-in-out"
        :class="scrolled ? 'luxury-glass py-3 shadow-sm' : 'bg-transparent py-6 border-b border-transparent'"
    >
        <div class="max-w-[1600px] mx-auto px-6 sm:px-10">
            <div class="flex items-center justify-between">
                
                <!-- Logo on Left -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="flex flex-col items-start gap-0.5">
                        <span class="text-2xl font-extrabold tracking-[0.2em] font-serif-luxury text-luxury-charcoal dark:text-white">LUXORA</span>
                        <span class="text-[9px] uppercase tracking-[0.4em] text-luxury-gold font-bold font-sans-action -mt-1">Atelier</span>
                    </a>
                </div>

                <!-- Mega Menu / Navigation Links -->
                <nav class="hidden md:flex items-center space-x-10 text-xs font-bold uppercase tracking-[0.2em]">
                    <!-- Ethnic Dropdown -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="/shop?parent_category_id=1" class="hover:text-luxury-gold transition-colors duration-300 flex items-center gap-1.5 py-2">
                            Ethnic Wear
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-luxury-gold transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        <!-- Mega Menu Panel -->
                        <div x-show="open" x-transition class="absolute left-1/2 -translate-x-1/2 mt-1 w-64 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 py-4 z-50">
                            <div class="px-6 py-2 border-b border-gray-50 dark:border-gray-800 mb-2">
                                <span class="text-[9px] font-extrabold tracking-[0.3em] text-luxury-gold uppercase">Categories</span>
                            </div>
                            <a href="/shop?category_id=4" class="block px-6 py-2.5 text-[11px] hover:bg-luxury-stone dark:hover:bg-gray-800 hover:text-luxury-gold transition duration-200">Silk Sarees</a>
                            <a href="/shop?category_id=5" class="block px-6 py-2.5 text-[11px] hover:bg-luxury-stone dark:hover:bg-gray-800 hover:text-luxury-gold transition duration-200">Cotton Sarees</a>
                            <a href="/shop?category_id=6" class="block px-6 py-2.5 text-[11px] hover:bg-luxury-stone dark:hover:bg-gray-800 hover:text-luxury-gold transition duration-200">Lehengas</a>
                            <a href="/shop?category_id=7" class="block px-6 py-2.5 text-[11px] hover:bg-luxury-stone dark:hover:bg-gray-800 hover:text-luxury-gold transition duration-200">Kurtis & Suits</a>
                        </div>
                    </div>

                    <!-- Western Dropdown -->
                    <div class="relative group" x-data="{ open: false }" @mouseenter="open = true" @mouseleave="open = false">
                        <a href="/shop?parent_category_id=2" class="hover:text-luxury-gold transition-colors duration-300 flex items-center gap-1.5 py-2">
                            Western Wear
                            <svg class="w-3.5 h-3.5 text-gray-400 group-hover:text-luxury-gold transition" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </a>
                        <div x-show="open" x-transition class="absolute left-1/2 -translate-x-1/2 mt-1 w-64 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 py-4 z-50">
                            <div class="px-6 py-2 border-b border-gray-50 dark:border-gray-800 mb-2">
                                <span class="text-[9px] font-extrabold tracking-[0.3em] text-luxury-gold uppercase">Categories</span>
                            </div>
                            <a href="/shop?category_id=8" class="block px-6 py-2.5 text-[11px] hover:bg-luxury-stone dark:hover:bg-gray-800 hover:text-luxury-gold transition duration-200">Shirts</a>
                            <a href="/shop?category_id=9" class="block px-6 py-2.5 text-[11px] hover:bg-luxury-stone dark:hover:bg-gray-800 hover:text-luxury-gold transition duration-200">T-Shirts</a>
                            <a href="/shop?category_id=10" class="block px-6 py-2.5 text-[11px] hover:bg-luxury-stone dark:hover:bg-gray-800 hover:text-luxury-gold transition duration-200">Trousers & Jeans</a>
                        </div>
                    </div>

                    <a href="/shop?collection=Wedding+Collection" class="hover:text-luxury-gold transition-colors py-2">Wedding</a>
                    <a href="/shop?collection=Summer+Collection" class="hover:text-luxury-gold transition-colors py-2">Summer</a>
                    <a href="/faqs" class="hover:text-luxury-gold transition-colors py-2">FAQ</a>
                </nav>

                <!-- Actions / Search, Cart, Profile -->
                <div class="flex items-center gap-6">
                    <!-- Search Everywhere -->
                    <livewire:shop.search-everywhere />

                    <!-- Dark Mode Toggle -->
                    <button @click="darkMode = !darkMode; localStorage.setItem('darkMode', darkMode)" class="p-2 rounded-xl text-gray-400 dark:text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                        <svg x-show="!darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998z"></path></svg>
                        <svg x-show="darkMode" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 9H3m15.364-3.364l-.707.707M6.343 17.657l-.707.707m12.728 0l-.707-.707M6.343 6.343l-.707-.707M14.25 12a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z"></path></svg>
                    </button>

                    <!-- Cart Bag -->
                    <a href="/cart" class="relative p-2 text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-800 rounded-xl transition">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        @php
                            $cartCount = count(session('cart', []));
                        @endphp
                        @if($cartCount > 0)
                            <span class="absolute -top-0.5 -right-0.5 bg-luxury-gold text-white text-[9px] font-bold w-4 h-4 rounded-full flex items-center justify-center shadow-md">{{ $cartCount }}</span>
                        @endif
                    </a>

                    <!-- User Account / Panel -->
                    @auth
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" class="flex items-center gap-1 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-luxury-gold flex items-center justify-center text-white font-bold text-xs shadow-md border border-white dark:border-gray-800">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                            </button>
                            <div x-show="open" @click.outside="open = false" x-transition class="absolute right-0 mt-3 w-56 bg-white dark:bg-gray-900 rounded-2xl shadow-xl border border-gray-100 dark:border-gray-800 py-3 z-50">
                                <div class="px-5 py-2.5 border-b border-gray-50 dark:border-gray-800 mb-2">
                                    <p class="text-[9px] text-gray-400 font-bold uppercase tracking-wider">Signed in as</p>
                                    <p class="text-xs font-bold truncate mt-0.5 text-luxury-charcoal dark:text-white">{{ auth()->user()->name }}</p>
                                </div>
                                <a href="/dashboard" class="block px-5 py-2 hover:bg-luxury-stone dark:hover:bg-gray-800 text-xs font-bold transition">Dashboard</a>
                                
                                @if(auth()->user()->hasRole('admin') || auth()->user()->hasRole('employee'))
                                    <a href="/admin/dashboard" class="block px-5 py-2 text-luxury-gold font-bold hover:bg-luxury-stone dark:hover:bg-gray-800 text-xs transition">Admin Panel</a>
                                @endif

                                @if(auth()->user()->hasRole('vendor'))
                                    <a href="/vendor/dashboard" class="block px-5 py-2 text-emerald-500 font-bold hover:bg-luxury-stone dark:hover:bg-gray-800 text-xs transition">Vendor Panel</a>
                                @endif

                                <a href="/profile" class="block px-5 py-2 hover:bg-luxury-stone dark:hover:bg-gray-800 text-xs font-bold transition">Profile Settings</a>
                                <div class="border-t border-gray-50 dark:border-gray-800 my-2"></div>
                                <livewire:layout.navigation-logout />
                            </div>
                        </div>
                    @else
                        <a href="/login" class="px-5 py-2.5 text-xs font-bold uppercase tracking-widest bg-luxury-charcoal hover:bg-luxury-gold dark:bg-white dark:text-luxury-charcoal dark:hover:bg-luxury-gold dark:hover:text-white text-white rounded-xl shadow-md transition duration-300 whitespace-nowrap">
                            Log In
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Slot: Bound to max width of 1600px -->
    <main class="py-12 max-w-[1600px] mx-auto px-6 sm:px-10">
        {{ $slot }}
    </main>

    <!-- Luxury Footer -->
    <footer class="bg-luxury-charcoal text-white border-t border-gray-800 transition-colors duration-300 mt-28">
        <div class="max-w-[1600px] mx-auto px-6 sm:px-10 py-20">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12">
                <div class="space-y-6">
                    <span class="text-3xl font-extrabold tracking-[0.2em] font-serif-luxury bg-gradient-to-r from-amber-400 to-amber-600 bg-clip-text text-transparent">LUXORA</span>
                    <p class="text-xs text-gray-400 leading-relaxed tracking-wider">
                        Atelier curating pure-bred Kanchipuram silks, heritage Banarasi weaves, and custom slim-fit Egyptian cotton clothing. Bridging legacy with modern elegance.
                    </p>
                    <div class="flex gap-4">
                        <span class="text-[10px] font-bold text-luxury-gold tracking-widest uppercase">Awwwards Winner 2026</span>
                    </div>
                </div>
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-[0.2em] text-luxury-gold mb-6 font-serif-luxury">Collections</h3>
                    <ul class="space-y-3.5 text-xs text-gray-400 font-medium tracking-wide">
                        <li><a href="/shop?category_id=4" class="hover:text-luxury-gold transition duration-300">Kanchipuram Silk Sarees</a></li>
                        <li><a href="/shop?category_id=6" class="hover:text-luxury-gold transition duration-300">Bridal Lehengas</a></li>
                        <li><a href="/shop?category_id=8" class="hover:text-luxury-gold transition duration-300">Egyptian Cotton Shirts</a></li>
                        <li><a href="/shop?collection=Summer+Collection" class="hover:text-luxury-gold transition duration-300">Summer Handloom Mulmul</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-xs font-extrabold uppercase tracking-[0.2em] text-luxury-gold mb-6 font-serif-luxury">Customer Atelier</h3>
                    <ul class="space-y-3.5 text-xs text-gray-400 font-medium tracking-wide">
                        <li><a href="/faqs" class="hover:text-luxury-gold transition duration-300">FAQ & Help</a></li>
                        <li><a href="/contact" class="hover:text-luxury-gold transition duration-300">Contact Concierge</a></li>
                        <li><a href="/shipping-refunds" class="hover:text-luxury-gold transition duration-300">Shipping & Returns</a></li>
                        <li><a href="/locations" class="hover:text-luxury-gold transition duration-300">Boutique Locations</a></li>
                    </ul>
                </div>
                <div class="space-y-6">
                    <h3 class="text-xs font-extrabold uppercase tracking-[0.2em] text-luxury-gold mb-6 font-serif-luxury">Join the Gazette</h3>
                    <p class="text-xs text-gray-400 leading-relaxed tracking-wider">Subscribe for early access notifications to luxury seasonal drops.</p>
                    <form class="flex gap-2">
                        <input type="email" placeholder="Email address" class="w-full px-4 py-3 bg-gray-900 border border-gray-800 text-xs rounded-xl focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-white placeholder-gray-500">
                        <button type="submit" class="px-5 py-3 bg-luxury-gold hover:bg-amber-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300">Join</button>
                    </form>
                </div>
            </div>
            <div class="mt-20 pt-8 border-t border-gray-800 flex flex-col sm:flex-row items-center justify-between text-[11px] tracking-wider text-gray-500">
                <p>&copy; {{ date('Y') }} Luxora Atelier. Designed by Senior UI/UX Team.</p>
                <div class="flex gap-8 mt-4 sm:mt-0 font-bold uppercase">
                    <a href="/privacy" class="hover:text-white transition duration-300">Privacy Policy</a>
                    <a href="/terms" class="hover:text-white transition duration-300">Terms of Service</a>
                </div>
            </div>
        </div>
    </footer>

    <!-- Toast Notification System -->
    <div x-data="{ toasts: [] }" 
         @toast.window="toasts.push({ id: Date.now(), message: $event.detail.message, type: $event.detail.type || 'info' })"
         class="fixed bottom-6 right-6 z-50 flex flex-col gap-3 max-w-sm w-full font-sans-action">
        
        <template x-for="t in toasts" :key="t.id">
            <div x-data="{ show: true }" 
                 x-show="show"
                 x-init="setTimeout(() => { show = false; toasts = toasts.filter(item => item.id !== t.id) }, 4000)"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 translate-y-3"
                 x-transition:enter-end="opacity-100 translate-y-0"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 :class="{
                    'bg-emerald-600 text-white': t.type === 'success',
                    'bg-rose-600 text-white': t.type === 'error',
                    'bg-luxury-gold text-white': t.type === 'warning',
                    'bg-blue-600 text-white': t.type === 'info'
                 }"
                 class="px-5 py-4 rounded-xl shadow-2xl flex items-center justify-between text-xs tracking-wider font-semibold backdrop-blur-md border border-white/10">
                <span x-text="t.message"></span>
                <button @click="show = false" class="text-white hover:text-gray-200 focus:outline-none ml-4">
                    <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
        </template>
    </div>

    @livewireScripts
</body>
</html>
