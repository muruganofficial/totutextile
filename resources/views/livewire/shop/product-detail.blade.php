<div class="space-y-16 font-inter">
    <!-- Main Showcase Columns -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
        
        <!-- Left: Luxury Gallery -->
        <div class="space-y-6">
            <div class="relative bg-luxury-stone dark:bg-gray-950 rounded-3xl overflow-hidden aspect-[4/5] shadow-sm border border-gray-100 dark:border-gray-800">
                <div class="absolute inset-0 bg-cover bg-center" style="background-image: url('{{ $product->images->first()?->file_path ?? 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=800' }}')"></div>
                <div class="absolute top-6 left-6 z-10">
                    <span class="bg-luxury-charcoal/80 text-luxury-gold text-[10px] font-extrabold uppercase tracking-[0.2em] px-4 py-1.5 rounded-lg backdrop-blur-md shadow">
                        {{ $product->fabric_type ?? 'Haute Couture' }}
                    </span>
                </div>
            </div>

            <!-- Thumbnails grid -->
            <div class="grid grid-cols-4 gap-4">
                @foreach($product->images as $img)
                    <div class="bg-white dark:bg-gray-900 aspect-square rounded-2xl border border-gray-200 dark:border-gray-800 overflow-hidden cursor-pointer hover:border-luxury-gold transition duration-300 flex items-center justify-center text-xs font-bold text-gray-400">
                        LUX
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Right: Sticky Product Info & Purchase Panel -->
        <div class="space-y-8">
            <div class="space-y-2">
                <span class="text-xs uppercase font-extrabold tracking-[0.25em] text-luxury-gold font-sans-action">{{ $product->brand->name ?? 'Luxora Atelier' }}</span>
                <h1 class="text-3xl sm:text-4xl md:text-5xl font-bold tracking-tight text-luxury-charcoal dark:text-white leading-[1.1] font-serif-luxury">{{ $product->name }}</h1>
                <p class="text-[10px] font-bold text-gray-400 tracking-wider">REF: {{ $product->sku }} | Barcode: {{ $product->barcode }}</p>
            </div>

            <!-- Price Card -->
            <div class="p-8 bg-luxury-stone/50 dark:bg-gray-900/50 rounded-3xl border border-gray-100 dark:border-gray-800">
                <div class="flex items-baseline gap-3">
                    <span class="text-3xl font-black text-luxury-gold">₹{{ number_format($product->selling_price, 2) }}</span>
                    <span class="text-sm text-gray-400 line-through">₹{{ number_format($product->selling_price * 1.2, 0) }}</span>
                </div>
                <p class="text-[10px] text-gray-400 mt-2.5 font-bold uppercase tracking-wider">Inclusive of local taxes. Calculated at {{ $product->gst_rate }}% GST rate.</p>
            </div>

            <!-- Summary -->
            <p class="text-sm text-gray-500 dark:text-gray-400 leading-relaxed font-light">{{ $product->description }}</p>

            <!-- Attributes Selectors -->
            <div class="space-y-6 pt-6 border-t border-gray-100 dark:border-gray-800">
                <!-- Color Selector -->
                @if($product->attributes['color'] ?? null)
                    <div class="space-y-3">
                        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">Color Option: <span class="text-luxury-charcoal dark:text-white font-black">{{ $selectedColor }}</span></span>
                        <div class="flex gap-2">
                            <button 
                                wire:click="$set('selectedColor', '{{ $product->attributes['color'] }}')"
                                class="px-4 py-2 border rounded-xl text-xs font-bold font-sans-action {{ $selectedColor === $product->attributes['color'] ? 'border-luxury-gold bg-luxury-stone text-luxury-gold' : 'border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300' }}"
                            >
                                {{ $product->attributes['color'] }}
                            </button>
                        </div>
                    </div>
                @endif

                <!-- Size Selector -->
                @if(is_array($product->attributes['sizes'] ?? null))
                    <div class="space-y-3">
                        <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">Select Garment Size</span>
                        <div class="flex flex-wrap gap-2.5">
                            @foreach($product->attributes['sizes'] as $size)
                                <button 
                                    wire:click="$set('selectedSize', '{{ $size }}')"
                                    class="px-4.5 py-2 border rounded-xl text-xs font-bold font-sans-action transition duration-300 {{ $selectedSize === $size ? 'border-luxury-gold bg-luxury-gold text-white shadow-sm' : 'border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-300 hover:border-luxury-gold' }}"
                                >
                                    {{ $size }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Quantity Selector -->
                <div class="space-y-3">
                    <span class="text-[10px] font-extrabold uppercase tracking-[0.2em] text-gray-400 font-sans-action">Quantity</span>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center border border-gray-200 dark:border-gray-700 rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-900/50">
                            <button wire:click="decrementQuantity" class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 font-bold focus:outline-none">-</button>
                            <span class="px-4 py-2 text-xs font-bold text-luxury-charcoal dark:text-white">{{ $quantity }}</span>
                            <button wire:click="incrementQuantity" class="px-4 py-3 hover:bg-gray-100 dark:hover:bg-gray-800 text-gray-500 font-bold focus:outline-none">+</button>
                        </div>
                        <span class="text-[11px] text-emerald-500 font-bold uppercase tracking-wider">Ready to Dispatch</span>
                    </div>
                </div>
            </div>

            <!-- Add to Cart CTA -->
            <div class="pt-4">
                <button 
                    wire:click="addToCart"
                    class="w-full px-8 py-4 bg-luxury-charcoal hover:bg-luxury-gold text-white dark:bg-white dark:text-luxury-charcoal dark:hover:bg-luxury-gold dark:hover:text-white font-extrabold rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-black/10 transition duration-300 transform hover:-translate-y-0.5 flex items-center justify-center gap-2 font-sans-action"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    Add to Cart bag
                </button>
            </div>

        </div>
    </div>

    <!-- Atelier Details Accordions -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 pt-16 border-t border-gray-100 dark:border-gray-800">
        
        <!-- Accordion Item 1: Fabric details -->
        <details class="group md:col-span-1 border border-gray-150 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm" open>
            <summary class="flex justify-between items-center font-bold text-xs uppercase tracking-[0.2em] text-gray-400 p-5 bg-white dark:bg-gray-900 cursor-pointer list-none focus:outline-none">
                Atelier Specifications
                <span class="transition group-open:rotate-180 text-luxury-gold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </span>
            </summary>
            <div class="p-6 bg-white dark:bg-gray-900 border-t border-gray-50 dark:border-gray-800 space-y-4">
                <dl class="divide-y divide-gray-100 dark:divide-gray-800 text-xs">
                    <div class="py-2.5 grid grid-cols-2">
                        <dt class="font-semibold text-gray-400">Fabric Type</dt>
                        <dd class="font-extrabold text-luxury-charcoal dark:text-white text-right">{{ $product->fabric_type ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-2.5 grid grid-cols-2">
                        <dt class="font-semibold text-gray-400">Material</dt>
                        <dd class="font-extrabold text-luxury-charcoal dark:text-white text-right">{{ $product->attributes['material'] ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-2.5 grid grid-cols-2">
                        <dt class="font-semibold text-gray-400">Pattern</dt>
                        <dd class="font-extrabold text-luxury-charcoal dark:text-white text-right">{{ $product->attributes['pattern'] ?? 'N/A' }}</dd>
                    </div>
                    <div class="py-2.5 grid grid-cols-2">
                        <dt class="font-semibold text-gray-400">Occasion</dt>
                        <dd class="font-extrabold text-luxury-charcoal dark:text-white text-right">{{ $product->attributes['occasion'] ?? 'N/A' }}</dd>
                    </div>
                </dl>
            </div>
        </details>

        <!-- Accordion Item 2: Care instructions -->
        <details class="group md:col-span-1 border border-gray-150 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm" open>
            <summary class="flex justify-between items-center font-bold text-xs uppercase tracking-[0.2em] text-gray-400 p-5 bg-white dark:bg-gray-900 cursor-pointer list-none focus:outline-none">
                Care instructions
                <span class="transition group-open:rotate-180 text-luxury-gold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </span>
            </summary>
            <div class="p-6 bg-white dark:bg-gray-900 border-t border-gray-50 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 leading-relaxed font-light">
                <p>{{ $product->care_instructions ?? 'Handle with extreme care. Dry cleaning is highly recommended to preserve the fiber structure and gold zari warp.' }}</p>
            </div>
        </details>

        <!-- Accordion Item 3: Shipping policy -->
        <details class="group md:col-span-1 border border-gray-150 dark:border-gray-800 rounded-2xl overflow-hidden shadow-sm" open>
            <summary class="flex justify-between items-center font-bold text-xs uppercase tracking-[0.2em] text-gray-400 p-5 bg-white dark:bg-gray-900 cursor-pointer list-none focus:outline-none">
                Complimentary Shipping
                <span class="transition group-open:rotate-180 text-luxury-gold">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"></path></svg>
                </span>
            </summary>
            <div class="p-6 bg-white dark:bg-gray-900 border-t border-gray-50 dark:border-gray-800 text-xs text-gray-500 dark:text-gray-400 leading-relaxed font-light">
                <p>Enjoy complimentary shipping on all orders exceeding ₹2000. All signature garments are packaged in luxury custom boxes and dispatched within 48 business hours.</p>
            </div>
        </details>

    </div>
</div>
