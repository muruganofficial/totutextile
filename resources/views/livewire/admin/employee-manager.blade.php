<div class="space-y-10">
    <!-- Header -->
    <div class="flex items-center gap-4">
        <a href="/admin/dashboard" wire:navigate class="p-2 bg-gray-100 dark:bg-gray-800 hover:bg-amber-500 hover:text-white rounded-xl transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-950 dark:text-white">Staff Management</h1>
            <p class="text-sm text-gray-500 dark:text-gray-400 mt-1">Review shop employees, departments, salaries, and log daily attendance sheets.</p>
        </div>
    </div>

    <!-- Employee Table / Cards -->
    <div class="glassmorphism rounded-2xl overflow-hidden shadow-sm border border-gray-100 dark:border-gray-800">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm divide-y divide-gray-100 dark:divide-gray-800">
                <thead class="bg-gray-50 dark:bg-gray-900/50 text-xs font-bold uppercase text-gray-400 tracking-wider">
                    <tr>
                        <th class="px-6 py-4">Employee</th>
                        <th class="px-6 py-4">Department</th>
                        <th class="px-6 py-4">Hire Date</th>
                        <th class="px-6 py-4">Salary</th>
                        <th class="px-6 py-4">Today's Attendance</th>
                        <th class="px-6 py-4 text-right">Log Attendance</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                    @foreach($employees as $emp)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition text-gray-800 dark:text-gray-200">
                            <!-- Employee Profile -->
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 bg-amber-500 flex items-center justify-center rounded-xl text-white font-bold">{{ substr($emp->user->name, 0, 1) }}</div>
                                    <div>
                                        <p class="font-bold">{{ $emp->user->name }}</p>
                                        <p class="text-[10px] text-gray-400 mt-0.5">{{ $emp->user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Department -->
                            <td class="px-6 py-4 text-xs font-bold text-gray-700 dark:text-gray-300">
                                {{ $emp->department->name ?? 'N/A' }}
                            </td>

                            <!-- Hire Date -->
                            <td class="px-6 py-4 text-xs text-gray-450">
                                {{ $emp->hire_date->format('M d, Y') }}
                            </td>

                            <!-- Salary -->
                            <td class="px-6 py-4 text-xs font-black">
                                ₹{{ number_format($emp->salary, 2) }}
                            </td>

                            <!-- Attendance status -->
                            <td class="px-6 py-4">
                                @php
                                    $todayAtt = $emp->attendances->first();
                                @endphp
                                @if($todayAtt)
                                    <span class="px-2 py-0.5 text-[9px] font-bold uppercase rounded-md tracking-wider 
                                        {{ $todayAtt->status === 'Present' ? 'bg-emerald-500/10 text-emerald-500' : '' }}
                                        {{ $todayAtt->status === 'Absent' ? 'bg-rose-500/10 text-rose-500' : '' }}
                                        {{ $todayAtt->status === 'Leave' ? 'bg-blue-500/10 text-blue-500' : '' }}
                                    ">
                                        {{ $todayAtt->status }}
                                    </span>
                                @else
                                    <span class="px-2 py-0.5 text-[9px] font-bold uppercase rounded-md tracking-wider bg-gray-100 text-gray-400">
                                        Unmarked
                                    </span>
                                @endif
                            </td>

                            <!-- Log Attendance Action -->
                            <td class="px-6 py-4 text-right">
                                <div class="inline-flex gap-1">
                                    <button wire:click="logAttendance({{ $emp->id }}, 'Present')" class="px-2.5 py-1 text-[10px] font-bold bg-emerald-550 hover:bg-emerald-600 text-white rounded transition">P</button>
                                    <button wire:click="logAttendance({{ $emp->id }}, 'Absent')" class="px-2.5 py-1 text-[10px] font-bold bg-rose-550 hover:bg-rose-600 text-white rounded transition">A</button>
                                    <button wire:click="logAttendance({{ $emp->id }}, 'Leave')" class="px-2.5 py-1 text-[10px] font-bold bg-blue-550 hover:bg-blue-600 text-white rounded transition">L</button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
