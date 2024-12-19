@extends('admin.layouts.layouts')

@section('content')
    <div class="container" ng-controller="ctrlDonhang">
        <div class="row">
            <!-- Cột bên trái: Danh sách đơn hàng -->
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <h2>Danh Sách Đơn Hàng</h2>
                        <table class="table table-bordered table-striped table-hover">
                            <thead class="table-active">
                                <tr>
                                    <th>Mã Đơn</th>
                                    <th>Người Mua</th>
                                    <th>Tổng Tiền</th>
                                    <th>Trạng Thái</th>
                                    <th>Hành Động</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-repeat="donhang in donhangs">
                                    <td>@{{ donhang.id }}</td>
                                    <td>@{{ donhang.user.name }}</td>
                                    <td>@{{ donhang.total_amount | number }} VND</td>
                                    <td>
                                        <span class="badge"
                                            ng-class="{
                                                'text-black': donhang.status === 'pending',
                                                'text-success': donhang.status === 'completed',
                                                'text-danger': donhang.status === 'cancelled'
                                            }">
                                            @{{ donhang.status }}
                                        </span>


                                    </td>
                                    <td>
                                        <a ng-if="donhang.status === 'pending'" class="btn btn-warning"
                                            ng-click="chiTiet(donhang.id)"><i class="bx bx-edit"></i></a>
                                        <a ng-if="donhang.status === 'completed'" class="btn btn-warning"
                                            ng-click="chiTiet(donhang.id)"><i class="bx bx-edit"></i></a>
                                        <a ng-if="donhang.status === 'cancelled'" class="btn btn-outline-danger"><i
                                                class='bx bxs-hide'></i></a>

                                    </td>
                                </tr>
                            </tbody>
                        </table>
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
                        <li class="page-item" ng-class="{ disabled: pagination.current_page === pagination.last_page }">
                            <a class="page-link" href="#" ng-click="changePage(pagination.current_page + 1)">Sau</a>
                        </li>
                    </ul>
                </nav>
            </div>

            <!-- Cột bên phải: Thông tin chi tiết đơn hàng và cập nhật trạng thái -->
            <div class="col-md-6" id="order-details">
                <div class="card shadow-sm">
                    <div class="card-body">
                        <div class="card shadow-sm">
                            <div class="card-body">
                                <h2>Chi Tiết Đơn Hàng</h2>
                                <table class="table table-bordered" id="product-list">
                                    <thead>
                                        <tr>
                                            <th>Mã Chi tiết Đơn Hàng:</th>
                                            <th>Người Mua:</th>
                                            <th>Địa Chỉ:</th>
                                            <th>Số Điện Thoại:</th>
                                            <th>Tổng Tiền:</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>@{{ chitietdonhang.id }}</td>
                                            <td>@{{ chitietdonhang.user.name }}</td>
                                            <td>@{{ chitietdonhang.user.diachi }}</td>
                                            <td>@{{ chitietdonhang.user.phone }}</td>
                                            <td>@{{ chitietdonhang.total_amount | number }} VND</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="card shadow-sm mt-2">
                            <div class="card-body">
                                <h4>Sản Phẩm Đặt Mua</h4>
                                <table class="table table-bordered" id="product-list">
                                    <thead>
                                        <tr>
                                            <th>Tên Sản Phẩm</th>
                                            <th>Giá</th>
                                            <th>Số Lượng</th>
                                            <th>Tổng Tiền</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr ng-repeat="sanpham in donhang_items">
                                            <td>@{{ sanpham.product.name }}</td>
                                            <td>@{{ sanpham.price_sale ? (sanpham.price_sale | number) : (sanpham.price | number) }} VND</td>
                                            <td>@{{ sanpham.quantity || 0 }}</td> <!-- Nếu quantity không có, hiển thị 0 -->
                                            <td>@{{ sanpham.price | number }} VND</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <h4>Cập Nhật Trạng Thái</h4>
                        <form id="status-form">
                            <div class="mb-3">
                                <label for="status" class="form-label">Trạng Thái</label>
                                <div ng-if="chitietdonhang.status === 'pending' || chitietdonhang.status === 'completed'">
                                    <select ng-model="donhang.status" class="form-control">
                                        <option value="completed">Completed</option>
                                        <option value="cancelled">Cancelled</option>
                                    </select>
                                    <!-- Hiển thị lỗi nếu có -->
                                    <div ng-if="errors" class="alert alert-danger">
                                        @{{ errors.id[0] }}
                                    </div>
                                </div>

                                <div ng-show="chitietdonhang.status === 'cancelled'" class="text-center text-success">
                                    <p>Hoàn tất đơn hàng</p>
                                </div>
                            </div>
                            <button ng-hide="chitietdonhang.status === 'completed'" type="submit" class="btn btn-primary"
                                ng-click="updateDonhang(donhang_items[0].order.id)">Cập Nhật</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('angular')
    <script>
        app.controller('ctrlDonhang', function($scope, $http) {
            $scope.donhangs = [];
            $scope.pagination = {};
            $scope.donhang_items = [];
            $scope.chitietdonhang = [];
            $scope.donhang = {
                status: ''
            }
            const getAllDonhang = async function(page = 1) {
                try {
                    const response = await $http.get('/api/don-hang/all?page=' + page);
                    $scope.donhangs = response.data.donhang.data;
                    $scope.pagination = {
                        current_page: response.data.donhang.current_page,
                        last_page: response.data.donhang.last_page,
                        total: response.data.donhang.total,
                        per_page: response.data.donhang.per_page,
                    };
                    console.log($scope.donhangs);
                    $scope.$applyAsync();

                } catch (error) {
                    console.error(error);
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
                    getAllDonhang(page); // Load products for the selected page
                };
            }

            $scope.chiTiet = async function(id) {
                try {
                    const response = await $http.get(`/api/dong-hang/get-don-hang/${id}`);
                    $scope.donhang_items = response.data.donhang;
                    $scope.chitietdonhang = response.data.donhang[0].order;
                    console.log('item', $scope.donhang_items[0].order.id);
                    console.log('chitiet', $scope.chitietdonhang);
                    $scope.$applyAsync();
                } catch (error) {
                    console.log(error);
                }
            }
            $scope.updateDonhang = async function(id) {
                try {
                    const response = await $http.put(`/api/don-hang/update/${id}`, $scope.donhang);
                    console.log(response.data);
                    getAllDonhang();
                    $scope.$applyAsync();
                } catch (error) {
                    console.log(error);
                }
            }
            getAllDonhang();
        });
    </script>
@endsection
