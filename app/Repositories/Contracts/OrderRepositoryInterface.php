<?php

namespace App\Repositories\Contracts;

use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function getCustomerOrders(int $customerId): Collection;

    public function getOrderDetails(string $orderId): ?Order;

    public function getRecentOrders(int $limit = 5): Collection;
}
