<?php
use App\Http\Controllers\UserAuthenticateController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CartController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('api/users')->group(function () { 
    
    Route::post('user_authenticate/refreshToken', [UserAuthenticateController::class, 'refreshToken']);
    Route::post('user_authenticate/userRegister', [UserAuthenticateController::class, 'userRegister']);
    Route::post('user_authenticate/userLogin', [UserAuthenticateController::class, 'userLogin']);


    Route::get('home/banner', [HomeController::class, 'homeBanner'])->name('banner-home');
    Route::get('home/category', [HomeController::class, 'homeCategory'])->name('category-home');
    Route::get('home/trademark', [HomeController::class, 'homeTrademark'])->name('trademark-home');
    Route::get('home/product_images', [HomeController::class, 'homeProductImages'])->name('product-images-home');
    Route::get('home/product', [HomeController::class, 'homeProduct'])->name('product-home');
    Route::get('home/product_detail/{id}', [HomeController::class, 'homeProductDetail'])->name('product-detail-home');
    Route::put('home/put_product_heart/{id}', [HomeController::class, 'updateHeartProduct'])->name('heart-home-put');
    Route::post('home/post_contact', [HomeController::class, 'homeStoreContact'])->name('post_contact');
    
    Route::group(['middleware' => ['jwt.verify', 'auth:app-users']], function () {

        Route::put('user_authenticate/change_password', [UserAuthenticateController::class, 'changePassword']);
        Route::get('user_authenticate/user_info/{id}', [UserAuthenticateController::class, 'userInfo']);
        Route::get('user_authenticate/logout', [UserAuthenticateController::class, 'logout']);
        Route::put('home/delete_product_review', [HomeController::class, 'deleteProductReview'])->name('delete-product-review');
        Route::get('home/product_review', [HomeController::class, 'homeProductReview'])->name('product-review-home');
        Route::put('home/put_product_review/{id}', [HomeController::class, 'updateProductReview'])->name('put_product_review');
        Route::post('home/post_product_review', [HomeController::class, 'createProductReview'])->name('post_product_review');
        Route::delete('home/delete_product_review', [HomeController::class, 'deleteProductReview'])->name('delete_product_review');
        Route::put('home/user_post_contact', [HomeController::class, 'homeStoreContact'])->name('user_post_contact');
        Route::get('cart', [CartController::class, 'index'])->name('cart-user-index');
        Route::post('cart/store/{productId}', [CartController::class, 'store'])->name('cart-user-store');
        Route::put('cart/update/{productId}', [CartController::class, 'update'])->name('cart-user-update');
        Route::delete('cart/destroy/{productId}', [CartController::class, 'destroy'])->name('cart-user-destroy');


    });
    
});