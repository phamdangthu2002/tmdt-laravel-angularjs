@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5" ng-controller="ctrlUser">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4><i class="bx bx-user"></i> Thêm Người Dùng</h4>
            </div>
            <div class="card-body">
                <form>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name"><i class="bx bx-user"></i> Họ và tên</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Nhập họ và tên" ng-model="user.name">

                            </div>
                            <div class="text-danger" ng-if="errors.name">
                                @{{ errors.name[0] }} <!-- Hiển thị lỗi đầu tiên trong mảng lỗi -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="email"><i class="bx bx-envelope"></i> Email </label>
                                <input type="email" class="form-control" id="email" name="email"
                                    placeholder="Nhập email" ng-model="user.email">
                                <div class="text-danger" ng-if="errors.email">
                                    @{{ errors.email[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password"> <i class="bx bx-lock"></i> Mật khẩu </label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Nhập mật khẩu" ng-model="user.password">
                                <div class="text-danger" ng-if="errors.password">
                                    @{{ errors.password[0] }}
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="password_confirmation"> <i class="bx bx-lock-alt"></i> Xác nhận mật khẩu
                                </label>
                                <input type="password" class="form-control" id="password_confirmation"
                                    name="password_confirmation" ng-model="user.password_confirmation"
                                    placeholder="Xác nhận mật khẩu">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone"> <i class="bx bx-phone"></i> Số điện thoại
                                </label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Nhập số điện thoại" ng-model="user.phone">
                                <div class="text-danger" ng-if="errors.phone">
                                    @{{ errors.phone[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="role">Phân quền</label>
                                <select name="role" id="role" class="form-control" ng-model="user.role">
                                    <option value="user">User</option>
                                    <option value="admin">Admin</option>
                                </select>
                                <div class="text-danger" ng-if="errors.role">
                                    @{{ errors.role[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="status"> Trạng thái</label>
                                <select name="status" id="status" class="form-control" ng-model="user.status">
                                    <option value="active">Kích hoạt</option>
                                    <option value="inactive">Tạm khóa</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="address"> <i class="bx bx-map"></i> Địa chỉ địa </label>
                                <textarea class="form-control" name="address" id="address" cols="30" rows="4" ng-model="user.address"></textarea>
                                <div class="text-danger" ng-if="errors.address">
                                    @{{ errors.address[0] }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex justify-content-between mt-3">
                        <a type="submit" class="btn btn-primary" ng-click="addUser()">
                            <i class="bx bx-plus"></i> Thêm
                        </a>
                        <a href="{{ route('admin.user') }}" class="btn btn-secondary">
                            <i class="bx bx-arrow-back"></i> Quay lại
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('angular')
    <script>
        app.controller('ctrlUser', function($scope, $http) {
            // Khởi tạo dữ liệu người dùng
            $scope.user = {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
                phone: '',
                status: '',
                address: '',
                role: '',
            };

            // Hàm thêm người dùng
            $scope.addUser = async function() {
                console.log($scope.user);
                try {
                    // Xóa lỗi trước khi gửi yêu cầu mới

                    const response = await $http.post('/api/user', $scope.user); // Đợi phản hồi từ API

                    Swal.fire({
                        title: 'Thành công!',
                        text: response.message,
                        icon: 'success',
                        confirmButtonText: 'Đã hiểu',
                        confirmButtonColor: '#4CAF50', // Màu sắc của nút
                        background: '#f1f8e9', // Màu nền
                        customClass: {
                            title: 'custom-title', // Lớp CSS cho tiêu đề
                            popup: 'custom-popup', // Lớp CSS cho popup
                        },
                        willClose: () => {
                            // Thêm hiệu ứng sau khi đóng (nếu cần)
                            console.log('Thông báo đã đóng!');
                        },
                    });
                    $scope.user = {}; // Làm trống form
                    $scope.$applyAsync();

                } catch (error) {
                    console.log('Có lỗi xảy ra: ', error); // In lỗi ra console
                    if (error.status === 422) {
                        // Lưu lỗi trả về vào scope để hiển thị trong form
                        $scope.errors = error.data.error; // Lưu vào $scope.errors
                        $scope.$applyAsync();
                        console.log($scope.errors);
                    } else {
                        console.log("Đã xảy ra lỗi, vui lòng thử lại.");
                    }
                }
            };
        });
    </script>
@endsection
