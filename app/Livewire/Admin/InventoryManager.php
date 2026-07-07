<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Brand;
use App\Models\Vendor;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Stock;
use App\Models\Warehouse;
use App\Services\InventoryService;
use Illuminate\Support\Str;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

#[Layout('layouts.admin')]
class InventoryManager extends Component
{
    use WithPagination, WithFileUploads;

    public string $activeTab = 'products'; // products, categories, stock, attributes
    public string $searchProduct = '';
    public string $filterCategory = '';

    // Product Form Toggle & ID
    public bool $showProductForm = false;
    public ?int $editingProductId = null;

    // Product Form Fields
    public string $product_name = '';
    public string $product_description = '';
    public string $product_sku = '';
    public string $product_barcode = '';
    public float $product_cost_price = 0.00;
    public float $product_selling_price = 0.00;
    public float $product_gst_rate = 18.00;
    public string $product_category_id = '';
    public string $product_brand_id = '';
    public string $product_vendor_id = '';
    public string $product_status = 'Active';
    public string $product_fabric_type = '';
    
    // Attributes
    public string $product_color = '';
    public string $product_sizes = 'S, M, L, XL';
    public string $product_collections = 'New Arrivals';
    public string $product_image_url = '';
    public $product_uploaded_image;

    // Feature Flags
    public bool $product_is_featured = false;
    public bool $product_is_trending = false;
    public bool $product_is_best_seller = false;
    public bool $product_is_new_arrival = true;

    // Category Form Fields
    public bool $showCategoryForm = false;
    public ?int $editingCategoryId = null;
    public string $category_name = '';
    public string $category_parent_id = '';
    public string $category_description = '';
    public string $category_status = 'Active';

    // Stock Adjustment & Transfer Fields
    public $stocks = [];
    public $warehouses = [];
    public string $selectedStockId = '';
    public int $qtyAdjustment = 0;
    public string $adjustmentReason = 'Physical Stock Take';
    public string $selectedProductId = '';
    public string $sourceWarehouseId = '';
    public string $targetWarehouseId = '';
    public int $transferQuantity = 0;

    protected $queryString = [
        'searchProduct' => ['except' => ''],
        'filterCategory' => ['except' => ''],
        'activeTab' => ['except' => 'products']
    ];

    public function mount()
    {
        if (!auth()->check() || (!auth()->user()->hasRole('admin') && !auth()->user()->hasRole('employee'))) {
            return $this->redirect('/login', navigate: true);
        }

        $this->loadWarehouseData();
    }

    public function updatingSearchProduct()
    {
        $this->resetPage();
    }

    public function updatingFilterCategory()
    {
        $this->resetPage();
    }

    // Switch tab and reset all form states
    public function switchTab(string $tab)
    {
        $this->activeTab = $tab;
        $this->showProductForm = false;
        $this->showCategoryForm = false;
        $this->editingProductId = null;
        $this->editingCategoryId = null;
        $this->resetProductForm();
        $this->resetCategoryForm();
    }

    public function loadWarehouseData()
    {
        $this->stocks = Stock::with(['warehouse', 'product'])->get();
        $this->warehouses = Warehouse::all();
    }

    // Toggle Form View
    public function toggleProductForm(bool $show, ?int $productId = null)
    {
        $this->showProductForm = $show;
        $this->editingProductId = $productId;

        if ($productId) {
            $this->editProduct($productId);
        } else {
            $this->resetProductForm();
        }
    }

    // Toggle Category Form View
    public function toggleCategoryForm(bool $show, ?int $categoryId = null)
    {
        // Reset field values first (but not showCategoryForm)
        $this->reset([
            'editingCategoryId',
            'category_name',
            'category_parent_id',
            'category_description',
            'category_status',
        ]);

        // Now set visibility and load data if editing
        $this->showCategoryForm = $show;
        $this->editingCategoryId = $categoryId;

        if ($categoryId) {
            $this->editCategory($categoryId);
        }
    }

    public function resetCategoryForm()
    {
        $this->showCategoryForm = false;
        $this->reset([
            'editingCategoryId',
            'category_name',
            'category_parent_id',
            'category_description',
            'category_status',
        ]);
    }

    // Reset Form Fields
    public function resetProductForm()
    {
        $this->reset([
            'editingProductId',
            'product_name',
            'product_description',
            'product_sku',
            'product_barcode',
            'product_cost_price',
            'product_selling_price',
            'product_gst_rate',
            'product_category_id',
            'product_brand_id',
            'product_vendor_id',
            'product_status',
            'product_fabric_type',
            'product_color',
            'product_sizes',
            'product_collections',
            'product_image_url',
            'product_uploaded_image',
            'product_is_featured',
            'product_is_trending',
            'product_is_best_seller',
            'product_is_new_arrival'
        ]);
    }

    // Edit Product Setup
    public function editProduct(int $id)
    {
        $product = Product::with(['images', 'category'])->findOrFail($id);
        
        $this->editingProductId = $product->id;
        $this->product_name = $product->name;
        $this->product_description = $product->description ?? '';
        $this->product_sku = $product->sku;
        $this->product_barcode = $product->barcode ?? '';
        $this->product_cost_price = (float)$product->cost_price;
        $this->product_selling_price = (float)$product->selling_price;
        $this->product_gst_rate = (float)$product->gst_rate;
        $this->product_category_id = (string)$product->category_id;
        $this->product_brand_id = (string)$product->brand_id;
        $this->product_vendor_id = (string)$product->vendor_id;
        $this->product_status = $product->status;
        $this->product_fabric_type = $product->fabric_type ?? '';
        
        // Attributes & Collections
        $this->product_color = $product->attributes['color'] ?? '';
        $this->product_sizes = is_array($product->attributes['sizes'] ?? null) 
            ? implode(', ', $product->attributes['sizes']) 
            : ($product->attributes['sizes'] ?? '');
        $this->product_collections = is_array($product->collections ?? null) 
            ? implode(', ', $product->collections) 
            : ($product->collections ?? '');
        
        $this->product_image_url = $product->images->first()?->file_path ?? '';
        
        // Flags
        $this->product_is_featured = (bool)$product->is_featured;
        $this->product_is_trending = (bool)$product->is_trending;
        $this->product_is_best_seller = (bool)$product->is_best_seller;
        $this->product_is_new_arrival = (bool)$product->is_new_arrival;
    }

    // Save Product (Add / Edit)
    public function saveProduct()
    {
        $rules = [
            'product_name' => 'required|string|max:255',
            'product_sku' => 'required|string|max:100|unique:products,sku,' . $this->editingProductId,
            'product_cost_price' => 'required|numeric|min:0',
            'product_selling_price' => 'required|numeric|min:0',
            'product_gst_rate' => 'required|numeric|min:0',
            'product_category_id' => 'required|exists:categories,id',
            'product_brand_id' => 'nullable|exists:brands,id',
            'product_vendor_id' => 'nullable|exists:vendors,id',
            'product_status' => 'required|in:Active,Inactive,Draft',
            'product_color' => 'nullable|string',
            'product_sizes' => 'nullable|string',
            'product_collections' => 'nullable|string',
            'product_fabric_type' => 'nullable|string',
            'product_image_url' => 'nullable|url',
            'product_uploaded_image' => 'nullable|image|max:2048',
        ];

        $this->validate($rules);

        // Parse attributes
        $sizesArray = array_filter(array_map('trim', explode(',', $this->product_sizes)));
        $collectionsArray = array_filter(array_map('trim', explode(',', $this->product_collections)));

        $attributes = [
            'color' => $this->product_color,
            'sizes' => $sizesArray
        ];

        $data = [
            'category_id' => $this->product_category_id,
            'brand_id' => $this->product_brand_id ?: null,
            'vendor_id' => $this->product_vendor_id ?: null,
            'fabric_type' => $this->product_fabric_type,
            'name' => $this->product_name,
            'slug' => Str::slug($this->product_name),
            'description' => $this->product_description,
            'sku' => $this->product_sku,
            'cost_price' => $this->product_cost_price,
            'selling_price' => $this->product_selling_price,
            'gst_rate' => $this->product_gst_rate,
            'status' => $this->product_status,
            'attributes' => $attributes,
            'collections' => $collectionsArray,
            'is_featured' => $this->product_is_featured,
            'is_trending' => $this->product_is_trending,
            'is_best_seller' => $this->product_is_best_seller,
            'is_new_arrival' => $this->product_is_new_arrival,
        ];

        if ($this->editingProductId) {
            $product = Product::findOrFail($this->editingProductId);
            $product->update($data);
            $this->dispatch('toast', message: 'Product updated successfully!', type: 'success');
        } else {
            $product = Product::create($data);

            // Populate initial stocks in warehouses with 0 quantity
            $warehouses = Warehouse::all();
            foreach ($warehouses as $wh) {
                Stock::create([
                    'warehouse_id' => $wh->id,
                    'product_id' => $product->id,
                    'quantity' => 0,
                    'low_stock_threshold' => 10
                ]);
            }
            $this->dispatch('toast', message: 'Product created successfully!', type: 'success');
        }

        // Handle Image Upload / URL
        if ($this->product_uploaded_image) {
            $filename = time() . '_' . $product->id . '.' . $this->product_uploaded_image->getClientOriginalExtension();
            $this->product_uploaded_image->storeAs('public/products', $filename);
            
            // Delete old images
            $product->images()->delete();

            ProductImage::create([
                'product_id' => $product->id,
                'file_path' => '/storage/products/' . $filename,
                'sort_order' => 0,
                'is_featured' => true
            ]);
        } elseif ($this->product_image_url) {
            $product->images()->delete();
            ProductImage::create([
                'product_id' => $product->id,
                'file_path' => $this->product_image_url,
                'sort_order' => 0,
                'is_featured' => true
            ]);
        }

        $this->toggleProductForm(false);
        $this->loadWarehouseData();
    }

    // Edit Category Setup
    public function editCategory(int $id)
    {
        $category = Category::findOrFail($id);
        $this->editingCategoryId = $category->id;
        $this->category_name = $category->name;
        $this->category_parent_id = (string)$category->parent_id;
        $this->category_description = $category->description ?? '';
        $this->category_status = $category->status;
    }

    // Cancel Category Edit
    public function cancelCategoryEdit()
    {
        $this->resetCategoryForm();
    }

    // Save Category (Add Category / Subcategory)
    public function saveCategory()
    {
        $this->validate([
            'category_name' => 'required|string|max:255',
            'category_parent_id' => 'nullable|exists:categories,id',
            'category_description' => 'nullable|string',
            'category_status' => 'required|in:Active,Inactive',
        ]);

        $data = [
            'parent_id' => $this->category_parent_id ?: null,
            'name' => $this->category_name,
            'slug' => Str::slug($this->category_name),
            'description' => $this->category_description,
            'status' => $this->category_status,
        ];

        if ($this->editingCategoryId) {
            if ($this->category_parent_id == $this->editingCategoryId) {
                $this->dispatch('toast', message: 'Category cannot be its own parent.', type: 'error');
                return;
            }

            $category = Category::findOrFail($this->editingCategoryId);
            $category->update($data);
            $this->dispatch('toast', message: 'Category updated successfully!', type: 'success');
        } else {
            Category::create($data);
            $this->dispatch('toast', message: 'Category master created successfully!', type: 'success');
        }

        $this->resetCategoryForm();
    }

    // Delete Category
    public function deleteCategory(int $id)
    {
        $category = Category::findOrFail($id);

        if ($category->children()->count() > 0) {
            $this->dispatch('toast', message: 'Cannot delete category containing subcategories.', type: 'error');
            return;
        }

        if ($category->products()->count() > 0) {
            $this->dispatch('toast', message: 'Cannot delete category containing products.', type: 'error');
            return;
        }

        $category->delete();
        $this->dispatch('toast', message: 'Category deleted successfully!', type: 'success');
    }

    // Delete Product
    public function deleteProduct(int $id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        $this->dispatch('toast', message: 'Product deactivated/archived.', type: 'info');
        $this->loadWarehouseData();
    }

    // Adjust Stock
    public function adjustStock(InventoryService $inventoryService)
    {
        $this->validate([
            'selectedStockId' => 'required',
            'qtyAdjustment' => 'required|integer',
            'adjustmentReason' => 'required|string|min:4',
        ]);

        try {
            $stock = Stock::findOrFail($this->selectedStockId);
            $inventoryService->adjustStock($stock->warehouse_id, $stock->product_id, $this->qtyAdjustment, $this->adjustmentReason);
            
            $this->dispatch('toast', message: 'Stock adjusted successfully!', type: 'success');
            $this->reset(['selectedStockId', 'qtyAdjustment', 'adjustmentReason']);
            $this->loadWarehouseData();
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    // Transfer Stock
    public function transferStock(InventoryService $inventoryService)
    {
        $this->validate([
            'selectedProductId' => 'required',
            'sourceWarehouseId' => 'required',
            'targetWarehouseId' => 'required|different:sourceWarehouseId',
            'transferQuantity' => 'required|integer|min:1',
        ]);

        try {
            $inventoryService->transferStock(
                (int)$this->sourceWarehouseId,
                (int)$this->targetWarehouseId,
                (int)$this->selectedProductId,
                $this->transferQuantity,
                "Admin transferred stock."
            );

            $this->dispatch('toast', message: 'Stock transferred successfully!', type: 'success');
            $this->reset(['selectedProductId', 'sourceWarehouseId', 'targetWarehouseId', 'transferQuantity']);
            $this->loadWarehouseData();
        } catch (\Exception $e) {
            $this->dispatch('toast', message: $e->getMessage(), type: 'error');
        }
    }

    public function render()
    {
        // Query products with pagination
        $productsQuery = Product::with(['category', 'images', 'stocks'])
            ->latest();

        if (!empty($this->searchProduct)) {
            $productsQuery->where('name', 'like', '%' . $this->searchProduct . '%')
                ->orWhere('sku', 'like', '%' . $this->searchProduct . '%');
        }

        if (!empty($this->filterCategory)) {
            $productsQuery->where('category_id', $this->filterCategory);
        }

        $allCategories = Category::all();
        $allBrands = Brand::all();
        $allVendors = Vendor::all();

        return view('livewire.admin.inventory-manager', [
            'productsList' => $productsQuery->paginate(10),
            'categoriesList' => Category::with('parent')->latest()->paginate(10, ['*'], 'categoriesPage'),
            'categories' => $allCategories,
            'brands' => $allBrands,
            'vendors' => $allVendors
        ]);
    }
}
