@extends('user.layouts.layout')

@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/auth.css') }}">
    <div class="container container_form" ng-controller="ctrlRegister">
        <form class="form">
            <p class="title">Đăng ký </p>
            <p class="message">Đăng ký ngay để có quyền truy cập đầy đủ vào ứng dụng của chúng tôi.</p>
            <label>
                <input class="input" type="text" placeholder="" required="" name="name" ng-model="user.name">
                <span>Tên của bạn</span>
                <div class="text-danger" ng-if="errors.name">
                    @{{ errors.name[0] }}
                </div>
            </label>

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
            <label>
                <input class="input" type="password" placeholder="" required="" name="password_confirmation"
                    ng-model="user.password_confirmation">
                <span>Xác nhận mật khẩu</span>
                <div class="text-danger" ng-if="errors.password_confirmation">
                    @{{ errors.password_confirmation[0] }}
                </div>
            </label>
            <button class="submit" ng-click="register()">Submit</button>
            <p class="signin">Bạn đã có tài khoảnkhoản ? <a href="/auth/dang-nhap">Đăng nhập</a> </p>
        </form>
    </div>
@endsection

@section('angular')
    <script>
        app.controller('ctrlRegister', function($scope, $http) {
            $scope.user = {};
            $scope.errors = {};
            $scope.register = async function() {
                try {
                    const response = await $http.post('/api/auth/register', $scope.user);
                    Swal.fire({
                        title: 'Đăng ký thành công!',
                        text: 'Tài khoản của bạn đã được tạo thành công.',
                        icon: 'success',
                        confirmButtonText: 'OK'
                    });
                    $scope.user = {};
                    $scope.errors = {};
                    $scope.$applyAsync();
                } catch (error) {
                    if (error.status == 422) {
                        $scope.errors = error.data.error;
                        console.log($scope.errors);
                        $scope.$applyAsync();
                        Swal.fire({
                            title: 'Lỗi đăng ký!',
                            text: 'Vui lòng kiểm tra lại thông tin đăng ký.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        Swal.fire({
                            title: 'Lỗi không xác định!',
                            text: 'Vui lòng thử lại sau.',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                    console.log(error);
                }
            }
        });
    </script>
@endsection
