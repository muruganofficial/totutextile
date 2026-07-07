<div class="relative w-full max-w-xs sm:max-w-sm" x-data="{ open: false }" @click.outside="open = false">
    <div class="relative">
        <input 
            type="text" 
            wire:model.live="search"
            @focus="open = true"
            @keydown.escape="open = false"
            placeholder="Search products, fabrics..."
            class="w-full pl-10 pr-4 py-2 bg-gray-100 dark:bg-gray-800 border border-transparent dark:border-transparent rounded-xl text-sm focus:outline-none focus:bg-white dark:focus:bg-gray-950 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 transition duration-300 text-gray-800 dark:text-gray-200"
        />
        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
            <svg class="h-4.5 w-4.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>

    <!-- Suggestions Dropdown -->
    <div 
        x-show="open && $wire.results.length > 0" 
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 translate-y-1"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-1"
        class="absolute left-0 mt-2 w-80 sm:w-96 bg-white dark:bg-gray-800 rounded-xl shadow-xl border border-gray-100 dark:border-gray-700 overflow-hidden z-50"
        style="display: none;"
    >
        <div class="p-2 border-b border-gray-100 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50">
            <span class="text-[10px] font-bold uppercase tracking-wider text-amber-500">Suggestions</span>
        </div>
        <div class="divide-y divide-gray-100 dark:divide-gray-700 max-h-80 overflow-y-auto">
            @foreach($results as $product)
                <button 
                    wire:click="selectProduct('{{ $product['slug'] }}')"
                    class="w-full flex items-center gap-3 px-4 py-3 hover:bg-gray-50 dark:hover:bg-gray-700/50 text-left transition duration-200"
                >
                    <div class="w-10 h-10 rounded bg-gray-100 dark:bg-gray-900 overflow-hidden flex-shrink-0 flex items-center justify-center">
                        <!-- Try to show first product image, fallback if needed -->
                        <span class="text-xs text-amber-500 font-bold">TX</span>
                    </div>
                    <div class="flex-grow">
                        <p class="text-sm font-semibold text-gray-800 dark:text-gray-200 truncate">{{ $product['name'] }}</p>
                        <p class="text-[11px] text-gray-400 truncate">SKU: {{ $product['sku'] }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-sm font-bold text-amber-500">₹{{ number_format($product['price'], 2) }}</p>
                    </div>
                </button>
            @endforeach
        </div>
    </div>
</div>
