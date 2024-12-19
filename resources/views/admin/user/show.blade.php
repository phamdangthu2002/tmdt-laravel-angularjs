@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5" ng-controller="ctrlShowUser">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4><i class="bx bx-user"></i> Danh Sách Người Dùng</h4>
            </div>
            <div class="card-body">
                <a href="/admin/user" class="btn btn-success mb-3">
                    <i class="bx bx-plus"></i> Thêm Người Dùng
                </a>
                <table class="table table-bordered table-striped" id="userTable">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Email</th>
                            <th>Số điện thoại</th>
                            <th>Trạng thái</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-if="users.length === 0">
                            <td colspan="5" class="text-center py-3">
                                <div class="alert alert-info mb-0" role="alert">
                                    <i class="bx bx-info-circle me-2"></i>
                                    Chưa có tài khoản người dùng nào trong hệ thống
                                </div>
                            </td>
                        </tr>
                        <tr ng-repeat="user in users">
                            <td>@{{ user.id }}</td>
                            <td>@{{ user.name }}</td>
                            <td>@{{ user.email }}</td>
                            <td>@{{ user.phone }}</td>
                            <td>
                                <span ng-if="user.status === 'active'">
                                    <p class="badge text-success">Hoạt động</p>
                                </span>
                                <span ng-if="user.status === 'inactive'">
                                    <p class="badge text-danger">Khóa</p>
                                </span>
                            </td>
                            <td>
                                <a ng-click="editUser(user)" class="btn btn-warning"><i class="bx bx-edit"></i></a>
                                <a ng-click="deleteUser(user.id)" class="btn btn-danger"><i class="bx bx-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
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
        </div>

        <!-- Modal -->
        <div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Chỉnh sửa thông tin người dùng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userName">Tên</label>
                                        <input type="text" class="form-control" id="userName"
                                            ng-model="selectedUser.name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userEmail">Email</label>
                                        <input type="email" class="form-control" id="userEmail"
                                            ng-model="selectedUser.email">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" placeholder="Nếu có thay đổi"
                                    ng-model="selectedUser.password_new">
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="userPhone">Số điện thoại</label>
                                        <input type="text" class="form-control" id="userPhone"
                                            ng-model="selectedUser.phone">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="address">Địa chỉ</label>
                                        <input type="text" class="form-control" id="address"
                                            ng-model="selectedUser.address">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="role">Phân quyền</label>
                                        <select name="role" id="role" class="form-control"
                                            ng-model="selectedUser.role">
                                            <option value="user">User</option>
                                            <option value="admin">Admin</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="status">Trạng thái</label>
                                        <select name="status" id="status" class="form-control"
                                            ng-model="selectedUser.status">
                                            <option value="active">Kích hoạt</option>
                                            <option value="inactive">Tạm khóa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" ng-click="saveUser()">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('angular')
    <script>
        app.controller('ctrlShowUser', function($scope, $http) {
            $scope.users = [];
            $scope.pagination = {};
            $scope.selectedUser = {}; // Đối tượng để lưu thông tin người dùng được chọn

            const getAllUser = async function(page = 1) {
                try {
                    const response = await $http.get(`/api/user?page=${page}`);
                    $scope.users = response.data.users.data;
                    $scope.pagination = {
                        current_page: response.data.users.current_page,
                        last_page: response.data.users.last_page,
                        total: response.data.users.total
                    };
                    $scope.$applyAsync();
                    console.log($scope.users);
                } catch (error) {
                    console.log(error);
                }
            }

            $scope.paginationRange = function() {
                const maxVisiblePages = 3; // số trang hiển thị nhiều nhất
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
            }

            $scope.changePage = function(page) {
                if (page === '...' || page < 1 || page > $scope.pagination.last_page) {
                    return;
                }
                getAllUser(page);
            }

            $scope.editUser = function(user) {
                $scope.selectedUser = JSON.parse(JSON.stringify(user)); // Sao chép thông tin người dùng để chỉnh sửa 
                const modal = new bootstrap.Modal(
                    document.getElementById("editUserModal")
                );
                modal.show();
            }

            $scope.saveUser = async function() {
                // Gửi yêu cầu PUT tới API để lưu thông tin người dùng
                await $http.put('/api/user/' + $scope.selectedUser.id, $scope.selectedUser)
                    .then(function(response) {
                        if (response.data.success) {
                            // Đóng modal sau khi lưu thành công
                            $("#editUserModal").modal("hide");
                            // Tải lại danh sách người dùng
                            getAllUser($scope.pagination.current_page);
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Thông tin người dùng đã được cập nhật thành công.',
                                icon: 'success',
                                timer: 1500
                            });
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Không thể cập nhật thông tin người dùng. Vui lòng thử lại sau.',
                            icon: 'error'
                        });
                    });
            }

            $scope.deleteUser = function(id) {
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: "Bạn không thể hoàn tác hành động này!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Đồng ý xóa',
                    cancelButtonText: 'Hủy'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $http.delete('/api/user/' + id)
                            .then(function(response) {
                                if (response.data.success) {
                                    Swal.fire({
                                        title: 'Đã xóa!',
                                        text: 'Người dùng đã được xóa thành công.',
                                        icon: 'success',
                                        timer: 1500
                                    });
                                    getAllUser($scope.pagination.current_page);
                                    $scope.$applyAsync()
                                }
                            })
                            .catch(function(error) {
                                Swal.fire({
                                    title: 'Lỗi!',
                                    text: 'Không thể xóa người dùng. Vui lòng thử lại sau.',
                                    icon: 'error'
                                });
                                console.error('Lỗi khi xóa:', error);
                            });
                    }
                });
            }

            getAllUser();
        });
    </script>
@endsection
