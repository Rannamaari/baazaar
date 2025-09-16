<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatalogController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\PreOrderController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationFlowController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\ThankYouController;
use Illuminate\Support\Facades\Route;

Route::get('/', [CatalogController::class, 'index'])->name('home');
Route::get('/categories', [CatalogController::class, 'categories'])->name('categories.index');
Route::get('/category/{slug}', [CatalogController::class, 'category'])->name('category.show');
Route::get('/product/{slug}', [CatalogController::class, 'show'])->name('product.show');

// Search Routes
Route::get('/search', [SearchController::class, 'index'])->name('search.index');
Route::get('/api/search/suggestions', [SearchController::class, 'suggestions'])->name('search.suggestions');

// Legal Pages
Route::get('/terms', [LegalController::class, 'terms'])->name('legal.terms');
Route::get('/privacy', [LegalController::class, 'privacy'])->name('legal.privacy');
Route::get('/refunds', [LegalController::class, 'refunds'])->name('legal.refunds');

Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::get('/cart/count', [CartController::class, 'count'])->name('cart.count');
Route::post('/cart/update/{product}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{product}', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified', 'address.setup'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Registration flow routes
    Route::get('/setup-addresses', [RegistrationFlowController::class, 'showAddressSetup'])->name('registration.address-setup');
    Route::post('/setup-addresses', [RegistrationFlowController::class, 'storeAddresses'])->name('registration.address-setup.store');
    Route::get('/skip-address-setup', [RegistrationFlowController::class, 'skipAddressSetup'])->name('registration.skip-address-setup');

    // Address management routes
    Route::resource('addresses', AddressController::class);
    Route::post('/addresses/{address}/set-default', [AddressController::class, 'setDefault'])->name('addresses.set-default');
    Route::get('/addresses/{atoll}/islands', [AddressController::class, 'getIslands'])->name('addresses.islands');

    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/place-order', [CheckoutController::class, 'place'])->name('checkout.place');
    Route::get('/thank-you', [ThankYouController::class, 'index'])->name('thank-you');

    // Pre-order routes
    Route::resource('pre-orders', PreOrderController::class)->only(['index', 'create', 'store', 'show']);
});

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

require __DIR__ . '/auth.php';
