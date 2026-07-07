<div class="space-y-10">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="/admin/dashboard" wire:navigate class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-amber-500 hover:text-white rounded-xl transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-950 dark:text-white">Business Intelligence</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review aggregated turnover metrics, taxation tallies, and export reports.</p>
        </div>
    </div>

    <!-- Stats Grid 1: Sales Turnover -->
    <div class="space-y-4">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Sales & Turnover Metrics</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <!-- Daily Sales -->
            <div class="glassmorphism p-6 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-3 bg-amber-500/10 text-amber-500 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Daily Sales Turnover</span>
                    <p class="text-2xl font-black text-amber-500 mt-1">₹{{ number_format($dailySales, 2) }}</p>
                </div>
            </div>

            <!-- Monthly Sales -->
            <div class="glassmorphism p-6 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-3 bg-blue-500/10 text-blue-500 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Monthly Sales (MTD)</span>
                    <p class="text-2xl font-black text-blue-500 mt-1">₹{{ number_format($monthlySales, 2) }}</p>
                </div>
            </div>

            <!-- Yearly Sales -->
            <div class="glassmorphism p-6 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Annual Sales (YTD)</span>
                    <p class="text-2xl font-black text-emerald-500 mt-1">₹{{ number_format($yearlySales, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Stats Grid 2: Tax & Commission -->
    <div class="space-y-4 pt-6">
        <h2 class="text-lg font-bold text-gray-900 dark:text-white">Taxation & Commissions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <!-- GST Collected -->
            <div class="glassmorphism p-6 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-3 bg-indigo-500/10 text-indigo-500 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 14l6-6m-5.5.5h.01m5.99 5.99h.01M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z"></path></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Estimated GST Tax Collected</span>
                    <p class="text-2xl font-black text-indigo-500 mt-1">₹{{ number_format($totalGstCollected, 2) }}</p>
                </div>
            </div>

            <!-- Platform Commissions -->
            <div class="glassmorphism p-6 rounded-2xl shadow-sm flex items-start gap-4">
                <div class="p-3 bg-emerald-500/10 text-emerald-500 rounded-xl">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v13m0-13V6a2 2 0 112 2h-2zm0 0V5a2 2 0 10-2 2h2zm-2 4h10M5 20h14a2 2 0 002-2V9a2 2 0 00-2-2H5a2 2 0 00-2 2v9a2 2 0 002 2z"></path></svg>
                </div>
                <div>
                    <span class="text-xs font-bold uppercase tracking-wider text-gray-400">Platform Commissions Accrued</span>
                    <p class="text-2xl font-black text-emerald-500 mt-1">₹{{ number_format($totalCommissionsEarned, 2) }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Export Action -->
    <div class="glassmorphism p-6 rounded-2xl shadow-sm text-center max-w-md mx-auto space-y-4">
        <h3 class="font-bold text-gray-900 dark:text-white">Export Audit Report</h3>
        <p class="text-xs text-gray-400">Print or save the official consolidated financial audit summaries as a PDF document.</p>
        <button 
            type="button" 
            wire:click="downloadPdfReport" 
            class="px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white font-bold rounded-xl text-sm transition flex items-center justify-center gap-2 mx-auto"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Export Consolidated PDF
        </button>
    </div>
</div>
