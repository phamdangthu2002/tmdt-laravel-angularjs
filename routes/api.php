<?php

use App\Http\Controllers\api\admin\ApiCartContrller;
use App\Http\Controllers\api\admin\ApiDanhmucController;
use App\Http\Controllers\api\admin\ApiDonhangController;
use App\Http\Controllers\api\admin\ApiSanphamController;
use App\Http\Controllers\api\admin\ApiUserController;
use App\Http\Controllers\api\auth\ApiAuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//user
Route::resource('user', ApiUserController::class);

//danh muc
Route::resource('danh-muc', ApiDanhmucController::class);//->middleware('auth:sanctum');

//sanpham
Route::resource('san-pham', ApiSanphamController::class);//->middleware('auth:sanctum');
Route::get('/san-pham/ramdom/get-sanpham', [ApiSanphamController::class, 'sanphamRandom']);
Route::get('/san-pham/get-sanpham-id/{id}', [ApiSanphamController::class, 'getSanphamID']);
Route::get('/san-pham/get-sanpham-danhmuc-id/{id}', [ApiSanphamController::class, 'getSanphamDanhmucID']);
Route::get('/tim-kiem/{key}', [ApiSanphamController::class, 'timKiem']);
Route::get('/san-pham/image/{id}', [ApiSanphamController::class, 'getAllImage']);
Route::post('/san-pham/image', [ApiSanphamController::class, 'editImage']);
Route::delete('/san-pham/image/delete/{id}', [ApiSanphamController::class, 'deleteImage']);

//cart
Route::post('/cart/add', [ApiCartContrller::class, 'addCart']);
Route::get('/cart/get-cart', [ApiCartContrller::class, 'getCart']);
Route::post('/cart/payment', [ApiCartContrller::class, 'payment']);

//don hang
Route::get('/don-hang/{id}', [ApiDonhangController::class, 'donHang']);
Route::get('/dong-hang/get-don-hang/{id}', [ApiDonhangController::class, 'donHangID']);

//auth
Route::post('/auth/register', [ApiAuthController::class, 'register']);
Route::post('/auth/login', [ApiAuthController::class, 'login']);
Route::post('/auth/logout', [ApiAuthController::class, 'logout']);
