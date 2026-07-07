<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin')]
class OrderManager extends Component
{
    public $orders = [];

    public function mount()
    {
        if (!auth()->check() || (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('employee'))) {
            return $this->redirect('/login', navigate: true);
        }

        $this->loadOrders();
    }

    public function loadOrders()
    {
        $this->orders = Order::with(['customer', 'shippingAddress'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updateStatus(string $orderId, string $status)
    {
        try {
            $order = Order::findOrFail($orderId);
            $order->update(['status' => $status]);

            // If delivered, update payment status if COD
            if ($status === 'Delivered' && $order->payment_method === 'COD') {
                $order->update(['payment_status' => 'Paid']);
            }

            // Write audit log
            activity()
                ->performedOn($order)
                ->withProperties(['status' => $status])
                ->log("Order #{$order->order_number} status updated to {$status}.");

            $this->dispatch('toast', message: "Order status updated to {$status}!", type: 'success');
            $this->loadOrders();
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.admin.order-manager');
    }
}
