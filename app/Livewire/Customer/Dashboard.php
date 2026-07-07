<?php

namespace App\Livewire\Customer;

use App\Models\Address;
use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.shop')]
class Dashboard extends Component
{
    public string $activeTab = 'dashboard'; // dashboard, profile, orders, notifications, settings
    
    // Profile Fields
    public string $name = '';
    public string $email = '';

    // Password Fields
    public string $current_password = '';
    public string $new_password = '';
    public string $new_password_confirmation = '';

    // Data lists
    public $orders = [];
    public $addresses = [];
    public float $walletBalance = 0.00;
    public int $loyaltyPoints = 0;
    public $activities = [];

    public function mount(OrderRepositoryInterface $orderRepo)
    {
        $user = Auth::user();
        if (!$user) {
            return $this->redirect('/login', navigate: true);
        }

        $this->name = $user->name;
        $this->email = $user->email;

        $this->orders = $orderRepo->getCustomerOrders($user->id);
        $this->addresses = $user->addresses;
        $this->walletBalance = $user->wallet?->balance ?? 0.00;
        $this->loyaltyPoints = $user->loyaltyPoints?->points_balance ?? 0;
        
        // Fetch Spatie Activity log for notifications
        $this->activities = \Spatie\Activitylog\Models\Activity::where('causer_id', $user->id)
            ->latest()
            ->take(8)
            ->get();
    }

    public function updateProfile()
    {
        $user = Auth::user();
        
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);

        $this->dispatch('toast', message: 'Profile details updated successfully!', type: 'success');
    }

    public function updatePassword()
    {
        $user = Auth::user();

        $this->validate([
            'current_password' => ['required', 'current_password'],
            'new_password' => ['required', 'confirmed', Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($this->new_password),
        ]);

        $this->reset(['current_password', 'new_password', 'new_password_confirmation']);

        $this->dispatch('toast', message: 'Password updated successfully!', type: 'success');
    }

    public function render()
    {
        return view('livewire.customer.dashboard');
    }
}
