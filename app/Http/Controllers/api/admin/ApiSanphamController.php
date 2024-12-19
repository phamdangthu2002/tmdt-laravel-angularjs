<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiSanphamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function getSanphamID($id)
    {
        $sanphams = Product::where('id', $id)->with('attributes', 'images')->get();
        if ($sanphams) {
            return response()->json([
                'status' => 'success',
                'message' => 'Lấy thông tin sản phẩm thành công',
                'sanphams' => $sanphams
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Lấy thông tin sản phẩm thất bại',
                'data' => null
            ]);
        }
    }

    public function timKiem($key)
    {
        $sanpham = Product::where('name', 'like', '%' . $key . '%')
            ->with('attributes', 'images')->paginate(8);
        if ($sanpham) {
            return response()->json([
                'status' => 'success',
                'message' => 'Tìm kiếm sản phẩm thành công',
                'sanpham' => $sanpham
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Tìm kiếm sản phẩm thất bại',
                'data' => null
            ]);
        }
    }
    public function getSanphamDanhmucID($id)
    {
        $sanpham = Product::find($id);

        if ($sanpham) {
            // Lấy 4 sản phẩm khác cùng danh mục, loại trừ sản phẩm hiện tại
            $sanphams = Product::where('category_id', $sanpham->category_id)
                ->where('id', '!=', $id)
                ->with('attributes', 'images')
                ->take(4)
                ->get();

            return response()->json([
                'status' => 'success',
                'message' => 'Lấy thông tin sản phẩm thành công',
                'sanpham' => $sanpham,
                'sanphams' => $sanphams
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Lấy thông tin sản phẩm thất bại',
                'data' => null
            ]);
        }
    }


    public function index()
    {
        $sanphams = Product::with(['images', 'attributes', 'category'])
            ->paginate(8);

        return response()->json([
            'status' => 'success',
            'sanphams' => $sanphams,
        ], 200);
    }

    public function sanphamRandom()
    {
        $sanphams = Product::with(['images', 'attributes', 'category'])
            ->inRandomOrder()
            ->limit(4)
            ->get();
        return response()->json([
            'status' => 'success',
            'sanphams' => $sanphams,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        dd('create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Kiểm tra và validate dữ liệu
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'description' => 'required|string',
                    'description_detail' => 'required|string',
                    'price' => 'required|numeric',
                    'discount' => [
                        'nullable',
                        'numeric',
                        function ($attribute, $value, $fail) use ($request) {
                            if ($value >= $request->price) {
                                $fail('Giá giảm phải nhỏ hơn giá gốc.');
                            }
                        },
                    ],
                    'ram' => 'required',
                    'rom' => 'required',
                    'color' => 'required',
                    'quantity' => 'required|integer|min:1',
                    'category_id' => 'required|exists:categories,id',
                    'status' => 'required|in:available,out_of_stock',
                    'anhsp.*' => 'required|file|mimes:jpeg,jpg,png|max:2048',
                ],
                [
                    'name.required' => 'Tên sản phẩm không được để trống',
                    'name.max' => 'Tên sản phẩm không được quá 255 ký tự',
                    'description.required' => 'Mô tả sản phẩm không được để trống',
                    'description_detail.required' => 'Mô tả chi tiết sản phẩm không được để trống',
                    'price.required' => 'Giá sản phẩm không được để trống',
                    'price.numeric' => 'Giá sản phẩm phải là số',
                    'ram.required' => 'Không được để trống.',
                    'rom.required' => 'Không được để trống.',
                    'color.required' => 'Không được để trống.',
                    'quantity.required' => 'Số lượng không được để trống',
                    'quantity.min' => 'Số lượng sản phẩm phải lớn hơn 0',
                    'category_id.required' => 'Chọn danh mục sản phẩm',
                    'category_id.exists' => 'Danh mục sản phẩm không tồn tại',
                    'status.required' => 'Trạng thái sản phẩm không được để trống',
                    'status.in' => 'Trạng thái sản phẩm không hợp lệ',
                    'anhsp.*.required' => 'Hình ảnh sản phẩm không được để trống',
                    'anhsp.*.file' => 'Hình ảnh sản phẩm phải là file',
                    'anhsp.*.mimes' => 'Hình ảnh sản phẩm phải là file có
                loại: jpeg, jpg, png',
                    'anhsp.*.max' => 'Hình ảnh sản phẩm không được quá 2MB',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $filePaths = [];
            if ($request->hasFile('anhsp')) {
                foreach ($request->file('anhsp') as $file) { // Sửa lỗi dư dấu `$` trong `$$request->hasFile`
                    $name = $file->getClientOriginalName();
                    $pathFull = 'uploads/' . date('Y/m/d');

                    // Lưu ảnh vào thư mục public
                    $file->storeAs('public/' . $pathFull, $name);

                    // Tạo đường dẫn URL để lưu vào cơ sở dữ liệu
                    $url = '/storage/' . $pathFull . '/' . $name;

                    // Lưu đường dẫn của ảnh vào mảng
                    $filePaths[] = $url;
                }
            }

            // Bắt đầu giao dịch
            DB::beginTransaction();

            // Tạo sản phẩm
            $productSql = "INSERT INTO products (name, description, description_detail, price, discount, quantity, category_id, status, created_at) 
                       VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            DB::insert($productSql, [
                $request->input('name'),
                $request->input('description'),
                $request->input('description_detail'),
                $request->input('price'),
                $request->input('discount'),
                $request->input('quantity'),
                $request->input('category_id'),
                $request->input('status'),
                Carbon::now(),
            ]);

            // Lấy ID của sản phẩm vừa được thêm
            $product_id = DB::getPdo()->lastInsertId();

            // Thêm thuộc tính sản phẩm
            $attributesSql = "INSERT INTO product_attributes (product_id, ram, rom, color, created_at) VALUES (?, ?, ?, ?, ?)";
            DB::insert($attributesSql, [
                $product_id,
                $request->input('ram'),
                $request->input('rom'),
                $request->input('color'),
                Carbon::now()
            ]);

            // Thêm ảnh sản phẩm
            $imageSql = "INSERT INTO product_images (product_id, image_path, created_at) VALUES (?, ?, ?)";
            foreach ($filePaths as $path) {
                DB::insert($imageSql, [
                    $product_id,
                    $path,
                    Carbon::now(),
                ]);
            }

            // Commit giao dịch
            DB::commit();

            return response()->json(['message' => 'Tạo sản phẩm thành công'], 201);

        } catch (Exception $e) {
            // Rollback giao dịch nếu xảy ra lỗi
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        dd('show');

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        dd('edit');

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Xác định các giá trị cần cập nhật
            $name = $request->input('name');
            $quantity = $request->input('quantity');
            $description = $request->input('description');
            $description_detail = $request->input('description_detail');
            $price = $request->input('price');
            $discount = $request->input('discount');
            $status = $request->input('status');
            $ram = $request->input('ram');
            $rom = $request->input('rom');
            $color = $request->input('color');

            // Thực hiện câu lệnh SQL cập nhật sản phẩm
            DB::table('products')
                ->where('id', $id)
                ->update([
                    'name' => $name,
                    'quantity' => $quantity,
                    'description' => $description,
                    'description_detail' => $description_detail,
                    'price' => $price,
                    'discount' => $discount,
                    'status' => $status,
                    'updated_at' => Carbon::now()
                ]);

            DB::table('product_attributes')
                ->where('product_id', $id)
                ->update([
                    'ram' => $ram,
                    'rom' => $rom,
                    'color' => $color,
                    'updated_at' => Carbon::now()
                ]);
            return response()->json(['message' => 'Cập nhật thành công'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    public function getAllImage(Request $request, $id)
    {
        $images = DB::table('product_images')
            ->where('product_id', $id)
            ->get();
        return response()->json($images, 200);
    }

    public function editImage(Request $request)
    {
        try {
            $filePaths = [];
            if ($request->hasFile('anhsp')) {
                foreach ($request->file('anhsp') as $file) { // Sửa lỗi dư dấu `$` trong `$$request->hasFile`
                    $name = $file->getClientOriginalName();
                    $pathFull = 'uploads/' . date('Y/m/d');

                    // Lưu ảnh vào thư mục public
                    $file->storeAs('public/' . $pathFull, $name);

                    // Tạo đường dẫn URL để lưu vào cơ sở dữ liệu
                    $url = '/storage/' . $pathFull . '/' . $name;

                    // Lưu đường dẫn của ảnh vào mảng
                    $filePaths[] = $url;
                }
            }
            $imageSql = "INSERT INTO product_images (product_id, image_path, created_at) VALUES (?, ?, ?)";
            foreach ($filePaths as $path) {
                DB::insert($imageSql, [
                    $request->input('id'),
                    $path,
                    Carbon::now(),
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function deleteImage($id)
    {
        DB::table('product_images')
            ->where('id', $id)
            ->delete();
        return response()->json(['message' => 'Xóa ảnh thành công'], 200);
    }
    /*
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            DB::table('products')
                ->where('id', $id)
                ->delete();
            return response()->json(['message' => 'Xóa sản phẩm thành công'], 200);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
