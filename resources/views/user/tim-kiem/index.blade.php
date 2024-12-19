@extends('user.layouts.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/trangchu.css') }}">

    <div class="container mt-5" ng-controller="ctrlSanphamTimKiem">
        <div class="row">
            <h3 ng-if="listProduct.length == 0" class="text-center text-danger">Không có sản phẩm nào!</h3>
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
                    <a class="page-link" ng-click="changePage(pagination.current_page - 1)" style="cursor: pointer">Trước</a>
                </li>
                <li class="page-item" ng-class="{ active: n === pagination.current_page }"
                    ng-repeat="n in paginationRange() track by $index">
                    <a class="page-link" ng-click="changePage(n)" style="cursor: pointer">@{{ n }}</a>
                </li>
                <li class="page-item" ng-class="{ disabled: pagination.current_page === pagination.last_page }"> <a
                        class="page-link" ng-click="changePage(pagination.current_page + 1)" style="cursor: pointer">Sau</a>
                </li>
            </ul>
        </nav>
    </div>
@endsection

@section('angular')
    <script>
        app.controller('ctrlSanphamTimKiem', function($scope, $http) {
            var currentUrl = window.location.href; // Lấy URL hiện tại
            var key = currentUrl.split('/').pop(); // Lấy phần cuối của URL
            console.log('key:', key);
            $scope.pagination = {};
            $scope.listProduct = {};
            const tiemKiem = async function(page = 1) {
                try {
                    const response = await $http.get(`/api/tim-kiem/${key}?page=${page}`);
                    console.log(`/api/tim-kiem/${key}?page=${page}`);

                    const sanpham = response.data.sanpham;

                    $scope.$applyAsync(() => { // Ép AngularJS cập nhật UI
                        $scope.listProduct = sanpham.data.map(product => {
                            product.giagoc = parseFloat(product.price); // Giá gốc
                            product.giagiam = parseFloat(product.discount); // Giá giảm

                            // Tính % giảm giá
                            product.discountPercentage = product.giagoc > 0 ?
                                Math.round(
                                    ((product.giagoc - product.giagiam) / product.giagoc) *
                                    100) : 0;

                            return product;
                        });

                        $scope.pagination = {
                            current_page: sanpham.current_page,
                            last_page: sanpham.last_page,
                            total: sanpham.total,
                            per_page: sanpham.per_page
                        };

                        console.log('Sản phẩm:', $scope.listProduct);
                        console.log('Phân trang:', $scope.pagination);
                    });

                } catch (error) {
                    console.error('Lỗi khi gọi API:', error);
                }
            };

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
                    return; // Ngăn chặn chuyển trang không hợp lệ
                }
                tiemKiem(page); // Gọi lại hàm tìm kiếm và truyền số trang mới
            };

            tiemKiem();
        });
    </script>
@endsection
