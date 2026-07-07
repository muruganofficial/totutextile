<div class="space-y-10">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="/admin/dashboard" wire:navigate class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-amber-500 hover:text-white rounded-xl transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-950 dark:text-white">Order Operations</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Manage, dispatch, track, and update fulfillment statuses of shopper orders.</p>
        </div>
    </div>

    <!-- Orders Table -->
    <div class="glassmorphism rounded-2xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm divide-y divide-gray-100 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-900/50 text-xs font-bold uppercase text-gray-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Order Number</th>
                        <th class="px-6 py-4">Customer Details</th>
                        <th class="px-6 py-4">Order Date</th>
                        <th class="px-6 py-4">Payment Info</th>
                        <th class="px-6 py-4 text-right">Order Total</th>
                        <th class="px-6 py-4">Fulfillment Status</th>
                        <th class="px-6 py-4">Quick Update</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                    @foreach($orders as $o)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition text-gray-800 dark:text-gray-200">
                            <!-- Order Number -->
                            <td class="px-6 py-4 font-extrabold">{{ $o->order_number }}</td>
                            
                            <!-- Customer Details -->
                            <td class="px-6 py-4">
                                <p class="font-bold text-xs">{{ $o->customer->name }}</p>
                                <p class="text-[10px] text-gray-400 mt-0.5">{{ $o->customer->email }}</p>
                            </td>

                            <!-- Order Date -->
                            <td class="px-6 py-4 text-xs text-gray-400">{{ $o->created_at->format('M d, Y | h:i A') }}</td>
                            
                            <!-- Payment Info -->
                            <td class="px-6 py-4">
                                <span class="px-2 py-0.5 text-[9px] font-bold uppercase rounded bg-gray-150 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300">
                                    {{ $o->payment_method }}
                                </span>
                                <span class="ml-1.5 px-2 py-0.5 text-[9px] font-bold uppercase rounded 
                                    {{ $o->payment_status === 'Paid' ? 'bg-emerald-500/10 text-emerald-500' : 'bg-rose-500/10 text-rose-500' }}
                                ">
                                    {{ $o->payment_status }}
                                </span>
                            </td>

                            <!-- Order Total -->
                            <td class="px-6 py-4 text-right font-black text-amber-500">₹{{ number_format($o->total, 2) }}</td>

                            <!-- Current Status Badge -->
                            <td class="px-6 py-4">
                                <span class="px-2.5 py-1 text-[9px] font-bold rounded-md uppercase tracking-wider 
                                    {{ $o->status === 'Pending' ? 'bg-amber-500/10 text-amber-500' : '' }}
                                    {{ $o->status === 'Processing' ? 'bg-blue-500/10 text-blue-500' : '' }}
                                    {{ $o->status === 'Shipped' ? 'bg-indigo-500/10 text-indigo-500' : '' }}
                                    {{ $o->status === 'Delivered' ? 'bg-emerald-500/10 text-emerald-500' : '' }}
                                    {{ $o->status === 'Cancelled' ? 'bg-rose-500/10 text-rose-500' : '' }}
                                ">
                                    {{ $o->status }}
                                </span>
                            </td>

                            <!-- Quick Update Dropdown -->
                            <td class="px-6 py-4">
                                <select 
                                    wire:change="updateStatus('{{ $o->id }}', $event.target.value)" 
                                    class="px-2 py-1 bg-white dark:bg-gray-800 border border-gray-200 dark:border-gray-700 rounded-lg text-[11px] font-bold focus:ring-amber-500 focus:border-amber-500 cursor-pointer"
                                >
                                    <option value="Pending" {{ $o->status === 'Pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="Processing" {{ $o->status === 'Processing' ? 'selected' : '' }}>Processing</option>
                                    <option value="Shipped" {{ $o->status === 'Shipped' ? 'selected' : '' }}>Shipped</option>
                                    <option value="Delivered" {{ $o->status === 'Delivered' ? 'selected' : '' }}>Delivered</option>
                                    <option value="Cancelled" {{ $o->status === 'Cancelled' ? 'selected' : '' }}>Cancelled</option>
                                </select>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
