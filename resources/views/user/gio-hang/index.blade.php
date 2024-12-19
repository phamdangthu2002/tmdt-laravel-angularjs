@extends('user.layouts.layout')
@section('content')
    <style>
        @media (min-width: 1025px) {
            .h-custom {
                height: 100vh !important;
            }
        }

        .cart-item img {
            width: 100px;
            height: auto;
            object-fit: cover;
        }

        .cart-summary {
            background-color: #f8f9fa;
            border-radius: 10px;
            padding: 30px;
        }

        .btn-quantity {
            border: none;
            background: #e9ecef;
            color: #495057;
            font-size: 16px;
        }

        .btn-quantity:hover {
            background: #ced4da;
        }

        @media (max-width: 768px) {
            .cart-item img {
                width: 80px;
                height: auto;
            }

            .cart-item h5 {
                font-size: 14px;
            }

            .cart-item .form-control {
                width: 50px;
            }

            .cart-summary {
                padding: 20px;
            }

            .cart-summary h4 {
                font-size: 18px;
            }

            .cart-summary .form-label {
                font-size: 14px;
            }

            .cart-summary button {
                font-size: 14px;
                padding: 10px;
            }
        }
    </style>
    <div class="container py-5 h-100" ng-controller="ctrlCart">
        <div class="row d-flex justify-content-center align-items-center h-100">
            <div class="col-12 card shadow">
                <div class="card-body p-0">
                    <div class="row g-0">
                        <!-- Danh sách sản phẩm -->
                        <div class="col-lg-8 col-12 mb-4">
                            <div class="p-4">
                                <h3 class="fw-bold mb-4">Giỏ Hàng Của Bạn</h3>
                                <h5 class="text-center" ng-if="carts.length == 0">Giỏ hàng của bạn trống</h5>
                                <hr class="mb-4">

                                <!-- Sản phẩm 1 -->
                                <div class="row mb-4 align-items-center cart-item" ng-repeat="cart in carts">
                                    <div class="col-md-2 col-3">
                                        <img ng-src="@{{ cart.product_image }}" alt="iPhone 13" class="img-fluid rounded-3">
                                    </div>
                                    <div class="col-md-3 col-6">
                                        <h6 class="text-muted">Điện thoại</h6>
                                        <h5 class="mb-0">@{{ cart.product_name }}</h5>
                                        <p>RAM: @{{ cart.ram }}, ROM: @{{ cart.rom }} Màu sắc:
                                            @{{ cart.color }}</p>
                                    </div>
                                    <div class="col-md-2 col-6 d-flex mt-2 mt-md-0">
                                        <button class="btn btn-quantity px-2" ng-click="tru(cart.product_id)">
                                            <i class="fas fa-minus">-</i>
                                        </button>
                                        <input min="0" name="quantity" type="number" ng-model="cart.quantity"
                                            class="form-control form-control-sm mx-2 text-center" style="width: 60px;" />
                                        <button class="btn btn-quantity px-2" ng-click="cong(cart.product_id)">
                                            <i class="fas fa-plus">+</i>
                                        </button>
                                    </div>
                                    <div class="col-12 col-md-3 text-center mt-2 mt-md-0">
                                        <h6 class="mb-0 fw-bold">@{{ cart.price | number }} VND</h6>
                                    </div>
                                    <div class="col-md-1 col-3 text-end">
                                        <a ng-click="deleteCart(cart.product_id)" class="btn btn-outline-danger"><i
                                                class="bx bx-trash"></i></a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tổng kết giỏ hàng -->
                        <div class="col-lg-4 col-12">
                            <div class="cart-summary">
                                <h4 class="fw-bold mb-4">Tóm Tắt Đơn Hàng</h4>

                                <!-- Form thông tin người dùng -->
                                <div class="mb-4">
                                    <h6 class="fw-bold">Thông Tin Người Nhận</h6>
                                    <form id="user-info-form">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Họ và tên</label>
                                            <input type="text" class="form-control" id="name"
                                                placeholder="Nhập họ và tên" ng-model="user.name">
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" class="form-control" id="email"
                                                placeholder="Nhập email" ng-model="user.email">
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone" class="form-label">Số điện thoại</label>
                                            <input type="text" class="form-control" id="phone"
                                                placeholder="Nhập số điện thoại" ng-model="user.phone">
                                        </div>
                                        <div class="mb-3">
                                            <label for="address" class="form-label">Địa chỉ</label>
                                            <textarea class="form-control" id="address" rows="2" placeholder="Nhập địa chỉ giao hàng"
                                                ng-model="user.address"></textarea>
                                        </div>
                                    </form>
                                </div>

                                <!-- Tóm tắt đơn hàng -->
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Tổng sản phẩm</span>
                                    <span class="fw-bold">@{{ total | number }} VND</span>
                                </div>
                                <div class="d-flex justify-content-between mb-3">
                                    <span>Phí vận chuyển</span>
                                </div>

                                <div class="d-flex justify-content-between mb-3">
                                    <span>Vận chuyển tiêu chuẩn</span>
                                    <span class="fw-bold">Miễn phí</span>
                                </div>
                                <hr>
                                <div class="d-flex justify-content-between mb-4">
                                    <span>Tổng thanh toán</span>
                                    <span class="fw-bold text-danger fs-5">@{{ total | number }} VND</span>
                                </div>

                                <!-- Nút thanh toán -->
                                <button class="btn btn-success btn-lg w-100" ng-click="payment(cart.id)">
                                    Thanh Toán Ngay
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('angular')
    <script>
        app.controller('ctrlCart', function($scope, $http) {
            $scope.carts = {};
            var user_id = {!! json_encode(optional(getLoggedInUser())->id) !!} ?? null;
            var name = {!! json_encode(optional(getLoggedInUser())->name) !!} ?? null;
            var email = {!! json_encode(optional(getLoggedInUser())->email) !!} ?? null;
            var phone = {!! json_encode(optional(getLoggedInUser())->phone) !!} ?? null;
            var address = {!! json_encode(optional(getLoggedInUser())->address) !!} ?? null;
            $scope.user = {
                user_id: user_id,
                name: name,
                email: email,
                phone: phone,
                address: address,
                quantity: 0,
                total: 0,
            }

            const getCart = async function() {
                try {
                    const response = await $http.get('/api/cart/get-cart');
                    $scope.carts = response.data.carts;
                    $scope.total = response.data.total;
                    // Cập nhật total vào đối tượng user
                    $scope.user.total = $scope.total;
                    $scope.user.quantity = $scope.carts.reduce((sum, cart) => sum + cart.quantity, 0);
                    console.log($scope.carts);
                    console.log($scope.total);
                    $scope.$applyAsync();
                } catch (error) {
                    console.log(error);
                }
            }
            getCart();

            $scope.payment = async function(id) {
                try {
                    const response = await $http.post('/api/cart/payment', $scope.user);

                    // Kiểm tra phản hồi từ server
                    if (response.data.status === 200) {
                        // Thông báo thanh toán thành công
                        Swal.fire({
                            title: 'Thanh toán thành công!',
                            text: 'Cảm ơn bạn đã mua hàng.',
                            icon: 'success',
                            confirmButtonText: 'Đóng'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Chuyển hướng nếu cần
                                window.location.href = '/'; // Hoặc trang khác
                            }
                        });
                    } else {
                        // Thông báo thất bại nếu không phải status 200
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Thanh toán không thành công. Vui lòng thử lại.',
                            icon: 'error',
                            confirmButtonText: 'Đóng'
                        });
                    }
                } catch (error) {
                    // Thông báo lỗi nếu gặp lỗi trong quá trình gọi API
                    console.log(error);
                    Swal.fire({
                        title: 'Lỗi!',
                        text: 'Đã xảy ra lỗi trong quá trình thanh toán. Vui lòng thử lại.',
                        icon: 'error',
                        confirmButtonText: 'Đóng'
                    });
                }
            };
            // Hàm giảm số lượng
            $scope.tru = function(id) {
                const cart = $scope.carts.find(c => c.product_id === id); // Tìm sản phẩm theo ID
                if (cart) {
                    if (cart.quantity > 1) {
                        cart.quantity -= 1;
                        updateQuantity(id, cart.quantity); // Gọi hàm cập nhật
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Giá trị tối thiểu',
                            text: 'Số lượng không thể nhỏ hơn 1!',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            };

            // Hàm tăng số lượng
            $scope.cong = function(id) {
                const cart = $scope.carts.find(c => c.product_id === id); // Tìm sản phẩm theo ID
                if (cart) {
                    if (cart.quantity < 10) {
                        cart.quantity += 1;
                        updateQuantity(id, cart.quantity); // Gọi hàm cập nhật
                    } else {
                        Swal.fire({
                            icon: 'warning',
                            title: 'Giá trị tối đa',
                            text: 'Số lượng không thể lớn hơn 10!',
                            confirmButtonText: 'OK'
                        });
                    }
                }
            };
            // Hàm cập nhật số lượng
            function updateQuantity(id, quantity) {
                $http.post('/api/cart/update/quantity', {
                        id: id,
                        quantity: quantity
                    })
                    .then(function(response) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Cập nhật thành công',
                            text: 'Số lượng sản phẩm đã được cập nhật!',
                            confirmButtonText: 'OK'
                        });
                        getCart();
                    })
                    .catch(function(error) {
                        console.error(error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Lỗi cập nhật',
                            text: 'Không thể cập nhật số lượng sản phẩm. Vui lòng thử lại!',
                            confirmButtonText: 'OK'
                        });
                    });
            }
            $scope.deleteCart = async function(id) {
                Swal.fire({
                    title: 'Xóa sản phẩm',
                    text: 'Bạn có chắc chắn muốn xóa sản phẩm này?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Xóa',
                }).then((result) => {
                    if (result) {
                        $http.delete('/api/cart/delete/' + id)
                            .then(function(response) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Xóa thành công',
                                    text: 'Sản phẩm đã được xóa khỏi giỏ hàng!',
                                    confirmButtonText: 'OK'
                                });
                                getCart();
                            })
                            .catch(function(error) {
                                console.error(error);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Lỗi xóa',
                                    text: 'Không thể xóa sản phẩm. Vui lòng thử lại!',
                                    confirmButtonText: 'OK'
                                });
                            });
                    }
                });
            }
        });
    </script>
@endsection
