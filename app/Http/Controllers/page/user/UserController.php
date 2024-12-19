<?php

namespace App\Http\Controllers\page\user;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        return view('user.trang-chu.index', [
            'title' => 'Trang chủ',
        ]);
    }

    public function sanPhamDetail()
    {
        return view('user.chi-tiet.index', [
            'title' => 'Chi tiết sản phẩm',
        ]);
    }
    public function timKiem()
    {
        return view('user.tim-kiem.index', [
            'title' => 'Tìm kiếm'
        ]);
    }

    public function gioHang()
    {
        return view('user.gio-hang.index', [
            'title' => 'Giỏ hàng'
        ]);
    }

    public function donHang()
    {
        return view('user.don-hang.index', [
            'title' => 'Đơn hàng'
        ]);
    }

    public function danhMuc(Request $request, $id)
    {
        return view('user.danh-muc.index', [
            'title' => 'Danh mục',
        ]);
    }

    public function danhMucSub($id)
    {
        return view('user.danh-muc.index', [
            'title' => 'Danh mục',
        ]);
    }
}
