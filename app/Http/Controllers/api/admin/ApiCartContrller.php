<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiCartContrller extends Controller
{
    public function addCart(Request $request)
    {
        $user_id = $request->user_id;
        $product_id = $request->product_id;
        $quantity = $request->quantity;

        // Kiểm tra đầu vào
        if (!$user_id || !$product_id || !$quantity || $quantity <= 0) {
            return response()->json([
                'message' => 'Dữ liệu không hợp lệ',
                'data' => null,
                'status' => 400
            ]);
        }

        // Lấy thông tin sản phẩm
        $sanpham = DB::table('products')
            ->select('price', 'discount')
            ->where('id', $product_id)
            ->first();

        if ($sanpham) {
            // Tính giá cuối cùng
            $price = ($sanpham->discount > 0) ? $sanpham->discount : $sanpham->price;

            // Kiểm tra xem sản phẩm đã tồn tại trong giỏ hàng hay chưa
            $existingCart = DB::table('carts')
                ->where('user_id', $user_id)
                ->where('product_id', $product_id)
                ->where('status', 'active')
                ->first();

            if ($existingCart) {
                // Nếu đã tồn tại, cập nhật số lượng
                DB::table('carts')
                    ->where('id', $existingCart->id)
                    ->update([
                        'quantity' => $existingCart->quantity + $quantity,
                        'updated_at' => Carbon::now(),
                    ]);

                // Lấy dữ liệu cập nhật để trả về
                $updatedCart = DB::table('carts')->where('id', $existingCart->id)->first();

                return response()->json([
                    'message' => 'Cập nhật số lượng sản phẩm thành công',
                    'data' => $updatedCart,
                    'status' => 200
                ]);
            } else {
                // Nếu chưa, thêm mới vào giỏ hàng
                $cartId = DB::table('carts')->insertGetId([
                    'user_id' => $user_id,
                    'product_id' => $product_id,
                    'product_attribute_id' => $product_id, // Nếu không dùng thuộc tính sản phẩm
                    'quantity' => $quantity,
                    'price' => $price,
                    'created_at' => Carbon::now(),
                ]);

                // Lấy dữ liệu vừa thêm để trả về
                $newCart = DB::table('carts')->where('id', $cartId)->first();

                return response()->json([
                    'message' => 'Thêm sản phẩm vào giỏ hàng thành công',
                    'data' => $newCart,
                    'status' => 200
                ]);
            }
        }

        return response()->json(['message' => 'Sản phẩm không tồn tại'], 404);
    }

    public function getCart()
    {
        $user_id = auth()->id(); // Lấy ID người dùng đang đăng nhập

        // Truy vấn giỏ hàng và các thông tin liên quan
        $carts = DB::select(
            "SELECT 
                carts.id, 
                carts.quantity, 
                carts.price, 
                product_attributes.ram, 
                product_attributes.rom, 
                product_attributes.color, 
                products.name AS product_name, 
                products.price AS product_price, 
                products.discount, 
                product_images.image_path AS product_image
            FROM carts
            JOIN products ON carts.product_id = products.id
            LEFT JOIN product_images ON product_images.product_id = products.id AND product_images.id = (
                SELECT id FROM product_images WHERE product_id = products.id LIMIT 1
            )
            JOIN product_attributes ON product_attributes.product_id = products.id
            WHERE carts.user_id = ? 
            AND carts.status = 'active'", // Thêm điều kiện status = 'active'
            [$user_id]
        );


        // Tính tổng tiền
        $total = 0;
        foreach ($carts as $cart) {
            $total += $cart->price * $cart->quantity;
        }

        return response()->json([
            'message' => 'Lấy dữ liệu giỏ hàng thành công',
            'carts' => $carts,
            'total' => $total,
            'status' => 200
        ]);
    }

    public function payment(Request $request)
    {
        // Lấy thông tin người dùng
        $user_id = $request->input('user_id');
        $address = $request->input('address');
        $phone = $request->input('phone');
        $total = $request->input('total');
        $quantity = $request->input('quantity');

        $user = User::find($user_id);
        $user->address = $address;
        $user->phone = $phone;
        $user->save();

        try {
            // Tạo đơn hàng mới
            $order = Order::create([
                'user_id' => $user_id,
                'total_amount' => $total,
                'status' => 'pending',
                'created_at' => Carbon::now(),
            ]);

            // Lấy giỏ hàng của người dùng
            $carts = Cart::where('user_id', $user_id)->get();

            // Duyệt qua từng sản phẩm trong giỏ hàng và tạo OrderItem
            foreach ($carts as $cart) {
                // Tìm sản phẩm tương ứng
                $product = Product::find($cart->product_id);

                // Tạo OrderItem cho mỗi sản phẩm trong giỏ hàng
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $cart->quantity,  // Dùng quantity từ cart
                    'price' => $product->price,
                    'discount' => $product->discount,
                    'total' => $cart->quantity * $product->price - $product->discount,  // Tính tổng tiền cho OrderItem
                    'created_at' => Carbon::now(),
                ]);
            }

            // cập nhật hàng của người dùng sau khi thanh toán thành công
            Cart::where('user_id', $user_id)->update(['status' => 'inactive']);

            return response()->json([
                'message' => 'Thanh toán thành công',
                'status' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Lỗi thanh toán',
                'error' => $e->getMessage(),
                'status' => 500
            ]);
        }
    }

}