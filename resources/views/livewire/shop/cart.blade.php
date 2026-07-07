<div class="space-y-12 font-inter">
    <h1 class="text-3xl sm:text-4xl font-bold tracking-tight text-luxury-charcoal dark:text-white font-serif-luxury">Atelier Cart & Checkout</h1>

    @if(empty($cart))
        <!-- Empty Cart State -->
        <div class="glassmorphism p-20 rounded-3xl text-center shadow-sm max-w-lg mx-auto border border-gray-100 dark:border-gray-800">
            <svg class="w-12 h-12 text-gray-300 dark:text-gray-600 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
            </svg>
            <h3 class="text-xl font-bold text-luxury-charcoal dark:text-white">Your Cart Bag is Empty</h3>
            <p class="text-xs text-gray-400 dark:text-gray-500 mt-2 max-w-xs mx-auto leading-relaxed">Add bespoke silks or Egyptian cotton garments from our catalogs to begin your checkout.</p>
            <a href="/shop" wire:navigate class="mt-8 inline-block px-8 py-3.5 bg-luxury-charcoal hover:bg-luxury-gold dark:bg-white dark:text-luxury-charcoal dark:hover:bg-luxury-gold dark:hover:text-white text-white text-xs font-bold uppercase tracking-widest rounded-xl transition duration-300 shadow font-sans-action">
                Return to Shop
            </a>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">
            
            <!-- Left: Cart items list & Shipping form details -->
            <div class="lg:col-span-2 space-y-10">
                
                <!-- Items list -->
                <div class="glassmorphism p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-850 space-y-6">
                    <h2 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Selected Items</h2>
                    <div class="divide-y divide-gray-100 dark:divide-gray-800">
                        @foreach($cart as $key => $item)
                            <div class="py-5 flex flex-col sm:flex-row items-start sm:items-center gap-6 justify-between">
                                <div class="flex items-center gap-4">
                                    <div class="w-16 h-20 bg-luxury-stone dark:bg-gray-950 rounded-xl overflow-hidden flex-shrink-0 flex items-center justify-center text-[10px] font-bold text-luxury-gold border border-gray-150 dark:border-gray-800">
                                        LUX
                                    </div>
                                    <div>
                                        <h3 class="text-sm font-bold text-luxury-charcoal dark:text-white">{{ $item['name'] }}</h3>
                                        <p class="text-[11px] text-gray-450 dark:text-gray-500 mt-1">Color: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $item['color'] }}</span> | Size: <span class="font-bold text-gray-700 dark:text-gray-300">{{ $item['size'] }}</span></p>
                                    </div>
                                </div>
                                <div class="flex items-center justify-between sm:justify-end gap-6 w-full sm:w-auto">
                                    <!-- Quantity selector -->
                                    <div class="flex items-center border border-gray-200 dark:border-gray-750 rounded-xl overflow-hidden bg-gray-50 dark:bg-gray-900/50">
                                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] - 1 }})" class="px-3 py-1.5 text-gray-400 font-bold focus:outline-none">-</button>
                                        <span class="px-2 text-xs font-bold text-luxury-charcoal dark:text-white">{{ $item['quantity'] }}</span>
                                        <button wire:click="updateQuantity('{{ $key }}', {{ $item['quantity'] + 1 }})" class="px-3 py-1.5 text-gray-400 font-bold focus:outline-none">+</button>
                                    </div>
                                    <!-- Price -->
                                    <span class="text-sm font-black text-luxury-gold w-24 text-right">₹{{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                                    <!-- Remove -->
                                    <button wire:click="removeFromCart('{{ $key }}')" class="text-rose-500 hover:text-rose-600 transition">
                                        <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Shipping Form -->
                <div class="glassmorphism p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-850 space-y-6">
                    <h2 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Shipping Destination</h2>
                    
                    @guest
                        <div class="p-6 bg-luxury-stone/50 dark:bg-gray-900/50 border border-gray-100 dark:border-gray-800 rounded-2xl text-center space-y-3">
                            <p class="text-xs text-gray-550 dark:text-gray-450 tracking-wider">Atelier login is required to complete purchases.</p>
                            <a href="/login" wire:navigate class="px-5 py-2.5 bg-luxury-charcoal hover:bg-luxury-gold text-white text-[10px] font-bold uppercase tracking-widest rounded-xl transition font-sans-action inline-block">Log In</a>
                        </div>
                    @else
                        <!-- Form grid -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <div class="sm:col-span-2">
                                <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Street Address</label>
                                <input type="text" wire:model.blur="address_line1" placeholder="Atelier building, floor, street details" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                                @error('address_line1') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">City</label>
                                <input type="text" wire:model.blur="city" placeholder="City" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                                @error('city') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">State</label>
                                <input type="text" wire:model.blur="state" placeholder="State" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                                @error('state') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Postal Code (PIN)</label>
                                <input type="text" wire:model.blur="postal_code" placeholder="6-digit ZIP code" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                                @error('postal_code') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                            </div>
                            <div class="sm:col-span-2">
                                <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Delivery instructions</label>
                                <textarea wire:model.blur="notes" rows="3" placeholder="Optional notes for our courier partner..." class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white"></textarea>
                            </div>
                        </div>
                    @endguest
                </div>

                <!-- Payment Option cards -->
                @auth
                    <div class="glassmorphism p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-850 space-y-6">
                        <h2 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Select Payment Option</h2>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Wallet -->
                            <button 
                                type="button"
                                wire:click="$set('paymentMethod', 'Wallet')"
                                class="p-6 border rounded-2xl text-left flex items-start gap-4 transition duration-300 {{ $paymentMethod === 'Wallet' ? 'border-luxury-gold bg-luxury-stone/50 dark:bg-gray-850/30' : 'border-gray-200 dark:border-gray-800 hover:border-gray-300' }}"
                            >
                                <div class="mt-1 text-luxury-gold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-luxury-charcoal dark:text-white">Pay via Wallet credit</h4>
                                    <p class="text-[10px] text-gray-450 dark:text-gray-550 mt-1">Atelier Balance: <span class="font-extrabold text-luxury-gold">₹{{ number_format($walletBalance, 2) }}</span></p>
                                </div>
                            </button>

                            <!-- COD -->
                            <button 
                                type="button"
                                wire:click="$set('paymentMethod', 'COD')"
                                class="p-6 border rounded-2xl text-left flex items-start gap-4 transition duration-300 {{ $paymentMethod === 'COD' ? 'border-luxury-gold bg-luxury-stone/50 dark:bg-gray-850/30' : 'border-gray-200 dark:border-gray-800 hover:border-gray-300' }}"
                            >
                                <div class="mt-1 text-luxury-gold">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                </div>
                                <div>
                                    <h4 class="text-xs font-bold uppercase tracking-wider text-luxury-charcoal dark:text-white">Cash on Delivery (COD)</h4>
                                    <p class="text-[10px] text-gray-450 dark:text-gray-550 mt-1">Pay with cash upon physical shipment receipt.</p>
                                </div>
                            </button>
                        </div>
                    </div>
                @endauth

            </div>

            <!-- Right: Luxury Order Summary sticky card -->
            <div class="lg:col-span-1">
                <div class="glassmorphism p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-855 sticky top-28 space-y-6">
                    <h2 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Order Summary</h2>
                    
                    <!-- Coupon code -->
                    <div class="space-y-2">
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Coupon discount</label>
                        <div class="flex gap-2">
                            <input type="text" wire:model="couponCode" placeholder="Code (e.g. WELCOME)" class="w-full px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold uppercase text-gray-800 dark:text-white">
                            <button type="button" wire:click="applyCoupon" class="px-4 py-2 bg-luxury-charcoal hover:bg-luxury-gold text-white dark:bg-gray-800 dark:hover:bg-luxury-gold text-xs font-bold uppercase tracking-wider rounded-xl transition duration-300 font-sans-action">Apply</button>
                        </div>
                        @if($couponMessage)
                            <p class="text-[10px] font-bold uppercase tracking-wider mt-1.5 {{ $appliedCoupon ? 'text-emerald-500' : 'text-rose-500' }}">{{ $couponMessage }}</p>
                        @endif
                    </div>

                    <!-- Details breakdown -->
                    <div class="space-y-4 pt-6 border-t border-gray-100 dark:border-gray-800 text-xs font-medium tracking-wide">
                        <div class="flex justify-between">
                            <span class="text-gray-400">Items Subtotal</span>
                            <span class="font-extrabold text-luxury-charcoal dark:text-white">₹{{ number_format($subtotal, 2) }}</span>
                        </div>
                        @if($discount > 0)
                            <div class="flex justify-between text-emerald-500">
                                <span>Atelier Discount</span>
                                <span>-₹{{ number_format($discount, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-400">Estimated GST Tax</span>
                            <span class="font-extrabold text-luxury-charcoal dark:text-white">₹{{ number_format($tax, 2) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-400">Atelier Courier shipping</span>
                            <span class="font-extrabold text-luxury-charcoal dark:text-white">{{ $shipping > 0 ? '₹' . number_format($shipping, 2) : 'Free' }}</span>
                        </div>
                        <div class="flex justify-between text-base font-extrabold pt-6 border-t border-gray-100 dark:border-gray-800">
                            <span class="text-luxury-charcoal dark:text-white">Total Amount</span>
                            <span class="text-luxury-gold font-black">₹{{ number_format($total, 2) }}</span>
                        </div>
                    </div>

                    <!-- checkout trigger -->
                    @auth
                        <button 
                            type="button"
                            wire:click="placeOrder"
                            class="w-full px-6 py-4 bg-luxury-gold hover:bg-amber-600 text-white font-extrabold rounded-xl text-xs uppercase tracking-widest shadow transition duration-300 font-sans-action"
                        >
                            Place Order (₹{{ number_format($total, 2) }})
                        </button>
                    @else
                        <a 
                            href="/login"
                            wire:navigate
                            class="w-full text-center inline-block px-6 py-4 bg-gray-200 dark:bg-gray-800 text-gray-450 dark:text-gray-500 font-extrabold rounded-xl text-xs uppercase tracking-widest pointer-events-none font-sans-action"
                        >
                            Log In to Checkout
                        </a>
                    @endauth
                </div>
            </div>

        </div>
    @endif
</div>
