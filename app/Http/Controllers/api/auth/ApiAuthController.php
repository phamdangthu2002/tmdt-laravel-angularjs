<?php

namespace App\Http\Controllers\api\auth;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;


class ApiAuthController extends Controller
{
    public function register(Request $request)
    {
        try {
            $validator = Validator::make(
                $request->all(),
                [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|unique:users,email',
                    'password' => 'required|string|min:6',
                    'password_confirmation' => 'same:password',
                ],
                [
                    'name.required' => 'Tên người dùng là bắt buộc.',
                    'name.string' => 'Tên người dùng phải là chuỗi.',
                    'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',
                    'email.required' => 'Địa chỉ email là bắt buộc.',
                    'email.email' => 'Địa chỉ email phải đúng định dạng.',
                    'email.unique' => 'Địa chỉ email đã được sử dụng.',
                    'password.required' => 'Mật khẩu là bắt buộc.',
                    'password.string' => 'Mật khẩu phải là chuỗi.',
                    'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',
                    'password_confirmation.same' => 'Mật khẩu xác nhận phải trùng với mật khẩu.',
                ]
            );
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors()], 422);
            }

            $name = $request->input('name');
            $email = $request->input('email');
            $password = bcrypt($request->input('password'));
            $status = 'active';
            // Thêm người dùng vào cơ sở dữ liệu với SQL thuần
            DB::insert('INSERT INTO users (name, email, password, status, created_at) VALUES (?,?,?,?,?)', [
                $name,
                $email,
                $password,
                $status,
                Carbon::now(),
            ]);
            return response()->json(['message' => 'Tạo người dùng thành công.'], 201);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function login(Request $request)
    {
        // 1. Kiểm tra thông tin đầu vào
        $validator = Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required|string',
            ],
            [
                'email.required' => 'Địa chỉ email là bắt buộc.',
                'email.email' => 'Địa chỉ email phải đúng định dạng.',
                'password.required' => 'Mật khẩu là bắt buộc.',
                'password.string' => 'Mật khẩu phải là chuỗi.',
            ]
        );

        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        // 2. Xác thực thông tin người dùng
        $credentials = $request->only(['email', 'password']);
        if (!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Tài khoản hoặc mật khẩu không đúng.'], 401);
        }

        // 3. Lấy thông tin người dùng
        $user = Auth::user();

        // 4. Kiểm tra trạng thái người dùng (nếu có)
        if ($user->status === 'inactive') {
            return response()->json(['error' => 'Tài khoản của bạn đang bị khóa hoặc chưa kích hoạt.'], 403);
        }

        // 5. Tạo Session (nếu muốn dùng session-based authentication)
        session(['user_id' => $user->id, 'role' => $user->role]);

        // 6. Tạo token theo role (nếu dùng API)
        $abilities = $user->role === 'admin' ? ['*'] : ['read'];
        $token = $user->createToken('auth_token', $abilities, now()->addMinutes(30))->plainTextToken;

        // 7. Trả về thông tin phản hồi
        return response()->json([
            'message' => 'Đăng nhập thành công!',
            'access_token' => $token,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->role,
            ],
            'path' => $user->role === 'admin' ? '/admin' : '/',
        ]);
    }

    public function logout(Request $request)
    {
        // 1. Xóa tất cả token (nếu cần)
        $user = Auth::user();
        $user->tokens()->delete();

        // 2. Xóa session
        $request->session()->flush();

        // 3. Phản hồi
        return response()->json([
            'message' => 'Đăng xuất thành công!',
            'path' => '/auth/dang-nhap',
        ], 200);
    }
}
