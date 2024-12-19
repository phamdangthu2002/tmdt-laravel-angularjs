<?php

use App\Http\Controllers\page\admin\AdminController;
use App\Http\Controllers\page\admin\DanhmucController;
use App\Http\Controllers\page\auth\AuthController;
use App\Http\Controllers\page\user\UserController;
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
Route::prefix('auth')->group(function () {
    Route::get('/dang-nhap', [AuthController::class, 'login'])->name('login');
    Route::get('/dang-ky', [AuthController::class, 'register'])->name('register');
});

Route::get('/', [UserController::class, 'index']);
Route::prefix('user')->group(function () {
    Route::get('/san-pham-detail/{id}', [UserController::class, 'sanPhamDetail'])->name('user.sanPhamDetail');
    Route::get('/tim-kiem/{key}', [UserController::class, 'timKiem']);
    Route::get('/gio-hang', [UserController::class, 'gioHang']);
    Route::get('/don-hang',[UserController::class,'donHang']);
    Route::get('/danh-muc/{id}',[UserController::class,'danhMuc']);
    Route::get('/danh-muc/submenu/{id}',[UserController::class,'danhMucSub']);
});

Route::prefix('admin')->middleware('auth')->group(function () {
    Route::get('/', [AdminController::class, 'index'])->name('admin');

    //danh muc
    Route::get('/danh-muc', [DanhmucController::class, 'index'])->name('admin.danhmuc');
    Route::get('/show-danh-muc', [DanhmucController::class, 'show'])->name('admin.danhmuc.show');

    //user
    Route::get('/user', [AdminController::class, 'user'])->name('admin.user');
    Route::get('/show-user', [AdminController::class, 'show'])->name('admin.user.show');

    //san pham
    Route::get('/san-pham', [AdminController::class, 'sanpham'])->name('admin.sanpham');
    Route::get('/show-san-pham', [AdminController::class, 'showSanpham'])->name('admin.sanpham.show');

    //don hang
    Route::get('/don-hang', [AdminController::class, 'donhang'])->name('admin.donhang');
});
