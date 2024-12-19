@extends('user.layouts.layout')
@section('content')
    <div ng-controller="ctrlDonhang">
        <div class="container mt-5 pt-4 card shadow">
            <div class="card-header">
                <h2 class="mb-4 mt-4">{{ $title }}</h2>
            </div>

            <div class="card-body">
                <div class="table table-responsive">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Order ID</th>
                                <th>Date</th>
                                <th>Status</th>
                                <th>Total</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="donhang in donhangs">
                                <td>@{{ donhang.id }}</td>
                                <td>@{{ donhang.created_at }}</td>
                                <td>
                                    <span class="badge text-dark" ng-if="donhang.status === 'pending'">
                                        <i class="bi bi-check-circle"></i>@{{ donhang.status }}
                                    </span>
                                    <span class="badge text-success" ng-if="donhang.status === 'completed'">
                                        <i class="bi bi-check-circle"></i>@{{ donhang.status }}
                                    </span>
                                    <span class="badge text-danger" ng-if="donhang.status === 'cancelled'">
                                        <i class="bi bi-check-circle"></i>@{{ donhang.status }}
                                    </span>
                                </td>
                                <td>@{{ donhang.total_amount | number }} VND</td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#orderModal" ng-click="open(donhang.id)">Xem chi tiết</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer">
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <li class="page-item" ng-class="{ disabled: pagination.current_page === 1 }">
                            <a class="page-link" ng-click="changePage(pagination.current_page - 1)"
                                style="cursor: pointer">Trước</a>
                        </li>
                        <li class="page-item" ng-class="{ active: n === pagination.current_page }"
                            ng-repeat="n in paginationRange() track by $index">
                            <a class="page-link" ng-click="changePage(n)" style="cursor: pointer">@{{ n }}</a>
                        </li>
                        <li class="page-item" ng-class="{ disabled: pagination.current_page === pagination.last_page }"> <a
                                class="page-link" ng-click="changePage(pagination.current_page + 1)"
                                style="cursor: pointer">Sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <div class="modal fade" id="orderModal" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Chi tiết đơn hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row" ng-repeat="donhang_item in donhang_items">
                            <div class="col-md-6">
                                <h6>chi tiết sản phẩm</h6>
                                <div class="card mb-3">
                                    <div class="row g-0">
                                        <div class="col-md-4">
                                            <img ng-src="@{{ donhang_item.product.images[0].image_path }}" class="img-fluid rounded-start"
                                                alt="Product">
                                        </div>
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h6 class="card-title">@{{ donhang_item.product.name }}</h6>
                                                <p class="card-text">Số lượng: @{{ donhang_item.quantity }}</p>
                                                <p class="card-text">RAM : @{{ donhang_item.product.attributes[0].ram }}</p>
                                                <p class="card-text">ROM : @{{ donhang_item.product.attributes[0].rom }}</p>
                                                <p class="card-text">Màu sắc : @{{ donhang_item.product.attributes[0].color }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <h6>Thông tin vận chuyển</h6>
                                <p>
                                    Name: {!! getLoggedInUser()->name !!}
                                    <br>Address: {!! getLoggedInUser()->address !!}
                                    <br>Phone: {!! getLoggedInUser()->phone !!}
                                </p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Track Order</button>
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
            $scope.donhang_items = [];
            $scope.pagination = {};
            var user_id = {!! json_encode(optional(getLoggedInUser())->id) !!} ?? null;

            // Function to get orders for the user
            const getDonhang = async function(page = 1) {
                try {
                    const response = await $http.get(`/api/don-hang/${user_id}?page=${page}`);
                    $scope.donhangs = response.data.donhang.data;

                    console.log('donhang', $scope.donhangs);

                    // Update pagination
                    $scope.pagination = {
                        current_page: response.data.donhang.current_page,
                        last_page: response.data.donhang.last_page,
                        total: response.data.donhang.total,
                        per_page: response.data.donhang.per_page,
                    };
                    $scope.$applyAsync();
                } catch (error) {
                    console.log(error);
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
                    return;
                }
                getDonhang(page); // Load orders for the selected page
            };

            $scope.open = async function(id) {
                try {
                    const response = await $http.get(`/api/dong-hang/get-don-hang/${id}`);
                    $scope.donhang_items = response.data.donhang;
                    console.log($scope.donhang_items);
                    $scope.$applyAsync();
                } catch (error) {
                    console.log(error);
                }
            }
            // Initial fetch
            getDonhang();
        });
    </script>
@endsection
