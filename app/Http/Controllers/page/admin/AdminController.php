<?php

namespace App\Http\Controllers\page\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.trang-chu.index', [
            'title' => 'Dashboard',
        ]);
    }

    public function user()
    {
        return view('admin.user.index', [
            'title' => 'User',
        ]);
    }
    public function show()
    {
        return view('admin.user.show', [
            'title' => 'Danh sách người dùng'
        ]);
    }

    public function sanpham()
    {
        return view('admin.san-pham.index', [
            'title' => 'Sản phẩm'
        ]);
    }
    public function showSanpham()
    {
        return view('admin.san-pham.show', [
            'title' => 'Danh sách sản phẩm'
        ]);
    }

    public function donhang()
    {
        return view('admin.don-hang.index', [
            'title' => 'Đơn hàng'
        ]);
    }
}
