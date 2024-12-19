<?php

namespace App\Http\Controllers\page\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DanhmucController extends Controller
{
    public function index()
    {
        return view('admin.danh-muc.index', [
            'title' => 'Thêm danh mục',
        ]);
    }
    public function show()
    {
        return view('admin.danh-muc.show', [
            'title' => 'Danh sách danh mục',
        ]);
    }
}

