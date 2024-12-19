@extends('user.layouts.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/trangchu.css') }}">

    <div class="container mt-5" ng-controller="ctrlSanphamDanhmuc">
        <div class="row">
            <!-- Product 1 -->
            <div class="col-md-3 mb-4" ng-repeat="product in products">
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
                            <button class="product-card-btn" onclick="checkLogin()"><i class="bx bx-cart me-2"></i>Thêm vào
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
@endsection
@section('angular')
    <script>
        app.controller('ctrlSanphamDanhmuc', function($scope, $http) {
            $scope.pagination = {};
            $scope.products = [];
            // Lấy URL hiện tại
            var currentUrl = window.location.href;
            var segments = currentUrl.split('/'); // Tách URL thành mảng các phần tử
            var last = segments.pop(); // Phần tử cuối
            var secondLast = segments.pop(); // Phần tử kế cuối

            console.log("Phần tử kế cuối:", secondLast);
            console.log("Phần tử cuối cùng:", last);

            // Xác định danh mục cấp 1 hoặc cấp 2 và gọi API
            if (secondLast === 'danh-muc') {
                // Trường hợp danh mục cấp 1
                console.log("Danh mục cấp 1 với ID:", last);
                getProductsByCategory(last);
            } else if (secondLast === 'submenu') {
                // Trường hợp danh mục cấp 2
                console.log("Danh mục cấp 2 với ID:", last);
                getProductsBySubcategory(last);
            }

            // Hàm lấy sản phẩm theo danh mục cấp 1
            function getProductsByCategory(categoryId, page = 1) {
                $http.get(`/api/show/danh-muc/${categoryId}?page=` + page)
                    .then(function(response) {
                        $scope.products = response.data.sanphams.data;
                        $scope.products.forEach(product => {
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
                        console.log('danhmuc', $scope.products);
                    })
                    .catch(function(error) {
                        console.error("Lỗi khi lấy sản phẩm cấp 1:", error);
                    });
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
                    getProductsByCategory(page); // Load products for the selected page
                };
            }

            // Hàm lấy sản phẩm theo danh mục cấp 2
            function getProductsBySubcategory(subcategoryId, page = 1) {
                $http.get(`/api/show/danh-muc/submenu/${subcategoryId}?page=?` + page)
                    .then(function(response) {
                        $scope.products = response.data.sanphams.data;
                        console.log($scope.products);
                        $scope.products.forEach(product => {
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
                    })
                    .catch(function(error) {
                        console.error("Lỗi khi lấy sản phẩm cấp 2:", error);
                    });
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
                    getProductsBySubcategory(page); // Load products for the selected page
                };
            }
        });
    </script>
@endsection
