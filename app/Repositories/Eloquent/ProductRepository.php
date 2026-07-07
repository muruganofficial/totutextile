<?php

namespace App\Repositories\Eloquent;

use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductRepository extends BaseRepository implements ProductRepositoryInterface
{
    public function model(): string
    {
        return Product::class;
    }

    public function getFeatured(int $limit = 8): Collection
    {
        return $this->model->where('status', 'Active')
            ->where('is_featured', true)
            ->with(['images' => function($q) { $q->where('is_featured', true); }])
            ->limit($limit)
            ->get();
    }

    public function getTrending(int $limit = 8): Collection
    {
        return $this->model->where('status', 'Active')
            ->where('is_trending', true)
            ->with(['images' => function($q) { $q->where('is_featured', true); }])
            ->limit($limit)
            ->get();
    }

    public function getNewArrivals(int $limit = 8): Collection
    {
        return $this->model->where('status', 'Active')
            ->where('is_new_arrival', true)
            ->with(['images' => function($q) { $q->where('is_featured', true); }])
            ->limit($limit)
            ->get();
    }

    public function searchAndFilter(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        $query = $this->model->where('status', 'Active')->with(['images' => function($q) { $q->where('is_featured', true); }]);

        // Global Search Term
        if (!empty($filters['search'])) {
            $term = $filters['search'];
            $query->where(function ($q) use ($term) {
                $q->where('name', 'like', "%{$term}%")
                  ->orWhere('sku', 'like', "%{$term}%")
                  ->orWhere('description', 'like', "%{$term}%")
                  ->orWhere('fabric_type', 'like', "%{$term}%");
            });
        }

        // Category Filter
        if (!empty($filters['category_id'])) {
            $descendants = $this->getDescendantCategoryIds($filters['category_id']);
            $query->whereIn('category_id', $descendants);
        }

        // Parent Category Filter (e.g. Ethnic, Western)
        if (!empty($filters['parent_category_id'])) {
            $descendants = $this->getDescendantCategoryIds($filters['parent_category_id']);
            $query->whereIn('category_id', $descendants);
        }

        // Brand Filter
        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }

        // Fabric Type Filter
        if (!empty($filters['fabric_type'])) {
            $query->where('fabric_type', $filters['fabric_type']);
        }

        // Collections Filter
        if (!empty($filters['collection'])) {
            $col = $filters['collection'];
            $query->whereJsonContains('collections', $col);
        }

        // Attributes (JSON search e.g. color, size)
        if (!empty($filters['color'])) {
            $color = $filters['color'];
            $query->where('attributes->color', 'like', "%{$color}%");
        }

        if (!empty($filters['size'])) {
            $size = $filters['size'];
            $query->whereJsonContains('attributes->sizes', $size);
        }

        // Price Range Filter
        if (isset($filters['min_price'])) {
            $query->where('selling_price', '>=', $filters['min_price']);
        }

        if (isset($filters['max_price'])) {
            $query->where('selling_price', '<=', $filters['max_price']);
        }

        // Sorting
        $sort = $filters['sort_by'] ?? 'newest';
        switch ($sort) {
            case 'price_low':
                $query->orderBy('selling_price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('selling_price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'popular':
                $query->orderBy('is_featured', 'desc')->orderBy('is_trending', 'desc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        return $query->paginate($perPage);
    }

    protected function getDescendantCategoryIds(int $categoryId): array
    {
        $ids = [$categoryId];
        $childrenIds = \App\Models\Category::where('parent_id', $categoryId)->pluck('id')->toArray();
        foreach ($childrenIds as $childId) {
            $ids = array_merge($ids, $this->getDescendantCategoryIds($childId));
        }
        return array_unique($ids);
    }
}
