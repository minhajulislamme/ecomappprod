<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminController\AdminController;
use App\Http\Controllers\UserController\UserController;
use App\Http\Controllers\Backend\Category\CategoryController;
use App\Http\Controllers\Backend\Category\SubcategoryController;
use App\Http\Controllers\Backend\Banner\BannerController;
use App\Http\Controllers\Backend\Slider\SliderController;
use App\Http\Controllers\Backend\Attribute\AttributeController;
use App\Http\Controllers\Backend\Product\ProductController;
use App\Http\Controllers\Backend\Product\ProductVariationController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\CartController;
use App\Http\Controllers\Frontend\WishlistController;

use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

// Frontend Routes
// Route::get('/', function () {
//     return view('frontend.index');
// })->name('home');

//Home Page Route
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/product-details/{id}/{slug}', [HomeController::class, 'ProductDetails'])->name('product.details');
Route::get('/product/category/{id}/{slug}', [HomeController::class, 'ProductCategory'])->name('product.category');
Route::get('/product/subcategory/{id}/{slug?}', [HomeController::class, 'ProductSubCategory'])->name('product.subcategory');
Route::get('/shop', [HomeController::class, 'Shop'])->name('shop');

// Cart Routes
Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart/get', [CartController::class, 'getCart'])->name('cart.get');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');

// Wishlist Routes
Route::post('/wishlist/add', [WishlistController::class, 'addToWishlist'])->name('wishlist.add');
Route::post('/wishlist/remove', [WishlistController::class, 'removeFromWishlist'])->name('wishlist.remove');
Route::get('/wishlist/get', [WishlistController::class, 'getWishlist'])->name('wishlist.get');
Route::get('/wishlist', [WishlistController::class, 'viewWishlist'])->name('wishlist.view');
Route::post('/wishlist/move-to-cart', [WishlistController::class, 'moveToCart'])->name('wishlist.move-to-cart');
Route::post('/wishlist/move-all-to-cart', [WishlistController::class, 'moveAllToCart'])->name('wishlist.move-all-to-cart');

// User Routes
Route::middleware(['auth', 'verified', 'user'])->group(function () {

    Route::get('/dashboard', [UserController::class, 'UserDashboard'])->name('user.dashboard');
    Route::get('/logout', [UserController::class, 'UserLogout'])->name('user.logout');
    Route::post('/profile/update', [UserController::class, 'UserProfileUpdate'])->name('user.profile.update');
    Route::post('/password/update', [UserController::class, 'UserPasswordUpdate'])->name('user.password.update');
});

// Admin Routes all the routes that are only accessible by the admin will be defined her
Route::middleware(['auth', 'verified', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'AdminDashboard'])->name('admin.dashboard');
    Route::get('/admin/logout', [AdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/admin/profile', [AdminController::class, 'AdminProfile'])->name('admin.profile');
    Route::post('/admin/profile/update', [AdminController::class, 'AdminProfileUpdate'])->name('admin.profile.update');
    Route::get('/admin/password', [AdminController::class, 'AdminPassword'])->name('admin.password');
    Route::post('/admin/password/update', [AdminController::class, 'AdminPasswordUpdate'])->name('admin.password.update');

    // All Category Routes
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/category', 'AllCategory')->name('all.category');
        Route::get('/category/add', 'CategoryAdd')->name('category.add');
        Route::post('/category/store', 'CategoryStore')->name('category.store');
        Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
        Route::post('/category/update', 'CategoryUpdate')->name('category.update');
        Route::post('/category/delete/{id}', 'CategoryDelete')->name('category.delete');
    });

    // All SubCategory Routes
    Route::controller(SubcategoryController::class)->group(function () {
        Route::get('/subcategory', 'AllSubCategory')->name('all.subcategory');
        Route::get('/subcategory/add', 'SubCategoryAdd')->name('subcategory.add');
        Route::post('/subcategory/store', 'SubCategoryStore')->name('subcategory.store');
        Route::get('/subcategory/edit/{id}', 'SubCategoryEdit')->name('subcategory.edit');
        Route::post('/subcategory/update/{id}', 'SubCategoryUpdate')->name('subcategory.update');
        Route::post('/subcategory/delete/{id}', 'SubCategoryDelete')->name('subcategory.delete');
        Route::get('/get-subcategories/{category_id}', 'getSubcategories')->name('get.subcategories');
    });

    // All Main Slider Routes
    Route::controller(SliderController::class)->group(function () {
        Route::get('/slider', 'AllSlider')->name('all.slider');
        Route::get('/slider/add', 'SliderAdd')->name('slider.add');
        Route::post('/slider/store', 'SliderStore')->name('slider.store');
        Route::get('/slider/edit/{id}', 'SliderEdit')->name('slider.edit');
        Route::post('/slider/update/{id}', 'SliderUpdate')->name('slider.update');
        Route::post('/slider/delete/{id}', 'SliderDelete')->name('slider.delete');
    });

    // All Banner Routes
    Route::controller(BannerController::class)->group(function () {
        Route::get('/banner', 'AllBanner')->name('all.banner');
        Route::get('/banner/add', 'BannerAdd')->name('banner.add');
        Route::post('/banner/store', 'BannerStore')->name('banner.store');
        Route::get('/banner/edit/{id}', 'BannerEdit')->name('banner.edit');
        Route::post('/banner/update/{id}', 'BannerUpdate')->name('banner.update');
        Route::post('/banner/delete/{id}', 'BannerDelete')->name('banner.delete');
    });

    // All Attribute Routes
    Route::controller(AttributeController::class)->group(function () {
        Route::get('/attribute', 'AllAttribute')->name('all.attribute');
        Route::get('/attribute/add', 'AttributeAdd')->name('attribute.add');
        Route::post('/attribute/store', 'AttributeStore')->name('attribute.store');
        Route::get('/attribute/edit/{id}', 'AttributeEdit')->name('attribute.edit');
        Route::post('/attribute/update/{id}', 'AttributeUpdate')->name('attribute.update');
        Route::post('/attribute/delete/{id}', 'AttributeDelete')->name('attribute.delete');
    });

    // All Product Routes
    Route::controller(ProductController::class)->group(function () {
        Route::get('/product', 'AllProduct')->name('all.product');
        Route::get('/product/add', 'ProductAdd')->name('product.add');
        Route::post('/product/store', 'ProductStore')->name('product.store');
        Route::get('/product/edit/{id}', 'ProductEdit')->name('product.edit');
        Route::post('/product/update/{id}', 'ProductUpdate')->name('product.update');
        Route::post('/product/delete/{id}', 'ProductDelete')->name('product.delete');
        Route::get('/product/get-subcategories/{category_id}', 'GetSubcategories')->name('product.subcategories');
    });

    // Product Variations Routes
    Route::controller(ProductVariationController::class)->group(function () {
        Route::get('/products/{product}/variations', 'index')->name('admin.products.variations.index');
        Route::get('/products/{product}/variations/create', 'create')->name('admin.products.variations.create');
        Route::post('/products/{product}/variations', 'store')->name('admin.products.variations.store');
        Route::get('/products/{product}/variations/{variation}/edit', 'edit')->name('admin.products.variations.edit');
        Route::post('/products/{product}/variations/{variation}/update', 'update')->name('admin.products.variations.update');
        Route::get('/products/{product}/variations/{variation}/delete', 'destroy')->name('admin.products.variations.destroy');
    });
});

// Super Admin Routes - define super admin accessible routes here
Route::middleware(['auth', 'verified', 'super_admin'])->group(function () {
    Route::get('/superadmin/dashboard', function () {
        return view('superadmin.super_admin');
    })->name('superadmin.dashboard');
});

// All public route
// admin login routes will be defined here
Route::get('/admin/login', [AdminController::class, 'AdminLogin'])->name('admin.login');
Route::post('/admin/login/store', [AdminController::class, 'AdminLoginStore'])->name('admin.login.store');

// Profile Routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
