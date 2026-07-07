<div class="grid grid-cols-1 lg:grid-cols-4 gap-12 font-inter">
    
    <!-- Left Sidebar Menu (320px Floating Card) -->
    <div class="lg:col-span-1 space-y-6">
        <div class="glassmorphism p-8 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-850 space-y-8">
            
            <!-- User Info Snapshot -->
            <div class="flex flex-col items-center text-center space-y-3.5 pb-6 border-b border-gray-100 dark:border-gray-800">
                <div class="w-16 h-16 rounded-full bg-luxury-gold flex items-center justify-center text-white font-extrabold text-xl shadow-lg border-2 border-white dark:border-gray-800">
                    {{ substr(auth()->user()->name, 0, 1) }}
                </div>
                <div>
                    <h3 class="font-bold text-base text-luxury-charcoal dark:text-white">{{ auth()->user()->name }}</h3>
                    <p class="text-xs text-gray-400 mt-0.5">{{ auth()->user()->email }}</p>
                </div>
                <!-- VIP Badge -->
                @if(auth()->user()->profile->is_vip ?? false)
                    <span class="inline-block px-3 py-1 bg-luxury-gold/10 border border-luxury-gold/30 rounded-full text-luxury-gold text-[9px] font-black uppercase tracking-widest font-sans-action">VIP Customer</span>
                @else
                    <span class="inline-block px-3 py-1 bg-luxury-stone dark:bg-gray-800 rounded-full text-gray-500 dark:text-gray-400 text-[9px] font-bold uppercase tracking-widest font-sans-action">Regular Member</span>
                @endif
            </div>

            <!-- Navigation Links -->
            <nav class="flex flex-col gap-1.5 text-xs font-bold uppercase tracking-wider font-sans-action">
                <button 
                    wire:click="$set('activeTab', 'dashboard')" 
                    class="w-full text-left px-5 py-3 rounded-xl flex items-center gap-3.5 transition duration-300
                        {{ $activeTab === 'dashboard' ? 'bg-luxury-gold text-white shadow-md' : 'text-gray-500 dark:text-gray-450 hover:bg-luxury-stone hover:text-luxury-gold' }}
                    "
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    Dashboard
                </button>

                <button 
                    wire:click="$set('activeTab', 'profile')" 
                    class="w-full text-left px-5 py-3 rounded-xl flex items-center gap-3.5 transition duration-300
                        {{ $activeTab === 'profile' ? 'bg-luxury-gold text-white shadow-md' : 'text-gray-500 dark:text-gray-450 hover:bg-luxury-stone hover:text-luxury-gold' }}
                    "
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    Profile Details
                </button>

                <button 
                    wire:click="$set('activeTab', 'orders')" 
                    class="w-full text-left px-5 py-3 rounded-xl flex items-center gap-3.5 transition duration-300
                        {{ $activeTab === 'orders' ? 'bg-luxury-gold text-white shadow-md' : 'text-gray-500 dark:text-gray-450 hover:bg-luxury-stone hover:text-luxury-gold' }}
                    "
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                    My Orders
                </button>

                <button 
                    wire:click="$set('activeTab', 'notifications')" 
                    class="w-full text-left px-5 py-3 rounded-xl flex items-center gap-3.5 transition duration-300
                        {{ $activeTab === 'notifications' ? 'bg-luxury-gold text-white shadow-md' : 'text-gray-500 dark:text-gray-450 hover:bg-luxury-stone hover:text-luxury-gold' }}
                    "
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                    Notifications
                </button>

                <button 
                    wire:click="$set('activeTab', 'settings')" 
                    class="w-full text-left px-5 py-3 rounded-xl flex items-center gap-3.5 transition duration-300
                        {{ $activeTab === 'settings' ? 'bg-luxury-gold text-white shadow-md' : 'text-gray-500 dark:text-gray-450 hover:bg-luxury-stone hover:text-luxury-gold' }}
                    "
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    Security Settings
                </button>

                <div class="border-t border-gray-100 dark:border-gray-800 my-2"></div>
                <form method="POST" action="{{ route('logout') }}" class="w-full">
                    @csrf
                    <button type="submit" class="w-full text-left px-5 py-3 rounded-xl text-rose-500 hover:bg-rose-50 dark:hover:bg-rose-950/20 transition duration-300 flex items-center gap-3.5 font-sans-action">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                        Log Out
                    </button>
                </form>
            </nav>
        </div>
    </div>

    <!-- Right Content Frame -->
    <div class="lg:col-span-3 space-y-8">
        
        <!-- Tab 1: Dashboard Overview -->
        @if($activeTab === 'dashboard')
            <div class="space-y-8">
                <!-- Summary Metrics (Wallet, Loyalty) -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <!-- Wallet Balance Card -->
                    <div class="glassmorphism p-8 rounded-3xl border border-gray-100 dark:border-gray-850 shadow-sm flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Atelier Wallet Balance</span>
                            <p class="text-3xl font-black text-luxury-gold">₹{{ number_format($walletBalance, 2) }}</p>
                        </div>
                        <div class="p-4 bg-luxury-stone dark:bg-gray-800 text-luxury-gold rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                    </div>

                    <!-- Loyalty points Card -->
                    <div class="glassmorphism p-8 rounded-3xl border border-gray-100 dark:border-gray-850 shadow-sm flex items-center justify-between">
                        <div class="space-y-1">
                            <span class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Loyalty Rewards accrued</span>
                            <p class="text-3xl font-black text-luxury-gold">{{ $loyaltyPoints }} Pts</p>
                        </div>
                        <div class="p-4 bg-luxury-stone dark:bg-gray-800 text-luxury-gold rounded-2xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Saved Addresses -->
                <div class="glassmorphism p-8 rounded-3xl border border-gray-100 dark:border-gray-850 shadow-sm space-y-6">
                    <h3 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Saved Addresses</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @forelse($addresses as $addr)
                            <div class="p-6 bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 rounded-2xl relative shadow-sm">
                                <span class="absolute top-4 right-4 bg-luxury-stone dark:bg-gray-800 text-luxury-charcoal dark:text-gray-300 text-[8px] font-extrabold uppercase tracking-widest px-2 py-0.5 rounded">
                                    {{ $addr->label }}
                                </span>
                                <p class="text-xs text-gray-655 dark:text-gray-300 leading-relaxed font-light pt-2">
                                    {{ $addr->address_line1 }}<br/>
                                    {{ $addr->city }}, {{ $addr->state }} - <span class="font-bold">{{ $addr->postal_code }}</span>
                                </p>
                            </div>
                        @empty
                            <p class="text-xs text-gray-400 dark:text-gray-500 italic">No delivery destinations saved yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        @endif

        <!-- Tab 2: Profile Details -->
        @if($activeTab === 'profile')
            <div class="glassmorphism p-8 rounded-3xl border border-gray-100 dark:border-gray-850 shadow-sm space-y-6">
                <h3 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Edit Profile Details</h3>
                
                <form wire:submit="updateProfile" class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Full Name</label>
                        <input type="text" wire:model="name" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                        @error('name') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                    </div>
                    
                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Email Address</label>
                        <input type="email" wire:model="email" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                        @error('email') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                    </div>

                    <div class="sm:col-span-2 pt-4">
                        <button type="submit" class="px-6 py-3 bg-luxury-gold hover:bg-amber-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action">Save Profile Changes</button>
                    </div>
                </form>
            </div>
        @endif

        <!-- Tab 3: Order History -->
        @if($activeTab === 'orders')
            <div class="glassmorphism p-8 rounded-3xl border border-gray-100 dark:border-gray-850 shadow-sm space-y-6">
                <h3 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Order History</h3>
                
                <div class="divide-y divide-gray-100 dark:divide-gray-800">
                    @forelse($orders as $order)
                        <div class="py-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                            <div class="space-y-1">
                                <h4 class="text-xs font-black text-luxury-charcoal dark:text-white tracking-widest">ORDER ID: {{ $order->order_number }}</h4>
                                <p class="text-[10px] text-gray-400">Date: {{ $order->created_at->format('F d, Y h:i A') }}</p>
                                <p class="text-[11px] text-gray-500 mt-1.5 font-medium">Payment: <span class="font-bold text-luxury-gold">{{ $order->payment_method }}</span> | Items: <span class="font-bold text-luxury-charcoal dark:text-gray-200">{{ $order->items->count() }}</span></p>
                            </div>
                            <div class="flex items-center gap-5 justify-between w-full md:w-auto">
                                <span class="text-base font-black text-luxury-gold">₹{{ number_format($order->total, 2) }}</span>
                                <span class="px-3.5 py-1.5 rounded-xl text-[10px] font-bold uppercase tracking-wider font-sans-action
                                    {{ $order->status === 'Delivered' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                    {{ $order->status === 'Pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                    {{ $order->status === 'Shipped' ? 'bg-blue-100 text-blue-700' : '' }}
                                    {{ $order->status === 'Cancelled' ? 'bg-rose-100 text-rose-700' : '' }}
                                ">
                                    {{ $order->status }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <p class="text-xs text-gray-400 dark:text-gray-500 italic">You have not placed any orders yet.</p>
                    @endforelse
                </div>
            </div>
        @endif

        <!-- Tab 4: Notifications & Alerts -->
        @if($activeTab === 'notifications')
            <div class="glassmorphism p-8 rounded-3xl border border-gray-100 dark:border-gray-850 shadow-sm space-y-6">
                <h3 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Recent Alerts</h3>
                
                <div class="flow-root">
                    <ul class="-mb-8">
                        @forelse($activities as $act)
                            <li>
                                <div class="relative pb-8">
                                    <span class="absolute top-4 left-4 -ml-px h-full w-0.5 bg-gray-100 dark:bg-gray-800" aria-hidden="true"></span>
                                    <div class="relative flex space-x-3">
                                        <div>
                                            <span class="h-8 w-8 rounded-full bg-luxury-gold/10 border border-luxury-gold/30 flex items-center justify-center text-luxury-gold text-xs">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                            </span>
                                        </div>
                                        <div class="min-w-0 flex-1 pt-1.5 flex justify-between space-x-4">
                                            <div>
                                                <p class="text-xs font-semibold text-luxury-charcoal dark:text-gray-200">{{ $act->description }}</p>
                                            </div>
                                            <div class="text-right text-[10px] whitespace-nowrap text-gray-400">
                                                <time datetime="{{ $act->created_at }}">{{ $act->created_at->diffForHumans() }}</time>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        @empty
                            <p class="text-xs text-gray-400 dark:text-gray-500 italic">No new notifications.</p>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif

        <!-- Tab 5: Security Settings -->
        @if($activeTab === 'settings')
            <div class="glassmorphism p-8 rounded-3xl border border-gray-100 dark:border-gray-850 shadow-sm space-y-6">
                <h3 class="text-base font-extrabold uppercase tracking-widest text-luxury-gold font-sans-action">Change Password</h3>
                
                <form wire:submit="updatePassword" class="grid grid-cols-1 gap-6 max-w-md">
                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Current Password</label>
                        <input type="password" wire:model="current_password" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                        @error('current_password') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">New Password</label>
                        <input type="password" wire:model="new_password" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                        @error('new_password') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Confirm New Password</label>
                        <input type="password" wire:model="new_password_confirmation" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-luxury-gold focus:border-luxury-gold text-gray-800 dark:text-white">
                    </div>

                    <div class="pt-4">
                        <button type="submit" class="px-6 py-3 bg-luxury-gold hover:bg-amber-600 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action">Update Password</button>
                    </div>
                </form>
            </div>
        @endif

    </div>
</div>
