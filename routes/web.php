<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminCategoryController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\DashboardPostController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegisterController;
use App\Models\Article;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Route;


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

Route::get('/', function() {
    return view('home', [
        "title" => "Home",
        'posts' => Post::all(),
        'categories' => Category::all()
    ]);
});

Route::get('/about', function () {
    return view('about', ["title" => "About"]);
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{post:slug}', [PostController::class, 'show'])->name('posts.show');

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{postId}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/categories', function() {
    return view('categories', [
        'title' => 'Post Categories',
        'categories' => Category::all()
    ]);
});
Route::get('/article', function() {
    return view('article', [
        'title' => 'Article',
        'articles' => Article::all()
    ]);
});
Route::get('/articles', function() {
    return view('articles', [
        'title' => 'Articles',
        'articles' => Article::all()
    ]);
});
Route::get('/login', [LoginController::class, 'index'])->name('login')->middleware('guest');
Route::post('/login', [LoginController::class, 'authenticate']);
Route::post('/logout', [LoginController::class, 'logout']);

Route::get('/register', [RegisterController::class, 'index'])->middleware('guest');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/dashboard', function() {
    return view('dashboard.index');
})->middleware('auth');

Route::get('/dashboard/posts/checkSlug', [DashboardPostController::class, 'checkSlug'])->middleware('auth');
Route::resource('/dashboard/posts', DashboardPostController::class)->middleware('auth');
Route::resource('/dashboard/articles', ArticleController::class)->middleware('auth');

Route::middleware('admin')->group(function () {
    Route::get('/dashboard/categories', [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/dashboard/categories/checkSlug', [AdminCategoryController::class, 'checkSlug']);
    Route::resource('/dashboard/categories', AdminCategoryController::class)->except('show');
});

Route::post('/orders/checkout', [OrderController::class, 'store'])->name('orders.store')->middleware('auth');
Route::get('orders/checkout', [OrderController::class, 'index'])->name('orders.checkout')->middleware('auth');
Route::resource('orders/address', OrderController::class)->middleware('auth');

Route::delete('/cart/delete/{postId}', [OrderController::class, 'deleteCartItem'])->name('cart.delete');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::post('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/profile/address', [AddressController::class, 'index'])->name('address.index');
    Route::resource('profile/address', AddressController::class);

});

Route::get('google/redirect', [GoogleController::class, 'redirect'])->name('google.redirect');
Route::get('/google/callback', [GoogleController::class, 'callback'])->name('google.callback');


Route::get('/orders/checkout', [OrderController::class, 'checkout'])->name('orders.checkout');
Route::post('/orders/store', [OrderController::class, 'storeAddress'])->name('orders.store');
Route::get('/orders/complete', [OrderController::class, 'complete'])->name('orders.complete');