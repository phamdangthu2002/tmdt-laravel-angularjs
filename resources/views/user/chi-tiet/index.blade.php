@extends('user.layouts.layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/css/trangchu.css') }}">

    <style>
        .product-container {
            margin-top: 50px;
        }

        .product-image-main {
            width: 100%;
            height: auto;
            transition: all 0.3s ease;
        }

        .product-thumbnails {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .col-md-2 {
            overflow-y: auto;
            max-height: 500px;
        }

        .product-thumbnails img {
            cursor: pointer;
            width: 60px;
            margin: 5px;
            border-radius: 8px;
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }

        .product-thumbnails img:hover,
        .product-thumbnails img.active {
            border: 2px solid #007bff;
        }

        .product-details {
            padding: 20px;
        }

        .product-title {
            font-size: 1.8rem;
            font-weight: bold;
        }

        .product-price {
            font-size: 1.5rem;
            color: #ff5733;
        }

        .product-description {
            margin-top: 20px;
            font-size: 1rem;
        }

        .btn-add-to-cart {
            margin-top: 20px;
            background-color: #007bff;
            color: white;
            transition: all 0.3s ease;
        }

        .btn-add-to-cart:hover {
            background-color: #0056b3;
        }

        .quantity-controls input {
            width: 60px;
            text-align: center;
        }

        .quantity-controls button {
            font-size: 1.5rem;
        }
    </style>

    <div class="container product-container mt-5 mb-5" ng-controller="ctrlSanphamDetail">
        <div class="card shadow-lg">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="row">
                            <div class="col-md-10">
                                <!-- Main Product Image -->
                                <img ng-src="@{{ sanphamDetail.images[0].image_path }}" alt="Product Image" class="product-image-main"
                                    id="mainImage">
                            </div>
                            <div class="col-md-2">
                                <!-- Thumbnails -->
                                <div class="product-thumbnails" ng-repeat="image in images">
                                    <img src="@{{ image.image_path }}" alt="Thumbnail 1" onclick="changeImage(this)"
                                        class="active">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6 product-details">
                        <h4 id="productName" class="text-black" style="font-weight: 600">@{{ sanphamDetail.name }}</h4>
                        <p id="productPrice" class="text-muted">
                            <del id="originalPrice" style="font-size: 12px" ng-if="sanphamDetail.discount != 0">
                                @{{ sanphamDetail.price | number }} VND
                            </del>
                            <span id="salePrice" class="text-success" style="font-weight: 600; font-size: 20px"
                                ng-if="sanphamDetail.discount != 0">
                                @{{ sanphamDetail.discount | number }} VND
                            </span>
                            <span id="salePrice" class="text-success" style="font-weight: 600; font-size: 20px"
                                ng-if="sanphamDetail.discount == 0">
                                @{{ sanphamDetail.price | number }} VND
                            </span>
                        </p>
                        <p id="productTag" class="bx bx-purchase-tag-alt badge bg-warning text-dark text-center"
                            style="font-weight: 600" ng-if="sanphamDetail.discount != 0">
                            Giảm @{{ discountPercentage }}%
                        </p>
                        <p class="product-description">@{{ sanphamDetail.description }}</p>
                        <!-- Sử dụng ng-init để gán giá trị user_id từ server -->
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <div class="btn btn-warning">RAM: @{{ sanphamDetail.attributes[0].ram }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <div class="btn btn-warning">ROM: @{{ sanphamDetail.attributes[0].rom }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mt-3">
                                    <div class="btn btn-warning">Màu: @{{ sanphamDetail.attributes[0].color }}</div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <!-- Số Lượng -->
                                <div class="mt-3">
                                    <label for="quantityInput">Số Lượng:</label>
                                    <div class="input-group" style="width: 120px;">
                                        <button class="btn btn-outline-secondary" id="decreaseQuantity">-</button>
                                        <input type="number" class="form-control text-center" value="1" min="1"
                                            max="10" id="quantityInput" ng-model="cart.quantity">
                                        <button class="btn btn-outline-secondary" id="increaseQuantity">+</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Add to Cart Button -->
                        @auth

                            <button class="btn btn-danger w-100" ng-click="addToCart(sanphamDetail.id)">Add to Cart</button>
                        @else
                            <button class="btn btn-secondary w-100" onclick="checkLogin()">Add to Cart</button>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
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
    <div class="container mt-5">
        <nav aria-label="breadcrumb">
            <div class="custom-breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">
                        <h1 class="text-success"><i class="bx bx-star bx-tada text-center"></i>Sản phẩm tương tự</h1>
                    </li>
                </ol>
            </div>
        </nav>
    </div>

    <div class="container mt-5" ng-controller="ctrlSanphamDanhmucID">
        <div class="row">
            <!-- Lặp qua danh sách sản phẩm -->
            <div class="col-md-3 mb-4" ng-repeat="product in sanphamDanhmucID">
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
                            <button class="product-card-btn" ng-click="addCart(product.id)"><i
                                    class="bx bx-cart me-2"></i>Thêm
                                vào giỏ</button>
                        @else
                            <button class="product-card-btn" onclick="checkLogin()"><i class="bx bx-cart me-2"></i>Thêm vào
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
        // Change main image when thumbnail is clicked
        function changeImage(element) {
            var mainImage = document.getElementById('mainImage');
            mainImage.src = element.src;
            var thumbnails = document.querySelectorAll('.product-thumbnails img');
            thumbnails.forEach(img => img.classList.remove('active'));
            element.classList.add('active');
        }
        // Lấy các phần tử
        const quantityInput = document.getElementById('quantityInput');
        const decreaseButton = document.getElementById('decreaseQuantity');
        const increaseButton = document.getElementById('increaseQuantity');

        // Hàm giảm số lượng
        decreaseButton.addEventListener('click', () => {
            let quantity = parseInt(quantityInput.value);
            if (quantity > 1) {
                quantityInput.value = quantity - 1;
                showAlert('Số lượng đã giảm!', 'success');
            } else {
                showAlert('Số lượng không thể nhỏ hơn 1.', 'warning');
            }
        });

        // Hàm tăng số lượng
        increaseButton.addEventListener('click', () => {
            let quantity = parseInt(quantityInput.value);
            if (quantity < 10) {
                quantityInput.value = quantity + 1;
            } else {
                showAlert('Số lượng tối đa là 10.', 'warning');
            }
        });

        // Hàm hiển thị thông báo SweetAlert2
        function showAlert(message, icon) {
            Swal.fire({
                title: message,
                icon: icon,
                confirmButtonText: 'OK',
            });
        }
    </script>
@section('angular')
    <script>
        app.controller('ctrlSanphamDetail', function($scope, $http) {
            $scope.sanphamDetail = {};
            $scope.images = {};
            var user_id = {!! json_encode(optional(getLoggedInUser())->id) !!} ?? null;
            $scope.discountPercentage = 0; // Biến để lưu phần trăm giảm giá
            var currentUrl = window.location.href; // Lấy URL hiện tại
            var product_id = currentUrl.split('/').pop(); // Lấy phần cuối của URL
            console.log('Product ID:', product_id);

            const getAllProductID = async function() {
                try {
                    const response = await $http.get(`/api/san-pham/get-sanpham-id/${product_id}`);
                    $scope.sanphamDetail = response.data.sanpham[0];
                    $scope.images = response.data.sanpham[0].images;
                    console.log($scope.images);
                    // Truy cập sản phẩm đầu tiên trong mảng

                    // Tính phần trăm giảm giá
                    var originalPrice = parseFloat($scope.sanphamDetail.price); // Giá gốc
                    var discountedPrice = parseFloat($scope.sanphamDetail.discount); // Giá sau giảm giá
                    if (originalPrice > 0 && discountedPrice > 0) {
                        // Tính phần trăm giảm giá và làm tròn thành số nguyên
                        $scope.discountPercentage = Math.round(((originalPrice - discountedPrice) /
                            originalPrice) * 100);
                    }

                    $scope.$applyAsync();
                    console.log($scope.sanphamDetail); // Log to check product details
                    console.log('Discount Percentage:', $scope
                        .discountPercentage); // Log phần trăm giảm giá
                } catch (error) {
                    console.log(error);
                }
            }
            $scope.addToCart = async function(id) {
                var selectedPrice = $scope.sanphamDetail.discount != 0 ? $scope.sanphamDetail.discount :
                    $scope
                    .sanphamDetail.price;
                $scope.cart = {
                    user_id: user_id,
                    product_id: id,
                    quantity: 1,
                    product_attribute_id: id,
                    price: selectedPrice
                }
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
                    $scope.cart = {};
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
                console.log($scope.cart);
            }
            getAllProductID();
        });
        app.controller('ctrlSanphamDanhmucID', function($scope, $http) {
            var currentUrl = window.location.href; // Lấy URL hiện tại
            var product_id = currentUrl.split('/').pop(); // Lấy phần cuối của URL
            console.log('Product ID:', product_id);
            $scope.sanphamDanhmucID = {};

            const getSanphamDanhmucID = async function() {
                try {
                    const response = await $http.get(`/api/san-pham/get-sanpham-danhmuc-id/${product_id}`);
                    $scope.sanphamDanhmucID = response.data.sanphams;
                    console.log('asbasvasgv', $scope.sanphamDanhmucID);
                } catch (error) {
                    console.error('Exception:', error);
                }
            }
            getSanphamDanhmucID();
        });
    </script>
@endsection
@endsection
