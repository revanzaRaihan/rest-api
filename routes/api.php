<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\ProductController;
use App\Http\Controllers\API\PostController;
use App\Http\Controllers\API\AdminController;
use App\Http\Controllers\API\SellerController;
use App\Http\Controllers\API\OrderController;
use App\Http\Controllers\API\CartController;
use App\Http\Controllers\API\CheckoutController;
use App\Http\Controllers\API\NotificationController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// 🔹 AUTH (register, login, profile, logout)
Route::prefix('auth')->group(function () {
    // Public routes
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    // Protected routes
    Route::middleware('jwt')->group(function () {
        Route::get('me', [AuthController::class, 'me']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

// 🔹 PUBLIC ROUTES (accessible to everyone)
Route::get('products', [ProductController::class, 'index']);   // list all products
Route::get('products/{id}', [ProductController::class, 'show']); // product details
Route::get('posts', [PostController::class, 'index']);           // list all posts
Route::get('posts/{id}', [PostController::class, 'show']);      // post details

// 🔹 VIEWER ROUTES (authenticated, role: viewer)
Route::middleware(['jwt', 'role:viewer'])->group(function () {
    Route::get('orders', [OrderController::class, 'myOrders']); // viewer's own orders
    Route::post('cart', [CartController::class, 'add']);        // add to cart
    Route::get('cart', [CartController::class, 'show']);        // view cart
    Route::post('checkout', [CheckoutController::class, 'process']); // checkout
});

// 🔹 SELLER ROUTES (authenticated, role: seller)
Route::middleware(['jwt', 'role:seller'])->prefix('seller')->group(function () {
    Route::get('dashboard', [SellerController::class, 'dashboard']);
    Route::get('/products', [SellerController::class, 'products']);
    Route::apiResource('products', ProductController::class)
        ->except(['index', 'show']); // seller manages own products
    Route::get('orders', [OrderController::class, 'sellerOrders']); // orders related to seller
});

// 🔹 ADMIN ROUTES (authenticated, role: admin)
Route::middleware(['jwt', 'role:admin'])->prefix('admin')->group(function () {
    Route::apiResource('products', ProductController::class)
        ->except(['index', 'show']); // admin manages all products
    Route::get('users', [AdminController::class, 'manageUsers']);
    Route::get('sellers', [AdminController::class, 'manageSellers']);
    Route::get('reports', [AdminController::class, 'reports']);
    Route::get('settings', [AdminController::class, 'settings']);
    Route::apiResource('posts', PostController::class)
        ->except(['index', 'show']); // admin manages posts
});

// 🔹 NOTIFICATIONS (all authenticated users)
Route::middleware('jwt')->get('notifications', [NotificationController::class, 'index']);
