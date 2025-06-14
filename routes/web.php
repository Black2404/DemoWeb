<?php

use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\BookController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;


Route::prefix('admin')->group(function () {
    Route::get('/manageu', [AdminController::class, 'index1'])->name('admin.manageu.index1');
    Route::post('/manageu', [AdminController::class, 'store'])->name('admin.manageu.store');
    Route::delete('/manageu/{id}', [AdminController::class, 'destroy'])->name('admin.manageu.destroy');
    Route::get('/manageu/{id}/edit', [AdminController::class, 'edit'])->name('admin.manageu.edit');
    Route::put('/manageu/{id}', [AdminController::class, 'update'])->name('admin.manageu.update');
    
    Route::get('/manageb', [BookController::class, 'index5'])->name('admin.manageb.index5');
    Route::post('/manageb', [BookController::class, 'store'])->name('admin.manageb.store');
    Route::get('/manageb/{id}/edit', [BookController::class, 'edit'])->name('admin.manageb.edit');
    Route::put('/manageb/{id}', [BookController::class, 'update'])->name('admin.manageb.update');
    Route::delete('/manageb/{id}', [BookController::class, 'destroy'])->name('admin.manageb.destroy');
    
    Route::get('/managec', [ContactController::class, 'index2'])->name('admin.managec.index2');
    Route::delete('/managec/{id}', [ContactController::class, 'destroy'])->name('admin.managec.destroy');

    Route::get('/manageo', [OrderController::class, 'index'])->name('orders.index'); // Danh sách đơn hàng
    Route::get('/manageo/{order}', [OrderController::class, 'show'])->name('orders.show'); // Chi tiết đơn hàng
    Route::put('/manageo/{order}', [OrderController::class, 'update'])->name('orders.update'); // Cập nhật trạng thái
    Route::delete('/manageo/{order}', [OrderController::class, 'destroy'])->name('orders.destroy'); // Xóa đơn hàng
});

Route::get('user/dashboard', [BookController::class, 'index1'])->name('books.index1');

Route::get('/home', [BookController::class, 'index2'])->name('books.index2');

Route::get('/books', [BookController::class, 'index3'])->name('books.index3');

Route::get('user/books', [BookController::class, 'index4'])->name('books.index4');

Route::get('/login', [LoginController::class, 'showLogin'])->name('login');
Route::post('/login', [LoginController::class, 'login']);

Route::get('/register', [RegisterController::class, 'showRegister'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);

Route::get('admin/dashboard', [AdminController::class, 'index'])->name('admin')->middleware('auth');
Route::get('user/dashboard', [BookController::class, 'index1'])->name('user')->middleware('auth');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/login'); // Chuyển hướng về trang login
})->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('user/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('user/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::get('/contact', [ContactController::class, 'showContactForm'])->name('contact.form');
Route::get('/user/contact', [ContactController::class, 'showUserContactForm'])->name('user.contact.form');

Route::post('/contact', [ContactController::class, 'store'])->name('contact.submit');

Route::prefix('user')->group(function () {
    Route::get('/book/{id}', [BookController::class, 'userShow'])->name('user.book.show'); 
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('/order', [OrderController::class, 'placeOrder'])->name('order.place');
    Route::get('/order', [OrderController::class, 'orderPage'])->name('user.book.order');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/checkout/process', [OrderController::class, 'processCheckout'])->name('user.checkout.process');

    Route::post('/books/{book}/review', [CartController::class, 'addReview'])->name('review.add');
    Route::post('/reviews/{review}/update', [CartController::class, 'updateReview'])->name('review.update');
    Route::delete('/review/{id}', [CartController::class, 'deleteReview'])->name('review.delete');


});
Route::delete('/cart/remove/{cartId}', [CartController::class, 'removeFromCart'])->name('cart.remove');

Route::get('/books/{id}', [BookController::class, 'show'])->name('books.show'); 
Route::get('/cart', [CartController::class, 'cart'])->name('cart');
Route::post('/cart/add/{id}', [CartController::class, 'requireLogin'])->name('cart.requireLogin');
Route::post('/order', [OrderController::class, 'placeOrder'])->name('order.place');


