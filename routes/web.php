<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware(['auth', 'can:isUser'])->get('/', [\App\Http\Controllers\BookController::class, 'list'])->name('book.list');

Route::middleware(['auth', 'can:isUser'])->post('/add-to-cart', [\App\Http\Controllers\CartController::class, 'addToCart'])->name('cart.add');
Route::middleware(['auth', 'can:isUser'])->prefix('cart')->group(function (){
    Route::get('/', [\App\Http\Controllers\CartController::class, 'cart'])->name('cart.index');
    Route::post('/delete', [\App\Http\Controllers\CartController::class, 'deleteCart'])->name('cart.delete');
    Route::post('/checkout', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.checkout');
});

Route::middleware(['auth', 'can:isUser'])->prefix('return-book')->group(function (){
    Route::get('/', [\App\Http\Controllers\TransactionController::class, 'listTransaction'])->name('returnbook.index');
    Route::post('/return/{detailTransaction}', [\App\Http\Controllers\TransactionController::class, 'returnBook'])->name('returnbook.process');
    Route::get('/detail/{id}', [\App\Http\Controllers\TransactionController::class, 'detail'])->name('returnbook.detail');
});

Route::middleware(['auth', 'can:isAdmin'])->prefix('transaction')->group(function (){
    Route::get('/', [\App\Http\Controllers\TransactionController::class, 'index'])->name('transaction.index');
    Route::get('/detail/{id}', [\App\Http\Controllers\TransactionController::class, 'detail'])->name('transaction.detail');
});

Route::middleware(['auth', 'can:isAdmin'])->prefix('reporting')->group(function (){
    Route::get('/', [\App\Http\Controllers\ReportingController::class, 'index'])->name('reporting.index');
});

Route::get('/dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])->middleware(['auth', 'verified', 'can:isAdmin'])->name('dashboard');

Route::middleware(['auth', 'can:isAdmin'])->prefix('book-type')->group(function (){
    Route::get('/', [\App\Http\Controllers\BookTypeController::class, 'index'])->name('book_type.index');
    Route::post('/store', [\App\Http\Controllers\BookTypeController::class, 'store'])->name('book_type.store');
    Route::post('/delete/{bookType}', [\App\Http\Controllers\BookTypeController::class, 'destroy'])->name('book_type.delete');
    Route::post('/update/{bookType}', [\App\Http\Controllers\BookTypeController::class, 'update'])->name('book_type.update');
});

Route::middleware(['auth', 'can:isAdmin'])->prefix('book')->group(function (){
    Route::get('/', [\App\Http\Controllers\BookController::class, 'index'])->name('book.index');
    Route::post('/store', [\App\Http\Controllers\BookController::class, 'store'])->name('book.store');
    Route::post('/destroy/{book}', [\App\Http\Controllers\BookController::class, 'destroy'])->name('book.destroy');
    Route::post('/update/{book}', [\App\Http\Controllers\BookController::class, 'update'])->name('book.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
