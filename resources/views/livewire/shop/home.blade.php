<div class="space-y-24">
    <!-- Luxury Lifestyle Hero Section (Sliding left Carousel) -->
    <div x-data="{ activeSlide: 0, slidesCount: 2 }" 
         x-init="setInterval(() => { activeSlide = (activeSlide + 1) % slidesCount }, 6000)" 
         class="relative rounded-3xl overflow-hidden min-h-[600px] border border-gray-800 shadow-2xl bg-black group"
    >
        <!-- Slides Track (200% width, side-by-side flex layout) -->
        <div class="flex w-[200%] h-full transition-transform duration-[1000ms] ease-in-out" 
             :style="'transform: translateX(-' + (activeSlide * 50) + '%)'">
            
            <!-- Slide 1 -->
            <div class="w-1/2 min-h-[600px] relative flex flex-col justify-center px-12 md:px-24 py-32 text-white bg-cover bg-center" style="background-image: linear-gradient(to right, rgba(0,0,0,0.85) 40%, rgba(0,0,0,0.3) 100%), url('https://images.unsplash.com/photo-1618221195710-dd6b41faaea6?q=80&w=1200');">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(200,155,60,0.15),transparent_50%)]"></div>
                <div class="relative z-10 max-w-2xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-3 py-1 bg-luxury-gold/10 border border-luxury-gold/25 rounded-full text-luxury-gold text-[10px] font-bold uppercase tracking-[0.25em] font-sans-action">
                        Haute Couture Drop 2026
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-bold tracking-tight leading-[1.1] font-serif-luxury">
                        Heritage Woven <br/>
                        <span class="bg-gradient-to-r from-amber-200 via-[#C89B3C] to-yellow-100 bg-clip-text text-transparent italic">With Passion</span>
                    </h1>
                    <p class="text-gray-300 text-sm md:text-base font-light tracking-wide leading-relaxed">
                        Experience the weight of pure Banarasi gold zari and the unmatched breathability of double-warp Egyptian cotton. Crafted for those who appreciate design integrity.
                    </p>
                    <div class="pt-6 flex flex-wrap gap-5">
                        <a href="/shop" class="px-8 py-4 bg-luxury-gold hover:bg-amber-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-luxury-gold/15 transition duration-300 transform hover:-translate-y-0.5 font-sans-action">
                            Explore Atelier
                        </a>
                        <a href="/shop?collection=Wedding+Collection" class="px-8 py-4 border border-white/10 hover:border-white/40 bg-white/5 hover:bg-white/10 backdrop-blur-md rounded-xl text-xs font-bold uppercase tracking-widest transition duration-305 font-sans-action font-bold">
                            Bridal Lookbook
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="w-1/2 min-h-[600px] relative flex flex-col justify-center px-12 md:px-24 py-32 text-white bg-cover bg-center" style="background-image: linear-gradient(to right, rgba(0,0,0,0.85) 40%, rgba(0,0,0,0.3) 100%), url('https://images.unsplash.com/photo-1490481651871-ab68de25d43d?q=80&w=1200');">
                <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(200,155,60,0.15),transparent_50%)]"></div>
                <div class="relative z-10 max-w-2xl space-y-6">
                    <div class="inline-flex items-center gap-2.5 px-3 py-1 bg-luxury-gold/10 border border-luxury-gold/25 rounded-full text-luxury-gold text-[10px] font-bold uppercase tracking-[0.25em] font-sans-action">
                        Atelier Collection 2026
                    </div>
                    <h1 class="text-4xl sm:text-6xl md:text-7xl font-bold tracking-tight leading-[1.1] font-serif-luxury">
                        Bespoke Styling <br/>
                        <span class="bg-gradient-to-r from-amber-200 via-[#C89B3C] to-yellow-100 bg-clip-text text-transparent italic">& Silk Drapes</span>
                    </h1>
                    <p class="text-gray-300 text-sm md:text-base font-light tracking-wide leading-relaxed">
                        Discover our ready-to-wear linen collections, handcrafted raw silk lehengas, and tailored Italian twill shirts made to measure by master tailors.
                    </p>
                    <div class="pt-6 flex flex-wrap gap-5">
                        <a href="/shop" class="px-8 py-4 bg-luxury-gold hover:bg-amber-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest shadow-lg shadow-luxury-gold/15 transition duration-300 transform hover:-translate-y-0.5 font-sans-action">
                            View Collection
                        </a>
                        <a href="/shop?collection=Summer+Collection" class="px-8 py-4 border border-white/10 hover:border-white/40 bg-white/5 hover:bg-white/10 backdrop-blur-md rounded-xl text-xs font-bold uppercase tracking-widest transition duration-305 font-sans-action font-bold">
                            Summer Gazette
                        </a>
                    </div>
                </div>
            </div>

        </div>

        <!-- Carousel Indicators (Dots) -->
        <div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2.5">
            <button @click="activeSlide = 0" class="w-2.5 h-2.5 rounded-full transition-all duration-300" :class="activeSlide === 0 ? 'bg-luxury-gold w-6' : 'bg-white/40 hover:bg-white/80'"></button>
            <button @click="activeSlide = 1" class="w-2.5 h-2.5 rounded-full transition-all duration-300" :class="activeSlide === 1 ? 'bg-luxury-gold w-6' : 'bg-white/40 hover:bg-white/80'"></button>
        </div>

        <!-- Left/Right Arrows (Visible on Hover) -->
        <button @click="activeSlide = (activeSlide - 1 + slidesCount) % slidesCount" class="absolute left-6 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-black/30 hover:bg-black/60 border border-white/10 text-white opacity-0 group-hover:opacity-100 transition duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>
        <button @click="activeSlide = (activeSlide + 1) % slidesCount" class="absolute right-6 top-1/2 -translate-y-1/2 z-20 p-3 rounded-full bg-black/30 hover:bg-black/60 border border-white/10 text-white opacity-0 group-hover:opacity-100 transition duration-300">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7-7"></path></svg>
        </button>
    </div>

    <!-- Category Showcase Cards (Large Images, Hover Zoom, Animated Overlay) -->
    <div class="space-y-8">
        <div class="text-center max-w-lg mx-auto space-y-2">
            <span class="text-xs uppercase font-extrabold tracking-[0.2em] text-luxury-gold font-sans-action">Curated Masterpieces</span>
            <h2 class="text-3xl font-extrabold tracking-tight text-luxury-charcoal dark:text-white">Shop By Atelier Collections</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Ethnic Wear -->
            <a href="/shop?parent_category_id=1" class="relative rounded-3xl overflow-hidden h-96 group shadow-lg border border-gray-100 dark:border-gray-800 flex flex-col justify-end p-8">
                <div class="absolute inset-0 bg-gradient-to-t from-luxury-charcoal/90 via-luxury-charcoal/20 to-transparent z-10"></div>
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=800')] bg-cover bg-center group-hover:scale-105 transition duration-700"></div>
                <div class="relative z-20 space-y-1 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                    <span class="text-[9px] font-extrabold uppercase tracking-[0.3em] text-luxury-gold font-sans-action">Silk & Lehengas</span>
                    <h3 class="text-2xl font-bold text-white">Traditional Ethnic</h3>
                </div>
            </a>
            <!-- Western Wear -->
            <a href="/shop?parent_category_id=2" class="relative rounded-3xl overflow-hidden h-96 group shadow-lg border border-gray-100 dark:border-gray-800 flex flex-col justify-end p-8">
                <div class="absolute inset-0 bg-gradient-to-t from-luxury-charcoal/90 via-luxury-charcoal/20 to-transparent z-10"></div>
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=800')] bg-cover bg-center group-hover:scale-105 transition duration-700"></div>
                <div class="relative z-20 space-y-1 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                    <span class="text-[9px] font-extrabold uppercase tracking-[0.3em] text-luxury-gold font-sans-action">Linen & Egyptian Cottons</span>
                    <h3 class="text-2xl font-bold text-white">Refined Western</h3>
                </div>
            </a>
            <!-- Kids Wear -->
            <a href="/shop?parent_category_id=3" class="relative rounded-3xl overflow-hidden h-96 group shadow-lg border border-gray-100 dark:border-gray-800 flex flex-col justify-end p-8">
                <div class="absolute inset-0 bg-gradient-to-t from-luxury-charcoal/90 via-luxury-charcoal/20 to-transparent z-10"></div>
                <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1519457431-44ccd64a579b?q=80&w=800')] bg-cover bg-center group-hover:scale-105 transition duration-700"></div>
                <div class="relative z-20 space-y-1 transform translate-y-2 group-hover:translate-y-0 transition duration-500">
                    <span class="text-[9px] font-extrabold uppercase tracking-[0.3em] text-luxury-gold font-sans-action">Organic Soft Linens</span>
                    <h3 class="text-2xl font-bold text-white">Soft Children Wear</h3>
                </div>
            </a>
        </div>
    </div>

    <!-- Product Grid (4 Columns Desktop, 5 Columns Large Screens) -->
    <div class="space-y-8">
        <div class="flex items-end justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
            <div class="space-y-1">
                <span class="text-xs uppercase font-extrabold tracking-[0.2em] text-luxury-gold font-sans-action">Signature Drops</span>
                <h2 class="text-3xl font-extrabold tracking-tight text-luxury-charcoal dark:text-white">Featured Atelier Garments</h2>
            </div>
            <a href="/shop" class="text-xs font-bold uppercase tracking-widest text-luxury-gold hover:text-luxury-charcoal dark:hover:text-white transition duration-300 flex items-center gap-1 font-sans-action">
                View Shop
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7-7"></path></svg>
            </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 xl:grid-cols-4 2xl:grid-cols-5 gap-8">
            @foreach($featuredProducts as $product)
                <div class="group bg-white dark:bg-gray-900 rounded-2xl shadow-sm hover:shadow-lg transition-all duration-500 border border-gray-100 dark:border-gray-800 flex flex-col h-full overflow-hidden">
                    <!-- Image Showcase with Zoom -->
                    <div class="relative aspect-[4/5] bg-luxury-stone dark:bg-gray-950 overflow-hidden">
                        <div class="absolute inset-0 bg-cover bg-center group-hover:scale-105 transition-transform duration-700" style="background-image: url('{{ $product->images->first()?->file_path ?? 'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=500' }}')"></div>
                        
                        <!-- Top Badges -->
                        <div class="absolute top-4 left-4 z-10 flex flex-col gap-1.5 font-sans-action">
                            @if($product->is_featured)
                                <span class="bg-luxury-gold/90 text-white text-[8px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded shadow">Featured</span>
                            @endif
                            @if($product->fabric_type)
                                <span class="bg-luxury-charcoal/80 text-amber-300 text-[8px] font-extrabold uppercase tracking-widest px-2.5 py-1 rounded backdrop-blur-sm">{{ $product->fabric_type }}</span>
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
    </div>

    <!-- Editorial Testimonials -->
    <div class="py-20 bg-luxury-stone/50 dark:bg-gray-900/20 rounded-3xl border border-gray-100 dark:border-gray-800 px-8 sm:px-16 flex flex-col items-center space-y-12">
        <div class="text-center space-y-2">
            <span class="text-xs uppercase font-extrabold tracking-[0.2em] text-luxury-gold font-sans-action">Elite Reviews</span>
            <h2 class="text-3xl font-extrabold tracking-tight text-luxury-charcoal dark:text-white">Voices of the Atelier</h2>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12 w-full">
            @foreach($testimonials as $t)
                <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-50 dark:border-gray-800 shadow-sm flex flex-col justify-between space-y-6">
                    <div class="space-y-4">
                        <div class="flex gap-1 text-luxury-gold">
                            @for($i=0; $i<$t->rating; $i++)
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                            @endfor
                        </div>
                        <p class="text-xs text-gray-500 dark:text-gray-300 italic leading-relaxed">"{{ $t->review }}"</p>
                    </div>
                    <div class="flex items-center gap-3 pt-4 border-t border-gray-50 dark:border-gray-800 font-sans-action">
                        <div class="w-8 h-8 rounded-full bg-luxury-gold flex items-center justify-center text-white font-bold text-xs">{{ substr($t->client_name, 0, 1) }}</div>
                        <div>
                            <h4 class="text-xs font-bold text-luxury-charcoal dark:text-white">{{ $t->client_name }}</h4>
                            <p class="text-[10px] text-gray-400 uppercase tracking-wider">{{ $t->role }}, {{ $t->company }}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
