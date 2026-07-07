<div class="space-y-10 font-inter">
    
    <!-- Welcome Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Welcome back, {{ auth()->user()->name }}</h1>
        </div>
    </div>

    <!-- Alert / Link Bank Account Banner -->
    <div class="bg-slate-800 text-gray-100 p-6 rounded-2xl flex flex-col md:flex-row items-center justify-between gap-6 shadow border border-slate-700">
        <div class="flex items-center gap-4.5">
            <div class="p-3.5 bg-slate-700/60 rounded-full text-white shadow-inner">
                <!-- Bell icon -->
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            </div>
            <div class="space-y-1">
                <h3 class="text-sm font-extrabold tracking-wide text-white uppercase">Link your bank account to your fiedly account</h3>
                <p class="text-xs text-slate-300 font-light leading-relaxed">Setup direct deposit to automatically settle designer sales and platform fee payouts daily.</p>
            </div>
        </div>
        <div class="flex gap-3.5 flex-shrink-0 font-sans-action">
            <button onclick="alert('Bank settlement system under maintenance. Please try again later.');" class="px-5 py-2.5 bg-white hover:bg-gray-100 text-slate-900 font-bold rounded-lg text-xs transition">Link bank account</button>
            <button class="px-5 py-2.5 bg-blue-650 hover:bg-blue-600 text-white font-bold rounded-lg text-xs transition">Later</button>
        </div>
    </div>

    <!-- Stats Cards (Plusadmin layout) -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-8">
        <!-- Revenue -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm flex flex-col justify-between h-36">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($totalSales / 1000, 1) }}k</span>
                <span class="flex items-center gap-1 text-[10px] font-black text-emerald-500 uppercase">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                    31.5%
                </span>
            </div>
            <div class="flex items-center gap-2.5 text-xs text-gray-400 font-semibold mt-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Total Revenue
            </div>
        </div>

        <!-- Profit -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm flex flex-col justify-between h-36">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($totalSales * 0.12 / 1000, 1) }}k</span>
                <span class="flex items-center gap-1 text-[10px] font-black text-rose-500 uppercase">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                    5.32%
                </span>
            </div>
            <div class="flex items-center gap-2.5 text-xs text-gray-400 font-semibold mt-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Total Profit
            </div>
        </div>

        <!-- Cost -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm flex flex-col justify-between h-36">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-gray-900 dark:text-white">₹{{ number_format($totalSales * 0.88 / 1000, 1) }}k</span>
                <span class="flex items-center gap-1 text-[10px] font-black text-emerald-500 uppercase">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                    12.09%
                </span>
            </div>
            <div class="flex items-center gap-2.5 text-xs text-gray-400 font-semibold mt-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                Total Cost
            </div>
        </div>

        <!-- Volume -->
        <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm flex flex-col justify-between h-36">
            <div class="flex items-center justify-between">
                <span class="text-2xl font-bold text-gray-900 dark:text-white">{{ $totalOrders }}</span>
                <span class="flex items-center gap-1 text-[10px] font-black text-emerald-500 uppercase">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 15l7-7 7 7"></path></svg>
                    2.00%
                </span>
            </div>
            <div class="flex items-center gap-2.5 text-xs text-gray-400 font-semibold mt-4">
                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                Total Volume
            </div>
        </div>
    </div>

    <!-- Income Report Custom Chart Widget (Plusadmin Bar style) -->
    <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm space-y-6">
        <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
            <h3 class="font-bold text-sm uppercase tracking-wider text-gray-900 dark:text-white">Income Report - {{ date('Y') }}</h3>
            <span class="text-[10px] font-extrabold uppercase tracking-widest text-blue-500">Live Analytics</span>
        </div>

        <!-- Chart Container -->
        <div class="flex gap-6 items-end justify-between pt-6 h-64 border-b border-gray-100 dark:border-gray-800 relative">
            <!-- Y-Axis Lines (Absolute guide grids) -->
            <div class="absolute inset-0 flex flex-col justify-between pointer-events-none text-[9px] text-gray-400 font-bold pr-2 pb-6">
                <div class="border-b border-gray-50 dark:border-gray-800 w-full text-right">25k</div>
                <div class="border-b border-gray-50 dark:border-gray-800 w-full text-right">20k</div>
                <div class="border-b border-gray-50 dark:border-gray-800 w-full text-right">15k</div>
                <div class="border-b border-gray-50 dark:border-gray-800 w-full text-right">10k</div>
                <div class="border-b border-gray-50 dark:border-gray-800 w-full text-right">5k</div>
            </div>

            <!-- Vertical Bar loops -->
            @php
                $monthsData = [
                    'Jan' => 'h-[60%]',
                    'Feb' => 'h-[50%]',
                    'Mar' => 'h-[20%]',
                    'Apr' => 'h-[52%]',
                    'May' => 'h-[72%]',
                    'Jun' => 'h-[85%]',
                    'Jul' => 'h-[95%]',
                    'Aug' => 'h-[88%]',
                    'Sep' => 'h-[76%]',
                    'Oct' => 'h-[56%]',
                    'Nov' => 'h-[56%]',
                    'Dec' => 'h-[56%]'
                ];
            @endphp
            @foreach($monthsData as $monthName => $heightClass)
                <div class="flex flex-col items-center flex-grow z-10">
                    <div class="w-7 sm:w-10 {{ $heightClass }} bg-blue-500 dark:bg-blue-600 rounded-t-lg transition-all duration-1000 hover:bg-luxury-gold shadow-md"></div>
                </div>
            @endforeach
        </div>

        <!-- X-Axis Months labels -->
        <div class="flex justify-between text-[10px] font-bold text-gray-400 uppercase tracking-widest pt-2">
            @foreach(array_keys($monthsData) as $mLabel)
                <div class="flex-grow text-center">{{ $mLabel }}</div>
            @endforeach
        </div>
    </div>

    <!-- Recent Orders & Alerts Split -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Recent Orders (2 cols) -->
        <div class="lg:col-span-2 space-y-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Recent Shop Orders</h2>
            <div class="bg-white dark:bg-gray-900 rounded-2xl overflow-hidden shadow-sm border border-gray-150 dark:border-gray-800">
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm divide-y divide-gray-150 dark:divide-gray-800">
                        <thead class="bg-gray-55/60 dark:bg-gray-900/50 text-xs font-bold uppercase text-gray-400 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Order #</th>
                                <th class="px-6 py-4">Customer</th>
                                <th class="px-6 py-4">Date</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                            @foreach($recentOrders as $ro)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition text-gray-800 dark:text-gray-200">
                                    <td class="px-6 py-4 font-bold">{{ $ro->order_number }}</td>
                                    <td class="px-6 py-4 text-xs font-semibold">{{ $ro->customer->name }}</td>
                                    <td class="px-6 py-4 text-xs text-gray-400">{{ $ro->created_at->format('M d, Y') }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2.5 py-1.5 text-[9px] font-bold rounded-md uppercase tracking-wider 
                                            {{ $ro->status === 'Pending' ? 'bg-amber-500/10 text-amber-500' : '' }}
                                            {{ $ro->status === 'Delivered' ? 'bg-emerald-500/10 text-emerald-500' : '' }}
                                            {{ $ro->status === 'Processing' ? 'bg-blue-500/10 text-blue-500' : '' }}
                                        ">
                                            {{ $ro->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right font-bold text-luxury-gold">₹{{ number_format($ro->total, 2) }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Low Stock Alerts (1 col) -->
        <div class="lg:col-span-1 space-y-6">
            <h2 class="text-lg font-bold text-gray-900 dark:text-white">Low Stock Alerts</h2>
            <div class="space-y-4 max-h-[400px] overflow-y-auto pr-2">
                @forelse($lowStockItems as $lsi)
                    <div class="bg-white dark:bg-gray-900 p-4 rounded-xl border border-rose-500/20 shadow-sm flex items-center justify-between gap-4">
                        <div>
                            <h4 class="text-sm font-bold text-gray-950 dark:text-white line-clamp-1">{{ $lsi->product->name }}</h4>
                            <p class="text-[11px] text-gray-400 mt-0.5">Warehouse: {{ $lsi->warehouse->name }}</p>
                        </div>
                        <div class="text-right">
                            <span class="px-2 py-1 text-[9px] font-bold uppercase tracking-wider bg-rose-500/10 text-rose-500 rounded-md">
                                {{ $lsi->quantity }} Qty
                            </span>
                        </div>
                    </div>
                @empty
                    <div class="bg-white dark:bg-gray-900 p-10 rounded-2xl text-center text-gray-500 border border-gray-150">
                        No active stock alerts.
                    </div>
                @endforelse
            </div>
        </div>

    </div>
</div>
