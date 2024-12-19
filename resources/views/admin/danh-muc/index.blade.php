@extends('admin.layouts.layouts')
@section('content')
    <div class="container mt-5" ng-controller="ctrlDanhmuc">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4><i class="bx bx-plus-circle"></i> Thêm Danh Mục</h4>
            </div>
            <div class="card-body">
                <!-- Form thêm danh mục -->
                <form>
                    @csrf
                    <!-- Tên danh mục -->
                    <div class="mb-3">
                        <label for="categoryName" class="form-label">Tên danh mục</label>
                        <input type="text" class="form-control" id="categoryName" name="categoryName"
                            ng-model="cate.name">
                    </div>

                    <!-- Mô tả danh mục -->
                    <div class="mb-3">
                        <label for="categoryDescription" class="form-label">Mô tả</label>
                        <textarea class="form-control" id="categoryDescription" name="categoryDescription" rows="4"
                            ng-model="cate.description"></textarea>
                    </div>

                    <!-- Trạng thái -->
                    <div class="form-group mb-3">
                        <label for="status">Trạng thái</label>
                        <select name="status" id="status" class="form-control" ng-model="cate.status">
                            <option value="active">Kích hoạt</option>
                            <option value="inactive">Tạm khóa</option>
                        </select>
                    </div>

                    <!-- Parent ID -->
                    <div class="mb-3">
                        <label for="parentId" class="form-label">Parent ID</label>
                        <select name="parentId" id="parentId" class="form-control" ng-model="cate.parent_id">
                            <option ng-repeat="danhmuc in listDanhmucs" value="@{{ danhmuc.id }}">
                                @{{ danhmuc.name }}
                            </option>
                        </select>
                    </div>

                    <!-- Nút thêm -->
                    <div class="d-flex justify-content-between">
                        <a ng-click="addDanhmuc()" type="submit" class="btn btn-primary">
                            <i class="bx bx-plus"></i> Thêm
                        </a>
                        <a href="{{ route('admin.danhmuc') }}" class="btn btn-secondary">
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
        app.controller('ctrlDanhmuc', function($scope, $http) {
            $scope.cate = {};
            const getAllDanhmuc = async function() {
                try {
                    const response = await $http.get('/api/danh-muc/create');
                    $scope.listDanhmucs = response.data.danhmucs;
                    $scope.$applyAsync();
                    console.log($scope.listDanhmucs);

                } catch (error) {
                    console.log(error);
                }
            }

            $scope.addDanhmuc = function() {
                $http.post('/api/danh-muc', $scope.cate).then(
                    function(response) {
                        if (response.data.success) {
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Danh mục đã được thêm thành công.',
                                icon: 'success',
                                timer: 1500
                            });
                        }
                        $scope.cate = {};
                        getAllDanhmuc();
                        $scope.$applyAsync();
                    }).catch(
                    function(error) {
                        console.log(error);
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Không thể thêm danh mục. Vui lòng thử lại sau.',
                            icon: 'error'
                        });
                    }
                );
            }
            getAllDanhmuc();
        });
    </script>
@endsection
