<?php

namespace App\Livewire\Shop;

use App\Models\Product;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.shop')]
class ProductDetail extends Component
{
    public Product $product;
    public int $quantity = 1;
    public string $selectedColor = '';
    public string $selectedSize = '';

    public function mount(string $slug)
    {
        $this->product = Product::where('slug', $slug)
            ->where('status', 'Active')
            ->with(['images', 'brand', 'category'])
            ->firstOrFail();

        // Select default attributes if available
        $this->selectedColor = $this->product->attributes['color'] ?? '';
        $this->selectedSize = is_array($this->product->attributes['sizes'] ?? null) 
            ? ($this->product->attributes['sizes'][0] ?? '') 
            : '';
    }

    public function incrementQuantity()
    {
        $this->quantity++;
    }

    public function decrementQuantity()
    {
        if ($this->quantity > 1) {
            $this->quantity--;
        }
    }

    public function addToCart()
    {
        // Get current cart session
        $cart = session()->get('cart', []);

        // Define a unique key for this product variation
        $cartKey = $this->product->id . '-' . $this->selectedColor . '-' . $this->selectedSize;

        if (isset($cart[$cartKey])) {
            $cart[$cartKey]['quantity'] += $this->quantity;
        } else {
            $cart[$cartKey] = [
                'product_id' => $this->product->id,
                'name' => $this->product->name,
                'price' => $this->product->selling_price,
                'color' => $this->selectedColor,
                'size' => $this->selectedSize,
                'quantity' => $this->quantity,
                'image' => $this->product->images->first()?->file_path ?? 'assets/images/placeholder.jpg',
            ];
        }

        session()->put('cart', $cart);

        // Dispatch browser event to show toast
        $this->dispatch('toast', message: 'Product added to cart successfully!', type: 'success');

        // Redirect to cart page to proceed to checkout
        return $this->redirect('/cart', navigate: true);
    }

    public function render()
    {
        return view('livewire.shop.product-detail');
    }
}
