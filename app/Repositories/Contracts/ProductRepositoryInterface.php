<?php

namespace App\Repositories\Contracts;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface ProductRepositoryInterface extends RepositoryInterface
{
    public function getFeatured(int $limit = 8): Collection;

    public function getTrending(int $limit = 8): Collection;

    public function getNewArrivals(int $limit = 8): Collection;

    public function searchAndFilter(array $filters, int $perPage = 12): LengthAwarePaginator;
}
