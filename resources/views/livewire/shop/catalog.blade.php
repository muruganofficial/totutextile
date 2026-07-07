<div class="grid grid-cols-1 lg:grid-cols-4 gap-12 font-inter">
    <!-- Left Sidebar: Premium Sticky Filter Card -->
    <div class="lg:col-span-1 space-y-6">
        <div class="glassmorphism p-8 rounded-3xl sticky top-28 shadow-sm border border-gray-100 dark:border-gray-850">
            <div class="flex items-center justify-between pb-5 border-b border-gray-100 dark:border-gray-800">
                <h3 class="font-bold text-base tracking-widest uppercase text-luxury-charcoal dark:text-white font-sans-action">Filter Options</h3>
                <button wire:click="resetFilters" class="text-[10px] font-bold uppercase tracking-wider text-luxury-gold hover:underline font-sans-action">Reset All</button>
            </div>

            <!-- Search -->
            <div class="mt-6 space-y-2">
                <label class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">Keyword Search</label>
                <input 
                    type="text" 
                    wire:model.live.debounce.300ms="search" 
                    placeholder="Search silks, shirts..." 
                    class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white"
                />
            </div>

            <!-- Categories -->
            <div class="mt-8 space-y-3" x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">
                    Collection Sectors
                    <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 transition transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" class="space-y-3.5 pt-2 max-h-48 overflow-y-auto pr-2">
                    @foreach($categories as $pCat)
                        <div class="space-y-1.5">
                            <button 
                                wire:click="selectParentCategory('{{ $pCat->id }}')"
                                class="w-full text-left text-xs font-bold flex items-center justify-between {{ $parent_category_id == $pCat->id ? 'text-luxury-gold' : 'text-luxury-charcoal dark:text-gray-300 hover:text-luxury-gold' }} transition"
                            >
                                {{ $pCat->name }}
                            </button>
                            @if($pCat->children->count() > 0)
                                <div class="pl-4 space-y-1">
                                    @foreach($pCat->children as $cCat)
                                        <button 
                                            wire:click="selectSubCategory('{{ $cCat->id }}')"
                                            class="w-full text-left text-[11px] font-medium flex items-center justify-between {{ $category_id == $cCat->id ? 'text-luxury-gold' : 'text-gray-400 dark:text-gray-500 hover:text-luxury-gold' }} transition"
                                        >
                                            {{ $cCat->name }}
                                        </button>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Fabric Type (Checkboxes / Radio Pills) -->
            <div class="mt-8 space-y-3" x-data="{ open: true }">
                <button @click="open = !open" class="w-full flex items-center justify-between text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">
                    Fabric Selection
                    <svg :class="{'rotate-180': open}" class="w-3.5 h-3.5 transition transform text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </button>
                <div x-show="open" class="space-y-2 pt-2">
                    @foreach($fabricTypes as $fType)
                        <label class="flex items-center text-xs text-gray-600 dark:text-gray-300 cursor-pointer hover:text-luxury-gold transition font-medium">
                            <input type="radio" name="fabric_type" wire:model.live="fabric_type" value="{{ $fType }}" class="rounded text-luxury-gold focus:ring-luxury-gold border-gray-300 mr-2.5">
                            {{ $fType }}
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Color Swatches (Visual Circles) -->
            <div class="mt-8 space-y-3">
                <label class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">Color Palette</label>
                <div class="flex flex-wrap gap-2.5 pt-2">
                    @php
                        $colorsMap = [
                            'Crimson Red' => ['bg-red-650 bg-red-600', 'Red'],
                            'Indigo Blue' => ['bg-indigo-650 bg-indigo-600', 'Blue'],
                            'Classic White' => ['bg-white border border-gray-200', 'White'],
                            'Olive Green' => ['bg-green-750 bg-emerald-700', 'Green'],
                            'Pastel Peach' => ['bg-orange-200', 'Peach']
                        ];
                    @endphp
                    @foreach($colorsMap as $cName => $cData)
                        <button 
                            wire:click="$set('color', '{{ $cName }}')"
                            title="{{ $cName }}"
                            class="w-6 h-6 rounded-full {{ $cData[0] }} focus:outline-none transition relative duration-300 {{ $color === $cName ? 'ring-2 ring-luxury-gold ring-offset-2' : 'hover:scale-110' }}"
                        ></button>
                    @endforeach
                </div>
            </div>

            <!-- Sizes (Chips) -->
            <div class="mt-8 space-y-3">
                <label class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">Available Sizes</label>
                <div class="flex flex-wrap gap-2 pt-2">
                    @php
                        $sizesList = ['S', 'M', 'L', 'XL', '38', '40', '42', '44'];
                    @endphp
                    @foreach($sizesList as $sOption)
                        <button 
                            wire:click="$set('size', '{{ $sOption }}')"
                            class="px-3.5 py-1.5 border rounded-lg text-[10px] font-bold tracking-wider uppercase transition duration-300 font-sans-action
                                {{ $size === $sOption ? 'border-luxury-gold bg-luxury-gold text-white shadow-sm' : 'border-gray-200 dark:border-gray-700 text-luxury-charcoal dark:text-gray-300 hover:border-luxury-gold' }}
                            "
                        >
                            {{ $sOption }}
                        </button>
                    @endforeach
                </div>
            </div>

            <!-- Price Slider / Fields -->
            <div class="mt-8 space-y-3">
                <label class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">Price Envelope</label>
                <div class="flex items-center gap-3 pt-1">
                    <input type="number" wire:model.live.debounce.500ms="min_price" placeholder="Min" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                    <span class="text-gray-400 text-xs">-</span>
                    <input type="number" wire:model.live.debounce.500ms="max_price" placeholder="Max" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                </div>
            </div>
        </div>
    </div>

    <!-- Right Side: Luxury Product Catalog Grid -->
    <div class="lg:col-span-3 space-y-8">
        <!-- Results Header Info -->
        <div class="glassmorphism p-6 rounded-3xl flex flex-wrap items-center justify-between gap-4 shadow-sm border border-gray-100 dark:border-gray-850">
            <div>
                <span class="text-xs font-semibold text-gray-400 tracking-wider">Curated Catalog:</span>
                <span class="text-xs font-black text-luxury-charcoal dark:text-white tracking-widest ml-1">{{ $products->total() }} Atelier Pieces</span>
            </div>
            <div class="flex items-center gap-3">
                <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400 font-sans-action">Sort Order</label>
                <select wire:model.live="sort_by" class="px-4 py-2 border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 rounded-xl text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold font-bold font-sans-action text-gray-800 dark:text-white">
                    <option value="newest">Newest Arrivals</option>
                    <option value="popular">Signature / Featured</option>
                    <option value="price_low">Price: Low to High</option>
                    <option value="price_high">Price: High to Low</option>
                </select>
            </div>
        </div>

        <!-- Skeleton Loading Loader -->
        <div wire:loading.delay class="w-full py-32 flex justify-center items-center">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-luxury-gold"></div>
        </div>

        <!-- Content Grid (4 columns desktop, 5 columns large displays) -->
        <div wire:loading.remove>
            @if($products->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-3 2xl:grid-cols-4 gap-8">
                    @foreach($products as $product)
                        <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-500 border border-gray-100 dark:border-gray-800 flex flex-col h-full overflow-hidden">
                            <!-- Image container with Zoom -->
                            <div class="relative aspect-[4/5] bg-luxury-stone dark:bg-gray-950 overflow-hidden">
                                <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-700" style="background-image: url('{{ $product->images->first()?->file_path ?? 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=500' }}')"></div>
                                <div class="absolute top-4 left-4 z-10 flex flex-col gap-1.5 font-sans-action">
                                    @if($product->is_featured)
                                        <span class="bg-luxury-gold/90 text-white text-[8px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded shadow">Featured</span>
                                    @endif
                                    @if($product->fabric_type)
                                        <span class="bg-luxury-charcoal/80 text-amber-300 text-[8px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded backdrop-blur-sm shadow">{{ $product->fabric_type }}</span>
                                    @endif
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="p-6 flex-grow flex flex-col justify-between space-y-4">
                                <div class="space-y-1">
                                    <span class="text-[9px] font-extrabold uppercase tracking-widest text-gray-400 font-sans-action">{{ $product->brand->name ?? 'Luxora' }}</span>
                                    <h3 class="text-base font-bold text-luxury-charcoal dark:text-white group-hover:text-luxury-gold transition duration-300 line-clamp-1">
                                        <a href="/product/{{ $product->slug }}" wire:navigate>{{ $product->name }}</a>
                                    </h3>
                                    <p class="text-xs text-gray-400 dark:text-gray-500 line-clamp-2 leading-relaxed font-light">{{ $product->description }}</p>
                                </div>
                                <div class="flex items-center justify-between pt-4 border-t border-gray-50 dark:border-gray-800">
                                    <div>
                                        <span class="text-[10px] text-gray-400 line-through">₹{{ number_format($product->selling_price * 1.2, 0) }}</span>
                                        <p class="text-base font-black text-luxury-gold">₹{{ number_format($product->selling_price, 2) }}</p>
                                    </div>
                                    <a href="/product/{{ $product->slug }}" wire:navigate class="p-3 bg-luxury-stone hover:bg-luxury-gold dark:bg-gray-800 dark:hover:bg-luxury-gold text-luxury-charcoal hover:text-white dark:text-luxury-gold rounded-xl transition-all duration-300">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Luxury Pagination -->
                <div class="mt-12 bg-white dark:bg-gray-900 p-4 rounded-2xl border border-gray-105 dark:border-gray-800 shadow-sm">
                    {{ $products->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="glassmorphism p-20 rounded-3xl text-center border border-gray-100 dark:border-gray-800 shadow-sm max-w-lg mx-auto">
                    <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                    <h3 class="text-lg font-bold text-luxury-charcoal dark:text-white">No Pieces Match Your Search</h3>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 max-w-xs mx-auto leading-relaxed">Adjust your fabric, color, or pricing limits, or click below to browse the entire signature archive.</p>
                    <button wire:click="resetFilters" class="mt-6 px-6 py-3 bg-luxury-gold hover:bg-amber-600 text-white text-xs font-bold uppercase tracking-widest rounded-xl transition font-sans-action">Reset Filters</button>
                </div>
            @endif
        </div>
    </div>
</div>
