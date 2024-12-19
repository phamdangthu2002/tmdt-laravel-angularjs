<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Exception;
use Illuminate\Http\Request;

class ApiDonhangController extends Controller
{
    public function donHang($id)
    {
        try {
            // Lấy các đơn hàng của người dùng với phân trang
            $donhang = Order::where('user_id', $id)->paginate(3);

            return response()->json([
                'donhang' => $donhang,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function donHangID($id)
    {
        try {
            // Lấy thông tin đơn hàng theo id
            $donhang = OrderItem::where('order_id', $id)->with(['product.images', 'product.attributes'])->get();
            if (!$donhang) {
                return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
            }
            return response()->json([
                'donhang' => $donhang,
            ], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
