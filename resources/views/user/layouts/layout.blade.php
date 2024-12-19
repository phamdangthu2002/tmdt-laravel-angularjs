<!DOCTYPE html>
<html lang="en" ng-app="myApp">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Header Bán Điện Thoại</title>
    <link rel="stylesheet" href="{{ asset('assets/vendor/bootstrap-5.3.3-dist/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/boxicons-2.1.4/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/header.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/loader.css') }}">
    <style>
        body {
            background-color: #f5f5f5;
        }
    </style>
</head>

<body>
    @include('user.layouts.header')
    <div>{!! getLoggedInUser() !!}</div>

    {{-- Loading --}}
    <div class="loading">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
    </div>
    <div class="main-content">
        @yield('content')
        @include('user.layouts.footer')
    </div>

    <script src="{{ asset('assets/vendor/sweetalert2@11.js') }}"></script>
    <script src="{{ asset('assets/vendor/popper.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/moment.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/angular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/bootstrap-5.3.3-dist/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('/assets/vendor/popper.min.js') }}"></script>
    {{-- load --}}
    <script>
        window.addEventListener('load', function() {
            const loaderContainer = document.querySelector('.loading');
            const mainContent = document.querySelector('.main-content');

            // Hiển thị loader ban đầu
            loaderContainer.style.display = 'flex';
            mainContent.style.display = 'none';

            // Sau 2 giây, ẩn loader và hiển thị nội dung chính
            setTimeout(() => {
                loaderContainer.style.display = 'none'; // Ẩn loader
                mainContent.style.display = 'block'; // Hiển thị nội dung chính
            }, 1500); // Sau 2 giây
        });
    </script>
    <script>
        var app = angular.module('myApp', []);
        app.run(function($http) {
            $http.defaults.headers.common['X-CSRF-TOKEN'] = '{{ csrf_token() }}';
        });

        app.controller('ctrlDanhmuc', function($scope, $http) {
            $scope.parent_id = [];
            $scope.danhmuc_hierarchy = [];
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

            const fetchDanhMuc = async function() {
                const response = await $http.get('/api/danh-muc/create');
                $scope.parent_id = response.data.danhmucs_all;

                // Xử lý dữ liệu thành cấu trúc phân cấp
                $scope.danhmuc_hierarchy =
                    $scope.parent_id.filter(
                        item => !item.parent_id
                    ).map(parent => {
                        parent.children = $scope.parent_id.filter(
                            child => child.parent_id === parent.id
                        );
                        return parent;
                    });

                console.log('Danh mục phân cấp:', $scope.danhmuc_hierarchy);
                $scope.$applyAsync();
            };

            const getCountCart = async function() {
                try {
                    const response = await $http.get('/api/cart/get-cart');
                    $scope.totalQuantity =
                        response.data.carts.reduce((sum, cart) => sum + cart.quantity, 0);
                    $scope.$applyAsync();
                    console.log($scope.totalQuantity);
                } catch (error) {
                    console.log(error);
                }
            }

            
            getCountCart();
            fetchDanhMuc();
        });

        app.controller('ctrlCart', function($scope, $http) {
            const getCart = async function() {
                try {
                    const response = await $http.get('/api/cart/get-cart');
                    $scope.carts = response.data.carts;
                    $scope.total = response.data.total;
                    console.log($scope.carts);
                    console.log($scope.total);
                    $scope.$applyAsync();
                } catch (error) {
                    console.log(error);
                }
            }
            getCart();
        });


        var angular = function($scope, $http) {}
    </script>

    @yield('angular')

    <script>
        app.controller('viewCtrl', angular);
    </script>
</body>

</html>
