<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use Livewire\Component;

class SearchEverywhere extends Component
{
    public string $search = '';
    public array $results = [];

    public function updatedSearch()
    {
        if (strlen($this->search) < 2) {
            $this->results = [];
            return;
        }

        $this->results = Product::where('status', 'Active')
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                      ->orWhere('sku', 'like', '%' . $this->search . '%')
                      ->orWhere('fabric_type', 'like', '%' . $this->search . '%');
            })
            ->with(['images' => function($q) { $q->where('is_featured', true); }])
            ->limit(5)
            ->get()
            ->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'sku' => $product->sku,
                    'price' => $product->selling_price,
                    'image' => $product->images->first()?->file_path ?? 'assets/images/placeholder.jpg',
                ];
            })
            ->toArray();
    }

    public function selectProduct($slug)
    {
        $this->reset('search', 'results');
        return $this->redirect('/product/' . $slug, navigate: true);
    }

    public function render()
    {
        return view('livewire.shop.search-everywhere');
    }
}
