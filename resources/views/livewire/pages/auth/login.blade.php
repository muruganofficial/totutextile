<?php

use App\Livewire\Forms\LoginForm;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Layout;
use Livewire\Volt\Component;

new #[Layout('layouts.guest')] class extends Component
{
    public LoginForm $form;

    /**
     * Handle an incoming authentication request.
     */
    public function login(): void
    {
        $this->validate();

        $this->form->authenticate();

        Session::regenerate();

        $this->redirectIntended(default: route('dashboard', absolute: false), navigate: true);
    }
}; ?>

<div x-data="{ showPassword: false }">
    <!-- Session Status -->
    @if (session('status'))
        <div class="mb-5 text-sm font-medium px-4 py-3 rounded-xl bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
            {{ session('status') }}
        </div>
    @endif

    <form wire:submit="login" class="space-y-5">

        <!-- Email -->
        <div>
            <label for="email" class="block text-xs font-bold uppercase tracking-widest mb-1.5"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                Email Address
            </label>
            <input
                wire:model="form.email"
                id="email"
                type="email"
                name="email"
                required
                autofocus
                autocomplete="username"
                class="w-full px-4 py-3 rounded-xl text-sm border outline-none transition duration-200 focus:ring-2 focus:ring-indigo-500/40"
                :class="darkMode
                    ? 'bg-white/5 border-white/10 text-white placeholder-gray-600 focus:border-indigo-500'
                    : 'bg-gray-50 border-gray-200 text-gray-900 placeholder-gray-400 focus:border-indigo-400'"
                placeholder="you@example.com"
            >
            @error('form.email')
                <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div>
            <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-bold uppercase tracking-widest"
                       :class="darkMode ? 'text-gray-400' : 'text-gray-500'">
                    Password
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" wire:navigate
                       class="text-xs font-medium transition"
                       :class="darkMode ? 'text-indigo-400 hover:text-indigo-300' : 'text-indigo-600 hover:text-indigo-500'">
                        Forgot password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input
                    wire:model="form.password"
                    id="password"
                    :type="showPassword ? 'text' : 'password'"
                    name="password"
                    required
                    autocomplete="current-password"
                    class="w-full px-4 py-3 pr-11 rounded-xl text-sm border outline-none transition duration-200 focus:ring-2 focus:ring-indigo-500/40"
                    :class="darkMode
                        ? 'bg-white/5 border-white/10 text-white placeholder-gray-600 focus:border-indigo-500'
                        : 'bg-gray-50 border-gray-200 text-gray-900 placeholder-gray-400 focus:border-indigo-400'"
                    placeholder="••••••••"
                >
                <!-- Show/Hide password toggle -->
                <button type="button" @click="showPassword = !showPassword"
                        class="absolute right-3 top-1/2 -translate-y-1/2 p-1 transition"
                        :class="darkMode ? 'text-gray-500 hover:text-gray-300' : 'text-gray-400 hover:text-gray-600'">
                    <svg x-show="!showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                    <svg x-show="showPassword" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
                    </svg>
                </button>
            </div>
            @error('form.password')
                <p class="mt-1.5 text-xs text-rose-400 font-medium">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="flex items-center gap-2.5">
            <input
                wire:model="form.remember"
                id="remember"
                type="checkbox"
                class="w-4 h-4 rounded border text-indigo-600 focus:ring-indigo-500"
                :class="darkMode ? 'bg-white/10 border-white/20' : 'bg-white border-gray-300'"
            >
            <label for="remember" class="text-sm cursor-pointer"
                   :class="darkMode ? 'text-gray-400' : 'text-gray-600'">
                Remember me for 30 days
            </label>
        </div>

        <!-- Submit Button -->
        <button
            type="submit"
            class="w-full py-3.5 px-6 rounded-xl font-bold text-sm text-white transition-all duration-200 relative overflow-hidden group"
            :class="darkMode
                ? 'bg-indigo-600 hover:bg-indigo-500 shadow-lg shadow-indigo-500/25'
                : 'bg-indigo-600 hover:bg-indigo-700 shadow-lg shadow-indigo-500/30'"
        >
            <span class="relative z-10 flex items-center justify-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
                </svg>
                Sign In to Dashboard
            </span>
        </button>

    </form>
</div>

