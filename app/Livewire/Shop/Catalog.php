<?php

namespace App\Livewire\Shop;

use App\Models\Brand;
use App\Models\Category;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.shop')]
class Catalog extends Component
{
    use WithPagination;

    #[Url(keep: true)]
    public string $search = '';

    #[Url(keep: true)]
    public string $category_id = '';

    #[Url(keep: true)]
    public string $parent_category_id = '';

    #[Url(keep: true)]
    public string $brand_id = '';

    #[Url(keep: true)]
    public string $fabric_type = '';

    #[Url(keep: true)]
    public string $collection = '';

    #[Url(keep: true)]
    public string $color = '';

    #[Url(keep: true)]
    public string $size = '';

    #[Url(keep: true)]
    public string $min_price = '';

    #[Url(keep: true)]
    public string $max_price = '';

    #[Url(keep: true)]
    public string $sort_by = 'newest';

    public function updating()
    {
        $this->resetPage();
    }

    public function selectParentCategory($id)
    {
        $this->parent_category_id = $id;
        $this->category_id = '';
        $this->resetPage();
    }

    public function selectSubCategory($id)
    {
        $this->category_id = $id;
        $this->parent_category_id = '';
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset([
            'search', 'category_id', 'parent_category_id', 'brand_id',
            'fabric_type', 'collection', 'color', 'size',
            'min_price', 'max_price', 'sort_by'
        ]);
        $this->resetPage();
    }

    public function render(ProductRepositoryInterface $productRepo)
    {
        // Assemble filters
        $filters = [
            'search' => $this->search,
            'category_id' => $this->category_id ? (int)$this->category_id : null,
            'parent_category_id' => $this->parent_category_id ? (int)$this->parent_category_id : null,
            'brand_id' => $this->brand_id ? (int)$this->brand_id : null,
            'fabric_type' => $this->fabric_type,
            'collection' => $this->collection,
            'color' => $this->color,
            'size' => $this->size,
            'sort_by' => $this->sort_by,
        ];

        if ($this->min_price !== '') {
            $filters['min_price'] = (float)$this->min_price;
        }
        if ($this->max_price !== '') {
            $filters['max_price'] = (float)$this->max_price;
        }

        $products = $productRepo->searchAndFilter($filters, 8);
        $categories = Category::whereNull('parent_id')->with('children')->get();
        $brands = Brand::where('status', 'Active')->get();

        // Extract distinct fabric types to show in filter list
        $fabricTypes = \App\Models\Product::where('status', 'Active')
            ->whereNotNull('fabric_type')
            ->distinct()
            ->pluck('fabric_type');

        return view('livewire.shop.catalog', [
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
            'fabricTypes' => $fabricTypes,
        ]);
    }
}
