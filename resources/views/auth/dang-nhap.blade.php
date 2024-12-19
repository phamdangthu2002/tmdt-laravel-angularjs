@extends('user.layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <div class="container container_form" ng-controller="ctrlLogin">
        <form class="form">
            <p class="title">Đăng nhập </p>
            <p class="message">Đăng nhập ngay để có quyền truy cập đầy đủ vào ứng dụng của chúng tôi. </p>
            <label>
                <input class="input" type="email" placeholder="" required="" name="email" ng-model="user.email">
                <span>Email</span>
                <div class="text-danger" ng-if="errors.email">
                    @{{ errors.email[0] }}
                </div>
            </label>
            <label>
                <input class="input" type="password" placeholder="" required="" name="password"
                    ng-model="user.password">
                <span>Mật khẩu</span>
                <div class="text-danger" ng-if="errors.password">
                    @{{ errors.password[0] }}
                </div>
            </label>
            <button class="submit" ng-click="login()">Đăng nhập</button>
            <p class="signin">Bạn chưa có tài khoản ? <a href="/auth/dang-ky">Đăng ký</a> </p>
        </form>
    </div>
    @if (session('error'))
        <script>
            // Hiển thị thông báo Toastr ngay khi trang được tải
            toastr.error("{{ session('error') }}", 'Lỗi!');
        </script>
    @endif
@endsection
@section('angular')
    <script>
        app.controller('ctrlLogin', function($scope, $http) {
            $scope.user = {};
            $scope.errors = {};
            $scope.path = [];
            $scope.login = async function() {
                try {
                    const response = await $http.post('/api/auth/login', $scope.user);
                    Swal.fire({
                        title: 'Thành công!',
                        text: 'Đăng nhập thành công.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Chuyển trang sau khi người dùng nhấn "OK"
                            $scope.path = response.data.path;
                            window.location.href = $scope.path;
                        }
                    });
                } catch (error) {
                    if (error.status === 422) {
                        $scope.errors = error.data.error;
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Thông tin đăng nhập không hợp lệ.',
                            icon: 'error',
                            confirmButtonText: 'Thử lại'
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Đã xảy ra lỗi khi đăng nhập.',
                            icon: 'error',
                            confirmButtonText: 'Thử lại'
                        });
                    }
                    console.log(error);
                }
            }
        });
    </script>
@endsection
