<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Home\CategoryController as HomeCategoryController ;
use App\Http\Controllers\Home\ProductController as HomeProductController ;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductImageController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Home\HomeController;
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
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('banners', BannerController::class);

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

//Login With Google

Route::get('/login/{provider}',[AuthController::class,'RedirectToProvider'])->name('auth.provider-to-redirect');
Route::get('/login/{provider}/callback',[AuthController::class,'handelProviderCallback']);
Route::get('/test',function (){
//    $template = "قالب شماره 21045";
//    $param1 = "14441";
//    $receptor = "09154868372";
//    $type = 1; // 1: sms , 2: voice
//    $api = new \Ghasedak\GhasedakApi(env('GHASEDAKAPI_KEY'));
//    $api->Verify( $receptor, $type, $template, $param1);
//
//    $sender = "1000596446";
//    $receptor = "09154868372";
//    $message = ".وب سرویس پیام کوتاه کاوه نگار";
//    $api = new \Kavenegar\KavenegarApi("444D785A696C54793948476D43735753374774695A746D4748416B4A5374736A32615256506F634D5847303D");
//    $api -> Send ( $sender,$receptor,$message,12233);
});
