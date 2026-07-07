<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\Product;
use App\Models\Stock;
use App\Models\User;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class Dashboard extends Component
{
    public float $totalSales = 0.00;
    public int $totalOrders = 0;
    public int $totalCustomers = 0;
    public int $lowStockCount = 0;

    public $recentOrders = [];
    public $lowStockItems = [];

    public function mount(OrderRepositoryInterface $orderRepo)
    {
        if (!auth()->check() || (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('employee'))) {
            return $this->redirect('/login', navigate: true);
        }

        // Summary Aggregations
        $this->totalSales = Order::where('payment_status', 'Paid')->sum('total');
        $this->totalOrders = Order::count();
        $this->totalCustomers = User::role('customer')->count();
        
        $this->lowStockCount = Stock::whereColumn('quantity', '<=', 'low_stock_threshold')->count();

        // Lists
        $this->recentOrders = $orderRepo->getRecentOrders(5);
        $this->lowStockItems = Stock::whereColumn('quantity', '<=', 'low_stock_threshold')
            ->with(['warehouse', 'product'])
            ->limit(5)
            ->get();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
