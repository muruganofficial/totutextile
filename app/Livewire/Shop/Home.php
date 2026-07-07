<?php

namespace App\Livewire\Shop;

use App\Models\Blog;
use App\Models\Product;
use App\Models\Testimonial;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.shop')]
class Home extends Component
{
    public $featuredProducts = [];
    public $trendingProducts = [];
    public $testimonials = [];
    public $recentBlogs = [];

    public function mount()
    {
        $this->featuredProducts = Product::where('status', 'Active')
            ->where('is_featured', true)
            ->with(['images' => function($q) { $q->where('is_featured', true); }])
            ->limit(4)
            ->get();

        $this->trendingProducts = Product::where('status', 'Active')
            ->where('is_trending', true)
            ->with(['images' => function($q) { $q->where('is_featured', true); }])
            ->limit(4)
            ->get();

        $this->testimonials = Testimonial::limit(3)->get();
        $this->recentBlogs = Blog::where('status', 'Published')->limit(2)->get();
    }

    public function render()
    {
        return view('livewire.shop.home');
    }
}
