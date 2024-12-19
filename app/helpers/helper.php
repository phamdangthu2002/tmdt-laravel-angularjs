<?php
use App\Models\User;

if (!function_exists('getLoggedInUser')) {
    function getLoggedInUser()
    {
        $userId = session('user_id'); // Lấy user ID từ session

        if ($userId) {
            return User::find($userId); // Lấy thông tin người dùng từ database
        }

        return null; // Nếu không có session user_id thì trả về null
    }
}
