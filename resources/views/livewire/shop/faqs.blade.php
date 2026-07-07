<div class="max-w-4xl mx-auto space-y-12">
    <div class="text-center space-y-3">
        <span class="text-xs uppercase font-extrabold tracking-widest text-amber-500">FAQ & Help Center</span>
        <h1 class="text-4xl font-extrabold tracking-tight text-gray-950 dark:text-white">Frequently Asked Questions</h1>
        <p class="text-gray-500 dark:text-gray-400 max-w-lg mx-auto text-sm">Find answers to common questions regarding our pure handloom products, global shipping, returns, and sizing.</p>
    </div>

    <!-- Search Input -->
    <div class="max-w-xl mx-auto">
        <input 
            type="text" 
            wire:model.live.debounce.300ms="search" 
            placeholder="Type your question..." 
            class="w-full px-5 py-3.5 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 text-sm focus:ring-amber-500 focus:border-amber-500 shadow-sm"
        />
    </div>

    <!-- FAQ Accordions -->
    <div class="space-y-10">
        @forelse($faqGroups as $category => $items)
            <div class="space-y-4">
                <h2 class="text-lg font-bold text-amber-500 uppercase tracking-wider">{{ $category }}</h2>
                
                <div class="space-y-3">
                    @foreach($items as $faq)
                        <div 
                            x-data="{ open: false }" 
                            class="glassmorphism rounded-2xl overflow-hidden shadow-sm transition duration-300 border border-gray-100 dark:border-gray-800"
                        >
                            <button 
                                @click="open = !open" 
                                class="w-full px-6 py-5 flex items-center justify-between text-left focus:outline-none"
                            >
                                <span class="font-bold text-gray-900 dark:text-white text-sm sm:text-base">{{ $faq->question }}</span>
                                <span class="ml-4 text-amber-500 flex-shrink-0">
                                    <svg :class="{'rotate-180': open}" class="w-5 h-5 transform transition duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                                </span>
                            </button>

                            <div 
                                x-show="open" 
                                x-transition:enter="transition ease-out duration-200"
                                x-transition:enter-start="opacity-0 max-h-0"
                                x-transition:enter-end="opacity-100 max-h-40"
                                class="px-6 pb-5 text-sm text-gray-600 dark:text-gray-300 leading-relaxed border-t border-gray-50 dark:border-gray-900/50 pt-4"
                            >
                                <p>{{ $faq->answer }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @empty
            <div class="glassmorphism p-16 rounded-3xl text-center shadow-sm max-w-md mx-auto">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white">No FAQ Matches Found</h3>
                <p class="text-xs text-gray-500 dark:text-gray-400 mt-2">Try different search keywords or contact our team directly for custom queries.</p>
            </div>
        @endforelse
    </div>
</div>
