@extends('user.layouts.layout')

@section('content')
    <div class="container mt-5" ng-controller="ctrlUser">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4><i class="bx bx-user"></i> Thông tin của bạn</h4>
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
                                <label for="password"> <i class="bx bx-lock"></i> Mật khẩu mới</label>
                                <input type="password" class="form-control" id="password" name="password"
                                    placeholder="Nếu có thay đổi" ng-model="user.password_new">
                                <div class="text-danger" ng-if="errors.password_new">
                                    @{{ errors.password[0] }}
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="phone"> <i class="bx bx-phone"></i> Số điện thoại
                                </label>
                                <input type="text" class="form-control" id="phone" name="phone"
                                    placeholder="Nhập số điện thoại" ng-model="user.phone">
                                <div class="text-danger" ng-if="errors.phone">
                                    @{{ errors.phone[0] }}
                                </div>
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
                        <a type="submit" class="btn btn-primary" ng-click="updateUser()">
                            <i class="bx bx-plus"></i> Cập nhật
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
                password_new: '',
                phone: '',
                status: '',
                address: '',
                role: '',
            };
            var user_id = {!! json_encode(optional(getLoggedInUser())->id) !!} ?? null;

            const getUser = async function() {
                try {
                    const response = await $http.get(`/api/user/profile/${user_id}`);
                    $scope.user = response.data.user;
                    console.log(response.data);
                } catch (error) {
                    console.log(error);
                }
            }

            // Hàm thêm người dùng
            $scope.updateUser = function() {
                $http.post('/api/user/profile/update', $scope.user).then(
                    function(response) {
                        console.log(response.data);
                        getUser();
                    }
                ).catch(function(error) {
                    console.log(error);
                });
            }
            getUser();
        });
    </script>
@endsection
