<?php

namespace App\Http\Controllers\page\auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.dang-nhap', [
            'title' => 'Đăng Nhập'
        ]);
    }
    public function register(){
        return view('auth.dang-ky',[
            'title' => 'Đăng ký'
        ]);
    }
}
