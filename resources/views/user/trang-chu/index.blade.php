@extends('user.layouts.layout')
@section('content')
    {{-- @include('user.layouts.banner') --}}
    <link rel="stylesheet" href="{{ asset('assets/css/trangchu.css') }}">

    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <div class="custom-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <h1 class="text-danger"><i class="bx bx-star bx-tada text-center"></i>Sản phẩm nổi bật</h1>
                    </li>
                </ol>
            </div>
        </nav>
    </div>
    <div class="container mt-5" ng-controller="ctrlSanphamIndex">
        <div class="row">
            <!-- Product 1 -->
            <div class="col-md-3 mb-4" ng-repeat="product in listProduct">
                <div class="product-card">
                    <a href="/user/san-pham-detail/@{{ product.id }}">
                        <img ng-src="@{{ product.images[0].image_path }}" alt="@{{ product.nname }}">
                    </a>
                    <div class="product-card-body">
                        <a href="/user/san-pham-detail/@{{ product.id }}" class="text-decoration-none">
                            <h5 class="product-card-title">@{{ product.name }}</h5>
                        </a>
                        <div class="row">
                            <!-- Hiển thị giá gốc và giảm giá chỉ khi discount khác 0 -->
                            <div class="col-md-6" ng-if="product.discount > 0">
                                <p class="product-card-original-price">@{{ product.price | number }} VND</p>
                            </div>
                            <br></br>

                            <!-- Hiển thị phần giảm giá chỉ khi discount khác 0 -->
                            <div class="col-md-6" ng-if="product.discount > 0">
                                <p class="product-card-discount">Giảm @{{ product.discountPercentage }}%</p>
                            </div>
                        </div>

                        <!-- Hiển thị giá sau giảm hoặc giá gốc nếu không có giảm giá -->
                        <p class="product-card-price">@{{ product.discount > 0 ? product.discount : product.price | number }} VND</p>

                        <p class="product-card-description">
                            Ram: @{{ product.attributes[0].ram }}
                            Rom: @{{ product.attributes[0].rom }}
                            Color: @{{ product.attributes[0].color }}</p>
                        @auth
                            <button class="product-card-btn" ng-click="addCart(product.id)"><i class="bx bx-cart me-2"></i>Thêm
                                vào giỏ</button>
                        @else
                            <button class="product-card-btn" onclick="checkLogin()"><i
                                    class="bx bx-cart me-2"></i>Thêm vào
                                giỏ</button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item" ng-class="{ disabled: pagination.current_page === 1 }">
                    <a class="page-link" href="#" ng-click="changePage(pagination.current_page - 1)">Trước</a>
                </li>
                <li class="page-item" ng-class="{ active: n === pagination.current_page }"
                    ng-repeat="n in paginationRange() track by $index">
                    <a class="page-link" href="#" ng-click="changePage(n)">@{{ n }}</a>
                </li>
                <li class="page-item" ng-class="{ disabled: pagination.current_page === pagination.last_page }"> <a
                        class="page-link" href="#" ng-click="changePage(pagination.current_page + 1)">Sau</a>
                </li>
            </ul>
        </nav>
    </div>
    <style>
        .custom-breadcrumb {
            padding: 15px;
            padding-top: 30px;
            background-color: #e0f3f1;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            max-height: 80px;
            justify-content: center;
            /* Căn giữa nội dung */
            align-items: center;
        }

        .breadcrumb {
            padding: 0;
            /* Loại bỏ padding mặc định */
            margin: 0;
            /* Loại bỏ margin mặc định */
            display: flex;
            justify-content: center;
            /* Căn giữa nội dung breadcrumb */
            align-items: center;
        }

        .breadcrumb-item {
            margin-right: 10px;
            font-weight: 900;
            /* Khoảng cách giữa các mục */
        }
    </style>
    <br>
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <div class="custom-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <h1 class="text-success"><i class="bx bx-star bx-tada text-center"></i>Hôm nay mua gì ?</h1>
                    </li>
                </ol>
            </div>
        </nav>
    </div>


    <div class="container mt-5" ng-controller="ctrlSanphamRandom">
        <div class="row">
            <!-- Lặp qua danh sách sản phẩm -->
            <div class="col-md-3 mb-4" ng-repeat="product in listProductRandom">
                <div class="product-card">
                    <a href="/user/san-pham-detail/@{{ product.id }}">
                        <img ng-src="@{{ product.images[0].image_path }}" alt="@{{ product.nname }}">
                    </a>
                    <div class="product-card-body">
                        <a href="/user/san-pham-detail/@{{ product.id }}" class="text-decoration-none">
                            <h5 class="product-card-title">@{{ product.name }}</h5>
                        </a>
                        <div class="row">
                            <!-- Hiển thị giá gốc và giảm giá chỉ khi discount khác 0 -->
                            <div class="col-md-6" ng-if="product.discount > 0">
                                <p class="product-card-original-price">@{{ product.price | number }} VND</p>
                            </div>
                            <br></br>

                            <!-- Hiển thị phần giảm giá chỉ khi discount khác 0 -->
                            <div class="col-md-6" ng-if="product.discount > 0">
                                <p class="product-card-discount">Giảm @{{ product.discountPercentage }}%</p>
                            </div>
                        </div>

                        <!-- Hiển thị giá sau giảm hoặc giá gốc nếu không có giảm giá -->
                        <p class="product-card-price">@{{ product.discount > 0 ? product.discount : product.price | number }} VND</p>
                        <p class="product-card-description">
                            Ram: @{{ product.attributes[0].ram }}
                            Rom: @{{ product.attributes[0].rom }}
                            Color: @{{ product.attributes[0].color }}
                        </p>
                        @auth
                            <button class="product-card-btn" ng-click="addCart(product.id)"><i class="bx bx-cart me-2"></i>Thêm
                                vào giỏ</button>
                        @else
                            <button class="product-card-btn" onclick="checkLogin()"><i
                                    class="bx bx-cart me-2"></i>Thêm vào
                                giỏ</button>
                        @endauth

                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        function checkLogin() {
            Swal.fire({
                title: 'Vui lòng đăng nhập',
                text: 'Bạn cần đăng nhập để thực hiện thao tác này.',
                icon: 'warning',
                confirmButtonText: 'Đăng nhập',
                showCancelButton: true,
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Chuyển hướng đến trang đăng nhập 
                    window.location.href = '/auth/dang-nhap';
                    // // Thay đổi URL theo trang đăng nhập của bạn 
                }
            });
        }
    </script>
@endsection
@section('angular')
    <script>
        app.controller('ctrlSanphamIndex', function($scope, $http) {
            $scope.pagination = {};
            $scope.listProduct = {};
            var user_id = {!! json_encode(optional(getLoggedInUser())->id) !!} ?? null;
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
            const getAllProduct = async function(page = 1) {
                try {
                    const response = await $http.get('/api/san-pham?page=' + page);
                    $scope.listProduct = response.data.sanphams.data;
                    // Duyệt qua từng sản phẩm trong mảng listProduct
                    $scope.listProduct.forEach(product => {
                        product.giagoc = parseFloat(product.price);
                        // Gán giá gốc và chuyển về số thực
                        product.giagiam = parseFloat(product.discount);
                        // Gán giá giảm và chuyển về số thực

                        // Tính % giảm giá
                        if (product.giagoc > 0) {
                            // Kiểm tra giá gốc phải lớn hơn 0
                            product.discountPercentage =
                                Math.round(
                                    ((product.giagoc - product.giagiam) / product.giagoc) * 100);
                            // Làm tròn phần trăm giảm giá thành số nguyên
                        } else {
                            product.discountPercentage = 0;
                            // Nếu giá gốc là 0 hoặc không hợp lệ, đặt % giảm giá là 0
                        }
                    });

                    $scope.pagination = {
                        current_page: response.data.sanphams.current_page,
                        last_page: response.data.sanphams.last_page,
                        total: response.data.sanphams.total,
                        per_page: response.data.sanphams.per_page,
                    };
                    $scope.$applyAsync();
                    console.log($scope.listProduct); // Log to check product list
                } catch (error) {
                    console.log(error);
                }
            }
            // Function to calculate pagination range
            $scope.paginationRange = function() {
                const maxVisiblePages = 3; // Maximum number of pages to display
                const pages = [];
                const current = $scope.pagination.current_page;
                const last = $scope.pagination.last_page;

                if (last <= maxVisiblePages) {
                    for (let i = 1; i <= last; i++) {
                        pages.push(i);
                    }
                } else {
                    let start = Math.max(current - Math.floor(maxVisiblePages / 2), 1);
                    let end = start + maxVisiblePages - 1;

                    if (end > last) {
                        end = last;
                        start = end - maxVisiblePages + 1;
                    }

                    if (start > 1) {
                        pages.push(1);
                        if (start > 2) {
                            pages.push('...');
                        }
                    }

                    for (let i = start; i <= end; i++) {
                        pages.push(i);
                    }

                    if (end < last) {
                        if (end < last - 1) {
                            pages.push('...');
                        }
                        pages.push(last);
                    }
                }
                return pages;
            };

            // Function to change page when a new page is selected
            $scope.changePage = function(page) {
                if (page === '...' || page < 1 || page > $scope.pagination.last_page) {
                    return;
                }
                getAllProduct(page); // Load products for the selected page
            };
            $scope.addCart = async function(id) {
                $scope.cart = {
                    user_id: user_id, // User đã đăng nhập
                    product_id: id, // ID sản phẩm
                    product_attribute_id: id, // Thuộc tính sản phẩm (nếu có)
                    quantity: 1, // Số lượng mặc định là 1
                };

                try {
                    const response = await $http.post('/api/cart/add', $scope.cart);

                    // Hiển thị thông báo thành công với SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: response.data.message, // Tin nhắn từ server
                        timer: 2000, // Tự động đóng sau 2 giây
                        showConfirmButton: false,
                    });

                    // Reset dữ liệu giỏ hàng
                    $scope.carts = response.data.message;
                    $scope.cart = {};
                    getCart();
                    $scope.$applyAsync();
                } catch (error) {
                    // Hiển thị thông báo lỗi với SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: error.data?.message ||
                            'Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.',
                        showConfirmButton: true,
                    });
                    console.error('Exception:', error);
                }
            };
            getCart();
            getAllProduct();
        });

        app.controller('ctrlSanphamRandom', function($scope, $http) {
            // Tạo mảng lưu danh sách sản phẩm
            $scope.listProductRandom = [];
            var user_id = {!! json_encode(optional(getLoggedInUser())->id) !!} ?? null;

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

            const getSanphamRandom = async function() {
                try {
                    const response = await $http.get('/api/san-pham/ramdom/get-sanpham');
                    $scope.listProductRandom = response.data.sanphams;
                    $scope.listProductRandom.forEach(product => {
                        product.giagoc = parseFloat(product.price);
                        // Gán giá gốc và chuyển về số thực
                        product.giagiam = parseFloat(product.discount);
                        // Gán giá giảm và chuyển về số thực

                        // Tính % giảm giá
                        if (product.giagoc > 0) {
                            // Kiểm tra giá gốc phải lớn hơn 0
                            product.discountPercentage = Math.round(
                                ((product.giagoc - product.giagiam) / product.giagoc) * 100);
                            // Làm tròn phần trăm giảm giá thành số nguyên
                        } else {
                            product.discountPercentage = 0;
                            // Nếu giá gốc là 0 hoặc không hợp lệ, đặt % giảm giá là 0
                        }
                    });
                    $scope.$applyAsync();
                    console.log($scope.listProductRandom);
                } catch (error) {
                    console.log(error);
                }
            }
            $scope.addCart = async function(id) {
                $scope.cart = {
                    user_id: user_id, // User đã đăng nhập
                    product_id: id, // ID sản phẩm
                    product_attribute_id: id, // Thuộc tính sản phẩm (nếu có)
                    quantity: 1, // Số lượng mặc định là 1
                };

                try {
                    const response = await $http.post('/api/cart/add', $scope.cart);

                    // Hiển thị thông báo thành công với SweetAlert2
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công',
                        text: response.data.message, // Tin nhắn từ server
                        timer: 2000, // Tự động đóng sau 2 giây
                        showConfirmButton: false,
                    });

                    // Reset dữ liệu giỏ hàng
                    $scope.carts = response.data.message;
                    $scope.cart = {};
                    getCart();
                    $scope.$applyAsync();
                } catch (error) {
                    // Hiển thị thông báo lỗi với SweetAlert2
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi',
                        text: error.data?.message ||
                            'Không thể thêm sản phẩm vào giỏ hàng. Vui lòng thử lại.',
                        showConfirmButton: true,
                    });
                    console.error('Exception:', error);
                }
            };
            getCart();
            getSanphamRandom();
        });
    </script>
@endsection
