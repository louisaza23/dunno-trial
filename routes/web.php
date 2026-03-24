<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/admin-dashboard', function () {
    return view('admin.dashboard');
})->middleware(['auth', 'verified'])->name('admin-dashboard');

Route::middleware('auth')->group(function () {
    // ROUTE FOR ADMIN
    Route::get('list-product', [AdminController::class, 'getListProduct'])->name('list-product');
    Route::post('store-product', [AdminController::class, 'store'])->name('store-product');
    Route::delete('product-by/{productId}', [AdminController::class, 'deleteProduct'])->name('product.delete');
    Route::get('product-by/{productId}/edit', [AdminController::class, 'getProductBy'])->name('product.edit');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
