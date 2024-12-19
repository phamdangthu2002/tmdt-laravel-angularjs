<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

class ApiDonhangCOntroller extends Controller
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

    public function donHangAll()
    {
        try {
            // Lấy tất cả các đơn hàng
            $donhang = Order::paginate(5);

            // Lấy thông tin người dùng cho từng đơn hàng
            $users = User::whereIn('id', $donhang->pluck('user_id'))->get()->keyBy('id');

            // Gán thông tin người dùng vào từng đơn hàng
            foreach ($donhang as $order) {
                $order->user = $users->get($order->user_id);
            }

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
            $donhang = OrderItem::where('order_id', $id)->with(['product.images', 'product.attributes', 'order.user'])->get();
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

    public function updateDonhang(Request $request, $id)
    {
        try {
            $donhang = Order::find($id);
            if (!$donhang) {
                return response()->json(['error' => 'Đơn hàng không tồn tại'], 404);
            }
            $donhang->update($request->all());
            return response()->json(
                ['message' => 'Cập nhật đơn hàng thành công'],
                200
            );
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

}
