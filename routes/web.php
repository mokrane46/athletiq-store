<?php
use App\Http\Controllers\SubcategoryController;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;


// -------------------- AUTH ROUTES --------------------
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');
Route::get('/registration-success', fn() => view('registration_success'))->name('registration_success');

// -------------------- PUBLIC ROUTES --------------------
Route::get('/', [HomeController::class, 'index']);
Route::get('/about', fn() => view('about'));
Route::get('/contact', fn() => view('contact'));
Route::post('/contact/submit', [ContactController::class, 'submit'])->name('contact.submit');

// Category/Subcategory
Route::get('/category/{id}/sub', [CategoryController::class, 'showSubcategories'])->name('category.subcategories');
Route::get('/subcategory/{id}', [CategoryController::class, 'showProducts'])->name('subcategory.products');
Route::get('/subcategory/{id}/search', [CategoryController::class, 'searchProducts'])->name('subcategory.products.search');
Route::get('/gender/{gender}', [CategoryController::class, 'showByGender'])->name('category.gender');

// Orders
Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
Route::post('/orders/place', [OrderController::class, 'placeOrder'])->name('orders.place');

// Cart (protected)
    Route::get('/cart', [CartController::class, 'showCart'])->name('cart.show');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// Wishlist
use App\Http\Controllers\WishlistController;
Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index')->middleware('auth');
Route::post('/wishlist/add', [WishlistController::class, 'add'])->name('wishlist.add');
Route::post('/wishlist/remove/{id}', [WishlistController::class, 'remove'])->name('wishlist.remove');

//Product Page
use App\Http\Controllers\FrontendProductController;

Route::get('/products', [FrontendProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [FrontendProductController::class, 'search'])->name('products.search');
Route::get('/product/{id}', [FrontendProductController::class, 'show'])->name('product.show');
Route::get('/category/{id}', [CategoryController::class, 'show'])->name('category.show');

// Reviews
use App\Http\Controllers\ReviewController;
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store')->middleware('auth');

// Chatbot
use App\Http\Controllers\ChatController;
Route::post('/chat/message', [ChatController::class, 'sendMessage'])->name('chat.send');


// -------------------- ADMIN DASHBOARD --------------------

Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('dashboard');
    
    // Categories resource
    Route::resource('categories', AdminCategoryController::class);
    
    // Subcategory routes - FIXED
    Route::get('/categories/{categoryId}/subcategories', [SubcategoryController::class, 'index'])
         ->name('categories.subcategories.index');
    Route::post('/categories/{categoryId}/subcategories', [SubcategoryController::class, 'store'])
         ->name('categories.subcategories.store');
    Route::delete('/categories/{categoryId}/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])
         ->name('categories.subcategories.destroy');
    
    // Other resources
    Route::resource('products', ProductController::class);
    Route::resource('orders', AdminOrderController::class)->only(['index', 'update']);
});