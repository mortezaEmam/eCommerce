<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\Admin\PermissionConroller;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\CartController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController;
use App\Http\Controllers\Home\CommentController as HomeCommentController;
use App\Http\Controllers\Home\CompareController;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\Home\PaymentController;
use App\Http\Controllers\Home\ProductController as HomeProductController;
use App\Http\Controllers\Home\OrderController as HomeOrderController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Home\ProvinceController;
use App\Http\Controllers\Home\UserAddressController;
use App\Http\Controllers\Home\UserProfileController;
use App\Http\Controllers\Home\WishListController;
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

Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');
Route::prefix('admin-panel/management')->name('admin.')->group(function (){

    Route::resource('brands', BrandController::class);
    Route::resource('users', UserController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('coupons',CouponController::class);
    Route::resource('orders', AdminOrderController::class);
    Route::resource('transactions', TransactionController::class);
    Route::resource('permissions', PermissionConroller::class);
    Route::resource('roles', RoleController::class);
    //get change approve comments
    Route::get('/comments/{comment}/change-approved' ,[CommentController::class , 'changeApproved'])->name('comments.change-approved');

    // Get Category Attributes
    Route::get('/category-attributes/{category}' ,[CategoryController::class , 'getCategoryAttributes']);

    // Edit Product Image
    Route::get('/products/{product}/images-edit' ,[ProductImageController::class , 'edit'])->name('products.images.edit');
    Route::delete('/products/{product}/images-destroy' ,[ProductImageController::class , 'destroy'])->name('products.images.destroy');
    Route::put('/products/{product}/images-set-primary' ,[ProductImageController::class , 'setPrimary'])->name('products.images.set_primary');
    Route::post('/products/{product}/images-add' ,[ProductImageController::class , 'add'])->name('products.images.add');
    //Edit product category
    Route::get('/products/{product}/edit-category-product' ,[ProductController::class , 'editProductCategory'])->name('products.category.edit');
    Route::put('/products/{product}/update-category-product' ,[ProductController::class , 'updateProductCategory'])->name('products.updateProductCategory');
});
Route::get('/',[HomeController::class,'index'])->name('home.index');
Route::get('/categories/{category:slug}',[HomeCategoryController::class,'show'])->name('home.categories.show');
Route::get('/product-details/{product:slug}',[HomeProductController::class,'show'])->name('home.products.show');
Route::post('/comment/{product}/',[HomeCommentController::class ,'store'])->name('home.comments.store');
Route::get('/add-to-wishlist/{product}/',[WishListController::class ,'add'])->name('home.wishlist.add');
Route::get('/remove-from-wishlist/{product}/',[WishListController::class ,'remove'])->name('home.wishlist.remove');
Route::get('/add-to-compare/{product}/',[CompareController::class ,'add'])->name('home.compare.add');
Route::get('/remove-from-compare/{product}/',[CompareController::class ,'remove'])->name('home.compare.remove');
Route::get('/compare',[CompareController::class ,'index'])->name('home.compare.index');
Route::post('/add_to_cart',[CartController::class ,'add'])->name('home.cart.add');
Route::get('/cart',[CartController::class ,'index'])->name('home.cart.index');
Route::put('/update-cart',[CartController::class ,'update'])->name('home.cart.update');
Route::get('/remove-from-cart/{rowId}',[CartController::class ,'remove'])->name('home.cart.remove');
Route::get('/clear-cart',[CartController::class ,'clear'])->name('home.cart.clear');
Route::post('/check-coupon',[CartController::class ,'checkCoupon'])->name('home.cart.check_coupon');
Route::get('/checkout',[CartController::class,'checkout'])->middleware(['auth'])->name('home.cart.checkout');


Route::get('/about-us', [HomeController::class, 'aboutUs'])->name('home.about-us');
Route::get('/contact-us', [HomeController::class, 'contactUs'])->name('home.contact-us');
Route::post('/contact-us-form', [HomeController::class, 'contactUsForm'])->name('home.contact-us.form');

Route::post('/payment',[PaymentController::class,'payment'])->name('home.payment');
Route::get('/payment-verify/{gatewayName}', [PaymentController::class, 'paymentVerify'])->name('home.payment_verify');

//Routes users_profile
Route::prefix('/profile')->name('home.')->group(function (){
    Route::get('/',[UserProfileController::class,'index'])->name('user-profile.index');
    Route::get('/comments',[HomeCommentController::class,'usersProfileIndex'])->name('comment.users-profile-index');
    Route::get('/wishlists',[WishlistController::class,'usersProfileIndex'])->name('wishlists.users-profile-index');
    Route::get('/orders',[HomeOrderController::class,'usersProfileIndex'])->name('orders.users-profile-index');
    Route::get('/address-users',[UserAddressController::class,'Index'])->name('address-users.users-profile-index');
    Route::post('/address-users/{userAddress}',[UserAddressController::class,'Update'])->name('address-users.users-profile-update');
    Route::post('/address_users_store',[UserAddressController::class,'Store'])->name('users_profile.address_users_store');
    Route::post('/get_show_orders',[HomeOrderController::class,'showOrderDetail'])->name('profile.get_show_order_detail');

});

Route::post('provinces/get-cities', [ProvinceController::class, 'getCities'])->name('provinces.get-cities');


//Login With Google
Route::get('/login/{provider}',[AuthController::class,'RedirectToProvider'])->name('auth.provider-to-redirect');
Route::get('/login/{provider}/callback',[AuthController::class,'handelProviderCallback']);


Route::get('/test',function (){

});
