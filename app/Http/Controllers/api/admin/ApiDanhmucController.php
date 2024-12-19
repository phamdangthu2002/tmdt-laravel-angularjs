<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiDanhmucController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $danhmuc = DB::table('categories')->paginate(5);
        return response()->json([
            'status' => 'success',
            'danhmucs' => $danhmuc
        ], 200);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $danhmuc = DB::table('categories')->whereNull('parent_id')->get();
        $danhmucs = DB::table('categories')->get();
        return response()->json([
            'status' => 'success',
            'danhmucs' => $danhmuc,
            'danhmucs_all' => $danhmucs
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Thực hiện validation cho các trường cần thiết 
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'description' => 'nullable|string',
                    'status' => 'required|string|in:active,inactive',
                    'parent_id' => 'nullable|integer|exists:categories,id'
                ]
            );
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }
            // Chuẩn bị các giá trị để chèn vào cơ sở dữ liệu 
            $name = $request->input('name');
            $description = $request->input('description');
            $status = $request->input('status');
            $parent_id = $request->input('parent_id') ?? null; // Đảm bảo giá trị null nếu không có parent_id 
            $created_at = Carbon::now();
            // Lưu danh mục mới vào cơ sở dữ liệu 
            DB::insert(
                'INSERT INTO categories (name, description, status, parent_id, created_at) VALUES (?,?,?,?,?)',
                [
                    $name,
                    $description,
                    $status,
                    $parent_id,
                    $created_at,
                ]
            );
            return response()->json(['success' => 'Danh mục đã được thêm thành công.'], 200);
        } catch (Exception $e) {
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
            // Lấy thông tin người dùng từ cơ sở dữ liệu
            $user = DB::table('categories')->where('id', $id)->first();
            if (!$user) {
                return response()->json(['error' => 'Danh mục không tồn tại.'], 404);
            }
            $name = $request->input('name');
            $description = $request->input('description');
            $status = $request->input('status');
            $parent_id = $request->input('parent_id') ?? null;
            // Cập nhật danh mục
            DB::update(
                'UPDATE categories SET name = ?, description = ?, status = ?, parent_id  = ?, updated_at = ? WHERE id = ?',
                [
                    $name,
                    $description,
                    $status,
                    $parent_id,
                    Carbon::now(), // Cập nhật thời gian hiện tại cho trường updated_at
                    $id // Bổ sung id người dùng
                ]
            );

            return response()->json(['success' => 'Người dùng đã được cập nhật thành công.']);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // dd($id);
        try { // Thực hiện câu lệnh SQL để xóa danh mục
            DB::table('categories')->where('id', $id)->delete();
            return response()->json(['success' => 'Danh mục đã được xóa thành công.']);
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => 'Có lỗi xảy ra khi xóa danh mục. Vui lòng thử lại sau.',
                    $e->getMessage()
                ],
                500
            );
        }
    }
}
