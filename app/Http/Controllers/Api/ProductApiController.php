<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Repositories\Contracts\ProductRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductApiController extends Controller
{
    protected ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }

    /**
     * Get list of active products with optional filters.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only([
            'search', 'category_id', 'brand_id', 'fabric_type', 
            'collection', 'color', 'size', 'min_price', 'max_price', 'sort_by'
        ]);

        $perPage = $request->integer('per_page', 12);
        $products = $this->productRepo->searchAndFilter($filters, $perPage);

        return ProductResource::collection($products);
    }

    /**
     * Get single product detail by slug.
     */
    public function show(string $slug): ProductResource
    {
        $product = Product::where('slug', $slug)
            ->where('status', 'Active')
            ->with(['brand', 'category'])
            ->firstOrFail();

        return new ProductResource($product);
    }
}
