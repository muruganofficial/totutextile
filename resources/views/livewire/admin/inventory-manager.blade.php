<div class="space-y-10 font-inter">
    
    <!-- Tab Navigation Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-6 border-b border-gray-200 dark:border-gray-800 pb-4">
        <div class="flex gap-4">
            <button 
                wire:click="switchTab('products')" 
                class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition duration-200
                    {{ $activeTab === 'products' ? 'bg-blue-600 text-white shadow' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 hover:text-gray-900' }}
                "
            >
                📦 Products Catalog
            </button>
            <button 
                wire:click="switchTab('categories')" 
                class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition duration-200
                    {{ $activeTab === 'categories' ? 'bg-blue-600 text-white shadow' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 hover:text-gray-900' }}
                "
            >
                📁 Categories Master
            </button>
            <button 
                wire:click="switchTab('stock')" 
                class="px-5 py-2.5 text-xs font-bold uppercase tracking-wider rounded-xl transition duration-200
                    {{ $activeTab === 'stock' ? 'bg-blue-600 text-white shadow' : 'text-gray-500 hover:bg-gray-100 dark:hover:bg-gray-900 hover:text-gray-900' }}
                "
            >
                ⚖️ Inventory Operations
            </button>
        </div>
        
        @if($activeTab === 'products' && !$showProductForm)
            <button 
                wire:click="toggleProductForm(true)" 
                class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition shadow-sm font-sans-action"
            >
                + Add New Product
            </button>
        @endif
    </div>

    <!-- Tab 1: Products Catalog -->
    @if($activeTab === 'products')
        
        @if($showProductForm)
            <!-- Product Form (Add / Edit Card) -->
            <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm space-y-8">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="font-extrabold text-sm uppercase tracking-wider text-gray-900 dark:text-white">
                        {{ $editingProductId ? 'Edit Product Details' : 'Add New Product to Atelier' }}
                    </h3>
                    <button wire:click="toggleProductForm(false)" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase">Cancel</button>
                </div>

                <form wire:submit="saveProduct" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <!-- Name -->
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Product Title</label>
                            <input type="text" wire:model="product_name" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                            @error('product_name') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <!-- SKU -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">SKU Reference</label>
                            <input type="text" wire:model="product_sku" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                            @error('product_sku') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-3">
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Description</label>
                            <textarea wire:model="product_description" rows="4" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white"></textarea>
                            @error('product_description') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <!-- Pricing & Cost -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Cost Price (₹)</label>
                            <input type="number" step="0.01" wire:model="product_cost_price" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                            @error('product_cost_price') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Selling Price (₹)</label>
                            <input type="number" step="0.01" wire:model="product_selling_price" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                            @error('product_selling_price') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">GST Rate (%)</label>
                            <input type="number" step="0.1" wire:model="product_gst_rate" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                            @error('product_gst_rate') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <!-- Relationships -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Category</label>
                            <select wire:model="product_category_id" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                                <option value="">Select Category</option>
                                @foreach($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            @error('product_category_id') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Brand</label>
                            <select wire:model="product_brand_id" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                                <option value="">Select Brand</option>
                                @foreach($brands as $br)
                                    <option value="{{ $br->id }}">{{ $br->name }}</option>
                                @endforeach
                            </select>
                            @error('product_brand_id') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Fabric Type</label>
                            <input type="text" placeholder="e.g. Silk, Linen, Cotton" wire:model="product_fabric_type" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                        </div>

                        <!-- Attributes -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Color Swatch (Hex or Name)</label>
                            <input type="text" placeholder="e.g. Royal Blue" wire:model="product_color" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Available Sizes (Comma-separated)</label>
                            <input type="text" wire:model="product_sizes" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Collections (Comma-separated)</label>
                            <input type="text" wire:model="product_collections" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                        </div>

                        <!-- Image Settings -->
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Product Image URL (e.g. Unsplash)</label>
                            <input type="text" wire:model="product_image_url" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Or Upload Image File</label>
                            <input type="file" wire:model="product_uploaded_image" class="mt-2 text-xs">
                            @error('product_uploaded_image') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <!-- Status & Flags -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-400">Status</label>
                            <select wire:model="product_status" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                                <option value="Draft">Draft</option>
                            </select>
                        </div>

                        <div class="md:col-span-2 flex flex-wrap gap-6 pt-6">
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                                <input type="checkbox" wire:model="product_is_featured" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                Featured Product
                            </label>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                                <input type="checkbox" wire:model="product_is_trending" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                Trending Tag
                            </label>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                                <input type="checkbox" wire:model="product_is_best_seller" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                Best Seller Tag
                            </label>
                            <label class="flex items-center gap-2 text-xs font-bold text-gray-700 dark:text-gray-300">
                                <input type="checkbox" wire:model="product_is_new_arrival" class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                New Arrival Tag
                            </label>
                        </div>

                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action">Save Product</button>
                        <button type="button" wire:click="toggleProductForm(false)" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action">Cancel</button>
                    </div>
                </form>
            </div>
        @else
            <!-- Filters & Product Table -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm space-y-6">
                <!-- Search & Filters -->
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                    <div>
                        <input 
                            type="text" 
                            wire:model.live="searchProduct" 
                            placeholder="Search by name or SKU..." 
                            class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-850 dark:text-white"
                        />
                    </div>
                    <div>
                        <select wire:model.live="filterCategory" class="w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-850 dark:text-white">
                            <option value="">All Categories</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Products Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
                    <table class="w-full text-left text-sm divide-y divide-gray-150 dark:divide-gray-800">
                        <thead class="bg-gray-55/60 dark:bg-gray-900/50 text-xs font-bold uppercase text-gray-400 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Product</th>
                                <th class="px-6 py-4">SKU</th>
                                <th class="px-6 py-4">Category</th>
                                <th class="px-6 py-4">Selling Price</th>
                                <th class="px-6 py-4">Stock</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                            @foreach($productsList as $product)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition text-gray-800 dark:text-gray-200">
                                    <td class="px-6 py-4 flex items-center gap-3">
                                        <div class="w-10 h-10 rounded bg-gray-100 dark:bg-gray-950 overflow-hidden flex-shrink-0 flex items-center justify-center">
                                            @if($product->images->first())
                                                <img src="{{ $product->images->first()->file_path }}" class="w-full h-full object-cover">
                                            @else
                                                <span class="text-[10px] text-gray-400 font-bold">LUX</span>
                                            @endif
                                        </div>
                                        <span class="font-bold line-clamp-1 text-xs">{{ $product->name }}</span>
                                    </td>
                                    <td class="px-6 py-4 text-xs font-mono">{{ $product->sku }}</td>
                                    <td class="px-6 py-4 text-xs">{{ $product->category->name ?? 'Uncategorized' }}</td>
                                    <td class="px-6 py-4 font-bold text-gray-900 dark:text-white">₹{{ number_format($product->selling_price, 2) }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                            {{ $product->total_stock <= 10 ? 'bg-rose-100 text-rose-700' : 'bg-slate-100 text-slate-700 dark:bg-gray-800 dark:text-gray-300' }}
                                        ">
                                            {{ $product->total_stock }} Units
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                            {{ $product->status === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400' }}
                                        ">
                                            {{ $product->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right flex items-center gap-2 justify-end">
                                        <button wire:click="toggleProductForm(true, {{ $product->id }})" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition">Edit</button>
                                        <button wire:click="deleteProduct({{ $product->id }})" onclick="confirm('Are you sure you want to archive this product?') || event.stopImmediatePropagation()" class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-xs font-bold hover:bg-rose-100 transition">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginations -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $productsList->links() }}
                </div>
                </div>
            </div>
        @endif

    @endif

    <!-- Tab 2: Categories Master -->
    @if($activeTab === 'categories')
        @if($showCategoryForm)
            <!-- Category Form (Add / Edit Card) -->
            <div class="bg-white dark:bg-gray-900 p-8 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm space-y-8">
                <div class="flex items-center justify-between border-b border-gray-100 dark:border-gray-800 pb-4">
                    <h3 class="font-extrabold text-sm uppercase tracking-wider text-gray-900 dark:text-white">
                        {{ $editingCategoryId ? 'Edit Category Details' : 'Create New Category Master' }}
                    </h3>
                    <button wire:click="toggleCategoryForm(false)" class="text-xs font-bold text-gray-400 hover:text-gray-600 uppercase">Cancel</button>
                </div>

                <form wire:submit="saveCategory" class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Category Name -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Category Name</label>
                            <input type="text" wire:model="category_name" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                            @error('category_name') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <!-- Parent Category -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Parent Category (For Subcategories)</label>
                            <select wire:model="category_parent_id" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white">
                                <option value="">None (Make Parent Category)</option>
                                @foreach($categories->where('parent_id', null) as $parentCat)
                                    @if(!$editingCategoryId || $parentCat->id != $editingCategoryId)
                                        <option value="{{ $parentCat->id }}">{{ $parentCat->name }}</option>
                                    @endif
                                @endforeach
                            </select>
                            @error('category_parent_id') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <!-- Description -->
                        <div class="md:col-span-2">
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Description</label>
                            <textarea wire:model="category_description" rows="3" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-800 dark:text-white"></textarea>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-455">Status</label>
                            <select wire:model="category_status" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                                <option value="Active">Active</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="pt-6 border-t border-gray-100 dark:border-gray-800 flex gap-4">
                        <button type="submit" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action">Save Category</button>
                        <button type="button" wire:click="toggleCategoryForm(false)" class="px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action">Cancel</button>
                    </div>
                </form>
            </div>
        @else
            <!-- Categories Table / List -->
            <div class="bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm space-y-6">
                
                <div class="flex justify-between items-center pb-2">
                    <h3 class="font-extrabold text-sm uppercase tracking-wider text-gray-900 dark:text-white">Categories & Subcategories</h3>
                    <button 
                        wire:click="toggleCategoryForm(true)" 
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition shadow-sm font-sans-action"
                    >
                        + Add New Category
                    </button>
                </div>

                <!-- Categories Table -->
                <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
                    <table class="w-full text-left text-sm divide-y divide-gray-150 dark:divide-gray-800">
                        <thead class="bg-gray-55/60 dark:bg-gray-900/50 text-xs font-bold uppercase text-gray-400 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Category Name</th>
                                <th class="px-6 py-4">Parent Category</th>
                                <th class="px-6 py-4">Description</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4 text-right">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                            @foreach($categoriesList as $cat)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition text-gray-800 dark:text-gray-200">
                                    <td class="px-6 py-4 text-xs font-bold text-gray-900 dark:text-white uppercase tracking-wider">{{ $cat->name }}</td>
                                    <td class="px-6 py-4 text-xs">
                                        @if($cat->parent)
                                            <span class="px-2 py-0.5 rounded text-[10px] font-bold bg-slate-100 dark:bg-gray-800 text-slate-700">
                                                Sub of: {{ $cat->parent->name }}
                                            </span>
                                        @else
                                            <span class="text-gray-400 italic">None (Parent)</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-xs line-clamp-1 max-w-[200px]">{{ $cat->description ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                            {{ $cat->status === 'Active' ? 'bg-emerald-100 text-emerald-700' : 'bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-400' }}
                                        ">
                                            {{ $cat->status }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right flex items-center gap-2 justify-end">
                                        <button wire:click="toggleCategoryForm(true, {{ $cat->id }})" class="px-3 py-1.5 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold hover:bg-blue-100 transition">Edit</button>
                                        <button wire:click="deleteCategory({{ $cat->id }})" onclick="confirm('Are you sure you want to delete this category?') || event.stopImmediatePropagation()" class="px-3 py-1.5 bg-rose-50 text-rose-600 rounded-lg text-xs font-bold hover:bg-rose-100 transition">Delete</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Paginations -->
                <div class="pt-4 border-t border-gray-100 dark:border-gray-800">
                    {{ $categoriesList->links() }}
                </div>

            </div>
        @endif
    @endif

    <!-- Tab 3: Inventory Stock adjustments -->
    @if($activeTab === 'stock')
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Stock adjustment form -->
            <div class="lg:col-span-1 bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm space-y-6">
                <h3 class="font-extrabold text-sm uppercase tracking-wider text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3">Adjust Stock Levels</h3>
                
                <form wire:submit="adjustStock" class="space-y-4">
                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Stock Item (Warehouse - Product)</label>
                        <select wire:model="selectedStockId" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                            <option value="">Select Item</option>
                            @foreach($stocks as $st)
                                <option value="{{ $st->id }}">{{ $st->warehouse->name }} | {{ $st->product->name }} (Current: {{ $st->quantity }})</option>
                            @endforeach
                        </select>
                        @error('selectedStockId') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Adjustment Quantity (Use negative values to deduct)</label>
                        <input type="number" wire:model="qtyAdjustment" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                        @error('qtyAdjustment') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Adjustment Reason</label>
                        <input type="text" wire:model="adjustmentReason" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                        @error('adjustmentReason') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                    </div>

                    <div class="pt-2">
                        <button type="submit" class="w-full px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action">Adjust Stock</button>
                    </div>
                </form>

                <!-- Stock transfer form -->
                <div class="border-t border-gray-100 dark:border-gray-800 my-6 pt-6 space-y-4">
                    <h3 class="font-extrabold text-sm uppercase tracking-wider text-gray-900 dark:text-white">Transfer Stock between Warehouses</h3>
                    
                    <form wire:submit="transferStock" class="space-y-4">
                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Product</label>
                            <select wire:model="selectedProductId" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                                <option value="">Select Product</option>
                                @foreach($products = \App\Models\Product::where('status', 'Active')->get() as $p)
                                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                                @endforeach
                            </select>
                            @error('selectedProductId') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Source Warehouse</label>
                            <select wire:model="sourceWarehouseId" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                            @error('sourceWarehouseId') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Target Warehouse</label>
                            <select wire:model="targetWarehouseId" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                                <option value="">Select Warehouse</option>
                                @foreach($warehouses as $wh)
                                    <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                                @endforeach
                            </select>
                            @error('targetWarehouseId') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label class="text-[10px] font-extrabold uppercase tracking-widest text-gray-450">Transfer Quantity</label>
                            <input type="number" wire:model="transferQuantity" class="mt-2 w-full px-4 py-2.5 rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900/50 text-xs focus:ring-1 focus:ring-blue-500 focus:border-blue-500 text-gray-855 dark:text-white">
                            @error('transferQuantity') <span class="text-[10px] text-rose-500 font-bold mt-1.5 block uppercase tracking-wider">{{ $message }}</span> @enderror
                        </div>

                        <div class="pt-2">
                            <button type="submit" class="w-full px-5 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl text-xs uppercase tracking-widest transition duration-300 font-sans-action font-bold">Transfer Stock</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Warehouse Stock list -->
            <div class="lg:col-span-2 bg-white dark:bg-gray-900 p-6 rounded-2xl border border-gray-150 dark:border-gray-800 shadow-sm space-y-6">
                <h3 class="font-extrabold text-sm uppercase tracking-wider text-gray-900 dark:text-white border-b border-gray-100 dark:border-gray-800 pb-3">Warehouse Stock Allocations</h3>
                
                <div class="overflow-x-auto rounded-xl border border-gray-100 dark:border-gray-800">
                    <table class="w-full text-left text-sm divide-y divide-gray-150 dark:divide-gray-800">
                        <thead class="bg-gray-55/60 dark:bg-gray-900/50 text-xs font-bold uppercase text-gray-400 tracking-wider">
                            <tr>
                                <th class="px-6 py-4">Warehouse</th>
                                <th class="px-6 py-4">Product Name</th>
                                <th class="px-6 py-4">Available Quantity</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 dark:divide-gray-850">
                            @foreach($stocks as $st)
                                <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/30 transition text-gray-800 dark:text-gray-200">
                                    <td class="px-6 py-4 text-xs font-bold uppercase">{{ $st->warehouse->name }}</td>
                                    <td class="px-6 py-4 text-xs font-semibold">{{ $st->product->name }}</td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-0.5 rounded text-[10px] font-bold 
                                            {{ $st->quantity <= $st->low_stock_threshold ? 'bg-rose-100 text-rose-700' : 'bg-emerald-100 text-emerald-700' }}
                                        ">
                                            {{ $st->quantity }} Units
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endif

</div>
