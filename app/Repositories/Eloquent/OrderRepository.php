<?php

namespace App\Repositories\Eloquent;

use App\Models\Order;
use App\Repositories\Contracts\OrderRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository extends BaseRepository implements OrderRepositoryInterface
{
    public function model(): string
    {
        return Order::class;
    }

    public function getCustomerOrders(int $customerId): Collection
    {
        return $this->model->where('customer_id', $customerId)
            ->with(['items.product.images'])
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getOrderDetails(string $orderId): ?Order
    {
        return $this->model->with(['items.product.images', 'shippingAddress', 'customer.profile'])
            ->find($orderId);
    }

    public function getRecentOrders(int $limit = 5): Collection
    {
        return $this->model->with(['customer'])
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }
}
