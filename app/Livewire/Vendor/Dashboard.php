<?php

namespace App\Livewire\Vendor;

use App\Models\Product;
use App\Models\Vendor;
use App\Models\VendorEarning;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public ?Vendor $vendor = null;
    public $earnings = [];
    public $products = [];

    // Financial summaries
    public float $grossEarnings = 0.00;
    public float $netEarnings = 0.00;
    public float $commissionDeducted = 0.00;

    public function mount()
    {
        $user = Auth::user();
        if (!$user || !$user->hasRole('vendor')) {
            return $this->redirect('/login', navigate: true);
        }

        $this->vendor = $user->vendor;

        if ($this->vendor) {
            $this->products = Product::where('vendor_id', $this->vendor->id)->get();
            $this->earnings = VendorEarning::where('vendor_id', $this->vendor->id)
                ->with('order')
                ->orderBy('created_at', 'desc')
                ->get();

            // Calculate aggregations
            $this->grossEarnings = $this->earnings->sum('gross_amount');
            $this->netEarnings = $this->earnings->where('status', 'Paid')->sum('net_earnings');
            $this->commissionDeducted = $this->earnings->sum('commission_deducted');
        }
    }

    public function render()
    {
        return view('livewire.vendor.dashboard');
    }
}
