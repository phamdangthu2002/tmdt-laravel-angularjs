<?php

namespace App\Http\Controllers\api\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ApiUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = DB::table('users')->paginate(5);
        return response()->json(['users' => $users]);
    }


    public function profile($id)
    {
        $user = DB::table('users')->where('id', $id)->first();
        return response()->json(['user' => $user]);
    }

    public function updateUser(Request $request)
    {
        // Lấy thông tin từ request
        $name = $request->input('name');
        $email = $request->input('email');
        $password = $request->input('password_new'); // Mật khẩu mới
        $phone = $request->input('phone');
        $address = $request->input('address');
        $id = $request->input('id');

        // Tìm người dùng theo ID
        $user = User::find($id);

        if (!$user) {
            // Nếu không tìm thấy người dùng, trả về lỗi
            return response()->json(['error' => 'User not found'], 404);
        }

        // Nếu mật khẩu mới được gửi, mã hóa và cập nhật mật khẩu
        if ($password) {
            $user->password = bcrypt($password);  // Mã hóa mật khẩu mới
        }

        // Cập nhật các thông tin khác nếu có thay đổi
        $user->name = $name;
        $user->email = $email;
        $user->phone = $phone;
        $user->address = $address;

        // Lưu thay đổi vào cơ sở dữ liệu
        $user->save();

        // Trả về thông tin người dùng đã cập nhật
        return response()->json(['user' => $user], 200);
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        try {
            // Validate dữ liệu
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'role' => 'required|string|in:admin,user',
                    'password' => 'required|string|min:6',
                    'password_confirmation' => 'same:password',
                ],
                [
                    'name.required' => 'Vui lòng nhập tên người dùng.',
                    'name.string' => 'Tên người dùng phải là chuỗi ký tự.',
                    'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',

                    'email.required' => 'Vui lòng nhập email.',
                    'email.email' => 'Email không hợp lệ.',
                    'email.unique' => 'Email này đã được sử dụng.',

                    'role.required' => 'Vui lòng chọn phân quyền cho người dùng.',
                    'role.in' => 'Phân quyền không hợp lệ, chỉ có thể là admin hoặc user.',

                    'password.required' => 'Vui lòng nhập mật khẩu.',
                    'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
                    'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

                    'password_confirmation.same' => 'Mật khẩu xác nhận không khớp với mật khẩu.',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            // Thêm người dùng vào cơ sở dữ liệu với SQL thuần
            DB::insert('INSERT INTO users (name, email, phone, address, role, password, status, created_at) VALUES (?,?,?,?,?,?,?,?)', [
                $request->input('name'),
                $request->input('email'),
                $request->input('phone'),
                $request->input('address'),
                $request->input('role'),
                bcrypt($request->input('password')), // Mã hóa mật khẩu
                $request->input('status'),
                Carbon::now(),
            ]);

            return response()->json(['message' => 'Tạo người dùng thành công.'], 201);
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
            $user = DB::table('users')->where('id', $id)->first();
            if (!$user) {
                return response()->json(['error' => 'Người dùng không tồn tại.'], 404);
            }

            // Kiểm tra và mã hóa mật khẩu nếu có thay đổi
            $password = $user->password; // Giữ nguyên mật khẩu hiện tại
            if ($request->filled('password_new')) {
                $password = bcrypt($request->input('password_new'));
            }

            // Cập nhật người dùng
            DB::update(
                'UPDATE users SET name = ?, email = ?, phone = ?, address = ?, role = ?, password = ?, status = ?, updated_at = ? WHERE id = ?',
                [
                    $request->input('name'),
                    $request->input('email'),
                    $request->input('phone'),
                    $request->input('address'),
                    $request->input('role'),
                    $password, // Sử dụng mật khẩu đã mã hóa nếu có thay đổi
                    $request->input('status'),
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
        try { // Thực hiện câu lệnh SQL để xóa người dùng 
            DB::table('users')->where('id', $id)->delete();
            return response()->json(['success' => 'Người dùng đã được xóa thành công.']);
        } catch (Exception $e) {
            return response()->json(
                [
                    'error' => 'Có lỗi xảy ra khi xóa người dùng. Vui lòng thử lại sau.',
                    $e->getMessage()
                ],
                500
            );
        }
    }
}
