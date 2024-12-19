<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiImageController extends Controller
{
    public function danhMuc($id)
    {
        // Lấy tất cả danh mục con của danh mục cha có parent_id = $id
        $danhMuc = DB::table('categories')->where('parent_id', $id)->get();

        // Kiểm tra nếu không có danh mục con nào
        if ($danhMuc->isEmpty()) {
            return response()->json(['message' => 'Danh mục không tồn tại'], 404);
        }

        // Lấy các sản phẩm thuộc các danh mục con
        $sanphams = Product::whereIn('category_id', $danhMuc->pluck('id'))->with('images')->paginate(8);

        // Trả về sản phẩm kèm theo phân trang
        return response()->json([
            'sanphams' => $sanphams,
        ], 200);
    }


    public function danhMucSub($id)
    {
        // Lấy tất cả sản phẩm thuộc danh mục có ID là $id và kèm theo hình ảnh
        $sanphams = Product::where('category_id', $id) // Sử dụng mô hình Product
            ->with('images') // Lấy thông tin hình ảnh
            ->paginate(8); // Phân trang

        // Trả về danh mục con với sản phẩm và hình ảnh kèm theo
        return response()->json(['sanphams' => $sanphams], 200);
    }

}
