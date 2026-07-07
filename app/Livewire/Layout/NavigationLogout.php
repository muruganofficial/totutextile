<?php

namespace App\Livewire\Layout;

use App\Livewire\Actions\Logout;
use Livewire\Component;

class NavigationLogout extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $user = auth()->user();
        $redirectUrl = '/';

        if ($user) {
            if ($user->hasRole('admin') || $user->hasRole('employee')) {
                $redirectUrl = '/login?role=admin';
            } elseif ($user->hasRole('vendor')) {
                $redirectUrl = '/login?role=vendor';
            }
        }

        $logout();

        $this->redirect($redirectUrl, navigate: true);
    }

    public function render()
    {
        return <<<'HTML'
            <button wire:click="logout" class="w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Log Out
            </button>
        HTML;
    }
}
