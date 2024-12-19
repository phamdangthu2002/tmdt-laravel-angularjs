<!DOCTYPE html>
<html lang="vi" ng-app="myApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - {{ $title }}</title>

    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons-2.1.4/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/admin.css') }}">
    <script src="{{ asset('assets/vendor/chart-js-v4.4.1.js') }}"></script>

</head>

<body>
    <div class="row">
        <div class="col-md-2">
            <!-- Sidebar -->
            @include('admin.layouts.sidebar')
        </div>
        <div class="col-md-10">
            @include('admin.layouts.breadcrumb')
            <!-- Main Content -->
            @yield('content')
        </div>
    </div>




    <!-- Bootstrap JS và các thư viện liên quan -->
    <script src="{{ asset('assets/vendor/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/angular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-5.3.3-dist/js/bootstrap.min.js') }}"></script>
    <script>
        var app = angular.module('myApp', []);
        app.run(function($http) {
            $http.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
        });
        app.controller('ctrlSidebar', function($scope, $http) {
            $scope.path = [];

            $scope.logout = async function() {
                // Hiển thị câu hỏi xác nhận trước khi đăng xuất
                const result = await Swal.fire({
                    title: 'Bạn chắc chắn muốn đăng xuất?',
                    text: 'Bạn sẽ phải đăng nhập lại sau khi đăng xuất.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Đăng xuất',
                    cancelButtonText: 'Hủy'
                });

                // Nếu người dùng nhấn "Đăng xuất"
                if (result.isConfirmed) {
                    try {
                        const response = await $http.post('/api/auth/logout');
                        $scope.path = response.data.path;
                        window.location.href = $scope.path;
                    } catch (error) {
                        console.log(error);
                    }
                }
            };
        });
        var angular = function($scope, $http) {}
    </script>

    @yield('angular')

    <script>
        app.controller('viewCtrl', angular);
    </script>

</body>

</html>
