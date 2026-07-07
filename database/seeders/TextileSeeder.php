<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Stock;
use App\Models\Supplier;
use App\Models\Warehouse;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\Blog;
use App\Models\User;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TextileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Warehouses
        $w1 = Warehouse::firstOrCreate(
            ['name' => 'Main Central Warehouse'],
            [
                'location' => 'Industrial Area Phase II, Hyderabad',
                'contact_info' => 'warehouse1@textileshop.com | +91 40 12345678',
            ]
        );
        $w2 = Warehouse::firstOrCreate(
            ['name' => 'Jubilee Hills Flagship Store Warehouse'],
            [
                'location' => 'Jubilee Hills Road No 36, Hyderabad',
                'contact_info' => 'store1@textileshop.com | +91 40 87654321',
            ]
        );

        // 2. Suppliers
        $sup1 = Supplier::firstOrCreate(
            ['name' => 'Texco Fabrics Ltd'],
            [
                'company' => 'Texco Textiles',
                'email' => 'sales@texco.com',
                'phone' => '+91 80 5555 1234',
                'address' => 'Cotton Market, Coimbatore, Tamil Nadu',
            ]
        );
        $sup2 = Supplier::firstOrCreate(
            ['name' => 'Kanchi Silk Mills'],
            [
                'company' => 'Kanchipuram Silk Exporters',
                'email' => 'contact@kanchisilk.com',
                'phone' => '+91 44 9876 5432',
                'address' => 'Weavers Street, Kanchipuram, Tamil Nadu',
            ]
        );

        // 3. Brands
        $brands = [
            ['name' => 'Kanchi Weaves', 'slug' => 'kanchi-weaves', 'description' => 'Traditional pure Kanchipuram silk sarees handwoven by artisans.'],
            ['name' => 'Loom Heritage', 'slug' => 'loom-heritage', 'description' => 'Handloom cottons, linen and artisanal ethnic wear.'],
            ['name' => 'Urban Stitch', 'slug' => 'urban-stitch', 'description' => 'Modern western wear, shirts, trousers and custom fit designer suits.'],
            ['name' => 'Little Blossoms', 'slug' => 'little-blossoms', 'description' => 'Organic cotton clothing for infants and kids.'],
        ];
        $brandIds = [];
        foreach ($brands as $b) {
            $created = Brand::firstOrCreate(['slug' => $b['slug']], $b);
            $brandIds[$b['slug']] = $created->id;
        }

        // 4. Categories & Sub-categories
        $ethnic = Category::firstOrCreate(['slug' => 'ethnic-wear'], ['name' => 'Ethnic Wear', 'description' => 'Traditional sarees, lehengas, and salwar suits.']);
        $western = Category::firstOrCreate(['slug' => 'western-wear'], ['name' => 'Western Wear', 'description' => 'Modern shirts, t-shirts, jeans, and trousers.']);
        $kids = Category::firstOrCreate(['slug' => 'kids-wear'], ['name' => 'Kids Wear', 'description' => 'Premium, soft clothing for babies and children.']);

        $sarees = Category::firstOrCreate(['slug' => 'sarees'], ['name' => 'Sarees', 'parent_id' => $ethnic->id]);
        
        // Leaf Sub-categories (Sarees -> Silk & Cotton)
        $silk_sarees = Category::firstOrCreate(['slug' => 'silk-sarees'], ['name' => 'Silk Sarees', 'parent_id' => $sarees->id]);
        $cotton_sarees = Category::firstOrCreate(['slug' => 'cotton-sarees'], ['name' => 'Cotton Sarees', 'parent_id' => $sarees->id]);
        
        // Leaf Sub-categories of Ethnic
        $lehengas = Category::firstOrCreate(['slug' => 'lehengas'], ['name' => 'Lehengas', 'parent_id' => $ethnic->id]);
        $kurti = Category::firstOrCreate(['slug' => 'kurtis-suits'], ['name' => 'Kurtis & Suits', 'parent_id' => $ethnic->id]);

        // Leaf Sub-categories of Western
        $shirts = Category::firstOrCreate(['slug' => 'shirts'], ['name' => 'Shirts', 'parent_id' => $western->id]);
        $tshirts = Category::firstOrCreate(['slug' => 't-shirts'], ['name' => 'T-Shirts', 'parent_id' => $western->id]);
        $trousers = Category::firstOrCreate(['slug' => 'trousers-jeans'], ['name' => 'Trousers & Jeans', 'parent_id' => $western->id]);

        // Get the Varanasi vendor seeded earlier
        $vendor = Vendor::first();

        // 5. Leaf Categories Mapping for Programmatic 20 Products Generation
        $categoriesMap = [
            [
                'category' => $silk_sarees,
                'brand_id' => $brandIds['kanchi-weaves'],
                'prefix' => 'SRK',
                'fabric_type' => 'Kanchipuram Silk',
                'adjectives' => ['Royal', 'Imperial', 'Heritage', 'Banarasi', 'Patola', 'Dharmavaram', 'Paithani', 'Varanasi', 'Chanderi', 'Kasavu'],
                'nouns' => ['Brocade Silk Saree', 'Zari Weft Saree', 'Jacquard Border Saree', 'Traditional Buta Saree'],
                'colors' => ['Crimson Red', 'Emerald Green', 'Royal Blue', 'Golden Yellow', 'Teal Blue', 'Deep Magenta', 'Lilac Pink'],
                'material' => 'Pure Mulberry Silk',
                'pattern' => 'Real Zari Brocade',
                'occasion' => 'Bridal, Wedding, Festive',
                'gender' => 'Women',
                'age_group' => 'Adults',
                'min_price' => 8000,
                'max_price' => 35000,
                'gst' => 5.00,
                'sizes' => null,
                'images' => [
                    'https://images.unsplash.com/photo-1610030469983-98e550d6193c?q=80&w=600',
                    'https://images.unsplash.com/photo-1583391733956-3750e0ff4e8b?q=80&w=600',
                    'https://images.unsplash.com/photo-1617627143750-d86bc21e42bb?q=80&w=600'
                ]
            ],
            [
                'category' => $cotton_sarees,
                'brand_id' => $brandIds['loom-heritage'],
                'prefix' => 'SRC',
                'fabric_type' => 'Mulmul Cotton',
                'adjectives' => ['Classic', 'Handspun', 'Jaipuri', 'Ajrakh', 'Kalamkari', 'Khadi', 'Mangalagiri', 'Jamdani'],
                'nouns' => ['Cotton Saree', 'Loom Saree', 'Summer Saree', 'Block Print Saree'],
                'colors' => ['Indigo Blue', 'Ivory White', 'Mint Green', 'Soft Peach', 'Terracotta Red', 'Lemon Yellow'],
                'material' => '100% Organic Cotton',
                'pattern' => 'Natural Dye Block Print',
                'occasion' => 'Casual, Daily Wear, Summer',
                'gender' => 'Women',
                'age_group' => 'Adults',
                'min_price' => 1200,
                'max_price' => 4500,
                'gst' => 5.00,
                'sizes' => null,
                'images' => [
                    'https://images.unsplash.com/photo-1608748010899-18f300247112?q=80&w=600',
                    'https://images.unsplash.com/photo-1508214751196-bcfd4ca60f91?q=80&w=600'
                ]
            ],
            [
                'category' => $lehengas,
                'brand_id' => $brandIds['kanchi-weaves'],
                'prefix' => 'LH',
                'fabric_type' => 'Organza / Silk',
                'adjectives' => ['Bridal', 'Royal Velvet', 'Sequined', 'Zardozi', 'Georgette Lehenga Choli', 'Mirror Work', 'Designer Floral'],
                'nouns' => ['Lehenga Set', 'Gharara Outfit', 'Wedding Lehenga'],
                'colors' => ['Rose Gold', 'Maroon Red', 'Midnight Blue', 'Champagne Gold', 'Mint Green', 'Orchid Purple'],
                'material' => 'Premium Raw Silk & Organza',
                'pattern' => 'Intricate Embroidery & Stones',
                'occasion' => 'Bridal, Wedding reception',
                'gender' => 'Women',
                'age_group' => 'Adults',
                'min_price' => 15000,
                'max_price' => 65000,
                'gst' => 12.00,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1595777457583-95e059d581b8?q=80&w=600',
                    'https://images.unsplash.com/photo-1610030470211-1ec853c65c69?q=80&w=600'
                ]
            ],
            [
                'category' => $kurti,
                'brand_id' => $brandIds['loom-heritage'],
                'prefix' => 'KR',
                'fabric_type' => 'Georgette / Rayon',
                'adjectives' => ['Lucknowi Chikankari', 'Anarkali Kurta', 'A-Line Straight', 'Jaipuri Printed', 'Angrakha ethnic', 'Festive Kurta set'],
                'nouns' => ['Kurta Set', 'Straight Kurti', 'Ethnic Tunic'],
                'colors' => ['Pastel Peach', 'Sky Blue', 'Mustard Yellow', 'Ivory White', 'Mint Green', 'Lilac Purple'],
                'material' => 'Fine Viscose Rayon & Georgette',
                'pattern' => 'Chikankari Hand Embroidery',
                'occasion' => 'Festive, Party, Office Wear',
                'gender' => 'Women',
                'age_group' => 'Adults',
                'min_price' => 1200,
                'max_price' => 5000,
                'gst' => 12.00,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1609357605129-26f69add5d6e?q=80&w=600',
                    'https://images.unsplash.com/photo-1583391265517-35bbdad01209?q=80&w=600'
                ]
            ],
            [
                'category' => $shirts,
                'brand_id' => $brandIds['urban-stitch'],
                'prefix' => 'SH',
                'fabric_type' => 'Egyptian Cotton',
                'adjectives' => ['Slim Fit', 'Oxford Formal', 'Linen Casual', 'Spread Collar Business', 'Royal Plain', 'Twill Structured'],
                'nouns' => ['Button-Down Shirt', 'Dress Shirt', 'Executive Shirt'],
                'colors' => ['Classic White', 'Sky Blue', 'Light Pink', 'Charcoal Gray', 'Navy Blue', 'Olive Green'],
                'material' => '100% Egyptian Cotton',
                'pattern' => 'Solid / Subtle Twill',
                'occasion' => 'Formal, Business, Casual',
                'gender' => 'Men',
                'age_group' => 'Adults',
                'min_price' => 1499,
                'max_price' => 3999,
                'gst' => 12.00,
                'sizes' => ['38', '40', '42', '44'],
                'images' => [
                    'https://images.unsplash.com/photo-1596755094514-f87e34085b2c?q=80&w=600',
                    'https://images.unsplash.com/photo-1620012253295-c05518e99309?q=80&w=600',
                    'https://images.unsplash.com/photo-1602810318383-e386cc2a3ccf?q=80&w=600'
                ]
            ],
            [
                'category' => $tshirts,
                'brand_id' => $brandIds['urban-stitch'],
                'prefix' => 'TS',
                'fabric_type' => 'Pima Cotton',
                'adjectives' => ['Crew Neck Sporty', 'Ribbed Henley', 'Classic Polo', 'Pique Polo Casual', 'V-Neck Premium'],
                'nouns' => ['T-Shirt', 'Polo T-Shirt', 'Athletic Tee'],
                'colors' => ['Classic Black', 'Heather Gray', 'Navy Blue', 'Burgundy', 'Olive Green', 'White'],
                'material' => 'Ultra Soft Pima Cotton',
                'pattern' => 'Solid Color',
                'occasion' => 'Casual, Active Wear',
                'gender' => 'Men',
                'age_group' => 'Adults',
                'min_price' => 799,
                'max_price' => 1899,
                'gst' => 12.00,
                'sizes' => ['S', 'M', 'L', 'XL'],
                'images' => [
                    'https://images.unsplash.com/photo-1521572267360-ee0c2909d518?q=80&w=600',
                    'https://images.unsplash.com/photo-1581655353564-df123a1eb820?q=80&w=600'
                ]
            ],
            [
                'category' => $trousers,
                'brand_id' => $brandIds['urban-stitch'],
                'prefix' => 'TR',
                'fabric_type' => 'Denim / Twill',
                'adjectives' => ['Slim Stretch Chino', 'Selvedge Denim', 'Structured Formal', 'Summer Linen', 'Straight Fit Jeans'],
                'nouns' => ['Trousers', 'Denim Jeans', 'Chinos'],
                'colors' => ['Khaki Brown', 'Navy Blue', 'Charcoal Black', 'Olive Green', 'Dark Indigo Blue', 'Stone Gray'],
                'material' => 'Cotton-Spandex Stretch Blend',
                'pattern' => 'Solid / Plain',
                'occasion' => 'Formal, Casual, Office Wear',
                'gender' => 'Men',
                'age_group' => 'Adults',
                'min_price' => 1800,
                'max_price' => 4500,
                'gst' => 12.00,
                'sizes' => ['30', '32', '34', '36', '38'],
                'images' => [
                    'https://images.unsplash.com/photo-1542272604-787c3835535d?q=80&w=600',
                    'https://images.unsplash.com/photo-1624378439575-d8705ad7ae80?q=80&w=600'
                ]
            ],
            [
                'category' => $kids,
                'brand_id' => $brandIds['little-blossoms'],
                'prefix' => 'KD',
                'fabric_type' => 'Organic Muslin',
                'adjectives' => ['Soft romper', 'Muslin Jumpsuit', 'Printed dungaree', 'Ethnic Kurta set', 'Organic cotton frocks'],
                'nouns' => ['Kids Wear', 'Infants Suit', 'Play Suit'],
                'colors' => ['Sunny Yellow', 'Baby Pink', 'Sky Blue', 'Mint Green', 'Soft White', 'Lavender Cream'],
                'material' => '100% GOTS Certified Organic Cotton',
                'pattern' => 'Cartoon / Botanical prints',
                'occasion' => 'Casual, Daily Play, Festive',
                'gender' => 'Unisex',
                'age_group' => 'Kids & Babies',
                'min_price' => 699,
                'max_price' => 2200,
                'gst' => 12.00,
                'sizes' => ['0-3M', '6-12M', '2-3Y', '4-5Y'],
                'images' => [
                    'https://images.unsplash.com/photo-1519457431-44ccd64a579b?q=80&w=600',
                    'https://images.unsplash.com/photo-1503919545889-aef636e10ad4?q=80&w=600'
                ]
            ],
        ];

        // Loop over each definition to programmatically generate AT LEAST 20 products
        foreach ($categoriesMap as $map) {
            $cat = $map['category'];
            
            for ($i = 1; $i <= 20; $i++) {
                // Determine names randomly/in sequence
                $adj = $map['adjectives'][($i - 1) % count($map['adjectives'])];
                $noun = $map['nouns'][($i - 1) % count($map['nouns'])];
                $color = $map['colors'][($i - 1) % count($map['colors'])];
                
                $pName = "{$adj} {$color} {$noun}";
                $slug = Str::slug($pName) . '-' . $i;
                $sku = $map['prefix'] . '-' . strtoupper(Str::random(3)) . '-' . str_pad($i, 3, '0', STR_PAD_LEFT);
                $barcode = '890' . rand(1000000000, 9999999999);

                $selling_price = rand($map['min_price'], $map['max_price']);
                $cost_price = round($selling_price * 0.45, 2);

                $attributes = [
                    'color' => $color,
                    'material' => $map['material'],
                    'pattern' => $map['pattern'],
                    'occasion' => $map['occasion'],
                    'gender' => $map['gender'],
                    'age_group' => $map['age_group'],
                ];

                if ($map['sizes']) {
                    $attributes['sizes'] = $map['sizes'];
                }

                // Collections tags
                $collections = [$map['category']->name, 'Atelier Signature'];
                if ($selling_price > 15000) {
                    $collections[] = 'Wedding Collection';
                    $collections[] = 'Bridal Collection';
                } else if ($selling_price < 2000) {
                    $collections[] = 'Summer Collection';
                }

                // Create the product
                $prod = Product::firstOrCreate(
                    ['sku' => $sku],
                    [
                        'category_id' => $cat->id,
                        'brand_id' => $map['brand_id'],
                        'vendor_id' => ($vendor && $i % 4 === 0) ? $vendor->id : null, // 25% vendor owned
                        'fabric_type' => $map['fabric_type'],
                        'name' => $pName,
                        'slug' => $slug,
                        'description' => "This premium piece represents the peak of modern atelier craftsmanship. Styled from premium {$map['material']} raw components woven in detailed structures.",
                        'care_instructions' => "Strictly Dry Clean. Warm iron on reverse side. Avoid direct perfumes or exposure to excessive heat.",
                        'barcode' => $barcode,
                        'cost_price' => $cost_price,
                        'selling_price' => $selling_price,
                        'gst_rate' => $map['gst'],
                        'status' => 'Active',
                        'attributes' => $attributes,
                        'collections' => $collections,
                        'is_featured' => ($i % 5 === 0),
                        'is_trending' => ($i % 6 === 0),
                        'is_best_seller' => ($i % 7 === 0),
                        'is_new_arrival' => ($i % 4 === 0),
                    ]
                );

                // Add distinct image URLs
                $imgUrl = $map['images'][($i - 1) % count($map['images'])];
                ProductImage::firstOrCreate(
                    ['product_id' => $prod->id, 'sort_order' => 0],
                    [
                        'file_path' => $imgUrl,
                        'is_featured' => true,
                    ]
                );

                // Add stocks in warehouses
                Stock::firstOrCreate(
                    ['warehouse_id' => $w1->id, 'product_id' => $prod->id],
                    ['quantity' => rand(40, 80), 'low_stock_threshold' => 10]
                );

                Stock::firstOrCreate(
                    ['warehouse_id' => $w2->id, 'product_id' => $prod->id],
                    ['quantity' => rand(5, 20), 'low_stock_threshold' => 5]
                );
            }
        }

        // 6. Testimonials
        $testimonials = [
            [
                'client_name' => 'Meera Krishnan',
                'role' => 'Bride-to-be',
                'company' => 'Wedding Client',
                'review' => 'The Kanchipuram wedding silk saree I purchased here is absolute perfection! The weight, pure zari sheen, and design blew everyone away. Their bridal team made the shopping experience so luxury and effortless.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Vikram Aditya',
                'role' => 'Executive Director',
                'company' => 'V-Consulting',
                'review' => 'Exceptional quality shirts. The Egyptian cotton slim fit is my daily corporate wear. It fits perfectly, stays crisp, and feels extremely premium compared to expensive retail brands.',
                'rating' => 5,
            ],
            [
                'client_name' => 'Priya Sharma',
                'role' => 'Fashion Blogger',
                'company' => 'The Ethnic Runway',
                'review' => 'I love their handloom Mulmul collection! It is extremely breathable and soft, perfect for Indian summers. Highly recommend their sustainable fashion range.',
                'rating' => 4,
            ]
        ];
        foreach ($testimonials as $t) {
            Testimonial::firstOrCreate(['client_name' => $t['client_name']], $t);
        }

        // 7. FAQs
        $faqs = [
            [
                'question' => 'Are your silk sarees certified with Silk Mark?',
                'answer' => 'Yes! All our premium silk sarees, including Kanchipuram, Banarasi, and Mysore silks, come with the official Silk Mark Organisation of India (SMOI) tag guaranteeing 100% pure silk.',
                'category' => 'General',
            ],
            [
                'question' => 'Do you ship internationally?',
                'answer' => 'Yes, we ship to over 50 countries worldwide including the USA, UK, Canada, UAE, and Australia. International shipping charges and customs fees are calculated at checkout.',
                'category' => 'Shipping',
            ],
            [
                'question' => 'What is your return and exchange policy?',
                'answer' => 'We offer a 7-day hassle-free return and exchange policy for unused items in their original packaging with tags intact. Handloom and custom-tailored garments are eligible for size adjustments only.',
                'category' => 'Returns',
            ]
        ];
        foreach ($faqs as $f) {
            Faq::firstOrCreate(['question' => $f['question']], $f);
        }

        // 8. Blogs
        $author = User::whereHas('roles', function($q) { $q->where('name', 'admin'); })->first();
        if ($author) {
            Blog::firstOrCreate(
                ['slug' => 'the-art-of-weaving-kanchipuram-silk'],
                [
                    'author_id' => $author->id,
                    'title' => 'The Art of Weaving Kanchipuram Silk: An Ancient Heritage',
                    'summary' => 'Discover the rich history, intricate processes, and pure gold zari craftsmanship that defines the legendary Kanchipuram silk saree.',
                    'content' => 'Kanchipuram silk sarees are known for their premium quality silk and heavy gold-dipped silver zari work. Originating in Kanchipuram, Tamil Nadu, these sarees have been the crowning glory of South Indian brides for centuries. In this post, we look at the double-warp technique and how our weavers create contrasting borders that define genuine luxury...',
                    'featured_image' => 'assets/images/blog/kanchi-weaving.jpg',
                    'status' => 'Published',
                ]
            );

            Blog::firstOrCreate(
                ['slug' => 'textile-care-tips-festive-garments'],
                [
                    'author_id' => $author->id,
                    'title' => '5 Essential Textile Care Tips for Festive Garments',
                    'summary' => 'How to store and clean your expensive silks, georgettes, and embroidered kurtis to keep them looking brand new.',
                    'content' => 'Festive wear represents an investment in heritage. To keep your silks and embroidered outfits clean and shiny, follow our guidelines: 1) Never iron directly on zari or embroidery, always iron on reverse. 2) Avoid spraying perfumes directly on fabrics. 3) Dry clean silks and georgettes...',
                    'featured_image' => 'assets/images/blog/fabric-care.jpg',
                    'status' => 'Published',
                ]
            );
        }
    }
}
