<?php

use App\Livewire\Shop\Home;
use App\Livewire\Shop\Catalog;
use App\Livewire\Shop\ProductDetail;
use App\Livewire\Shop\Cart;
use App\Livewire\Shop\Faqs;
use App\Livewire\Customer\Dashboard as CustomerDashboard;
use App\Livewire\Vendor\Dashboard as VendorDashboard;
use App\Livewire\Admin\Dashboard as AdminDashboard;
use App\Livewire\Admin\InventoryManager;
use App\Livewire\Admin\OrderManager;
use App\Livewire\Admin\EmployeeManager;
use App\Livewire\Admin\ReportManager;
use Illuminate\Support\Facades\Route;

// Public Front-End routes
Route::get('/', Home::class)->name('home');
Route::get('/shop', Catalog::class)->name('shop');
Route::get('/product/{slug}', ProductDetail::class)->name('product.detail');
Route::get('/cart', Cart::class)->name('cart');
Route::get('/faqs', Faqs::class)->name('faqs');

// Central Post-Login Redirector based on user role
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->hasRole('admin') || $user->hasRole('employee')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('vendor')) {
        return redirect()->route('vendor.dashboard');
    } else {
        return redirect()->route('customer.dashboard');
    }
})->middleware(['auth', 'verified'])->name('dashboard');

// Customer Panel Secure Routes
Route::middleware(['auth', 'verified', 'role:customer'])->prefix('customer')->group(function () {
    Route::get('/dashboard', CustomerDashboard::class)->name('customer.dashboard');
});

// Vendor Panel Secure Routes
Route::middleware(['auth', 'verified', 'role:vendor'])->prefix('vendor')->group(function () {
    Route::get('/dashboard', VendorDashboard::class)->name('vendor.dashboard');
});

// Admin Panel Secure Routes
Route::middleware(['auth', 'verified', 'role:admin|employee'])->prefix('admin')->group(function () {
    Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
    Route::get('/inventory', InventoryManager::class)->name('admin.inventory');
    Route::get('/orders', OrderManager::class)->name('admin.orders');
    Route::get('/employees', EmployeeManager::class)->name('admin.employees');
    Route::get('/reports', ReportManager::class)->name('admin.reports');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

// Dynamic logout route with role-specific redirects
Route::post('/logout', function (\App\Livewire\Actions\Logout $logout) {
    $user = auth()->user();
    $redirectUrl = '/';

    if ($user) {
        if ($user->hasRole('admin') || $user->hasRole('employee')) {
            $redirectUrl = '/login?role=admin';
        } elseif ($user->hasRole('vendor')) {
            $redirectUrl = '/login?role=vendor';
        }
    }

    $logout();

    return redirect($redirectUrl);
})->name('logout');

// Static CMS Page Routes
Route::view('/privacy', 'cms.privacy')->name('cms.privacy');
Route::view('/terms', 'cms.terms')->name('cms.terms');
Route::view('/shipping-refunds', 'cms.shipping-refunds')->name('cms.shipping-refunds');
Route::view('/locations', 'cms.locations')->name('cms.locations');
Route::view('/contact', 'cms.contact')->name('cms.contact');

require __DIR__.'/auth.php';
