@extends('admin.layouts.layouts')

@section('content')
    <div class="container mt-5" ng-controller="ctrlShowDanhmuc">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h4><i class="bx bx-category"></i> Danh Sách Danh Mục</h4>
            </div>
            <div class="card-body">
                <!-- Nút thêm danh mục -->
                <a href="/admin/danh-muc" class="btn btn-success mb-3">
                    <i class="bx bx-plus"></i> Thêm Danh Mục
                </a>
                <!-- Bảng danh mục -->
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên Danh Mục</th>
                            <th>Mô tả</th>
                            <th>Trạng Thái</th>
                            <th>Parent_id</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Mảng danh mục rỗng -->
                        <div ng-if="listDanhmucs.length === 0" class="alert alert-warning" role="alert">
                            <i class="bx bx-info-circle"></i> Hiện tại chưa có danh mục nào. Hãy thêm một danh mục mới!
                        </div>
                        <tr ng-repeat="danhmuc in listDanhmucs">
                            <td>@{{ danhmuc.id }}</td>
                            <td>@{{ danhmuc.name }}</td>
                            <td>@{{ danhmuc.description }}</td>
                            <td>
                                <span ng-if="danhmuc.status === 'active'">
                                    <p class="badge text-success">Hoạt động</p>
                                </span>
                                <span ng-if="danhmuc.status === 'inactive'">
                                    <p class="badge text-danger">Tạm khóa</p>
                                </span>
                            </td>
                            <td>@{{ danhmuc.parent_id }}</td>
                            <td>
                                <a ng-click="editDanhmuc(danhmuc)" class="btn btn-warning"><i class="bx bx-edit"></i></a>
                                <a ng-click="deleteDanhmuc(danhmuc.id)" class="btn btn-danger"><i
                                        class="bx bx-trash"></i></a>
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
                        <li class="page-item" ng-class="{ disabled: pagination.current_page === pagination.last_page }"> <a
                                class="page-link" href="#" ng-click="changePage(pagination.current_page + 1)">Sau</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <!-- Modal Chỉnh Sửa Danh Mục -->
        <div class="modal fade" id="editDanhmucModal" tabindex="-1" role="dialog" aria-labelledby="editDanhmucModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editDanhmucModalLabel">Chỉnh sửa Danh Mục</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="danhmucName">Tên Danh Mục</label>
                                        <input type="text" class="form-control" id="danhmucName"
                                            ng-model="selectedDanhmuc.name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="danhmucStatus">Trạng thái</label>
                                        <select class="form-control" id="danhmucStatus" ng-model="selectedDanhmuc.status">
                                            <option value="active">Kích hoạt</option>
                                            <option value="inactive">Tạm khóa</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="danhmucDescription">Mô tả</label>
                                <textarea class="form-control" id="danhmucDescription" rows="4" ng-model="selectedDanhmuc.description"></textarea>
                            </div>
                            <div class="form-group">
                                <label for="danhmucParentId">Parent ID</label>
                                <select name="parentId" id="parentId" class="form-control"
                                    ng-model="selectedDanhmuc.parent_id">
                                    <option ng-repeat="danhmuc in parent_id" value="@{{ danhmuc.id }}"
                                        ng-selected="danhmuc.id == selectedDanhmuc.parent_id">
                                        @{{ danhmuc.name }}
                                    </option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" ng-click="saveDanhmuc()">Lưu thay đổi</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('angular')
    <script>
        app.controller('ctrlShowDanhmuc', function($scope, $http) {
            $scope.danhmuc = [];
            $scope.listDanhmucs = [];
            $scope.parent_id = [];
            $scope.pagination = {};
            const parent_id = async function() {
                const response = await $http.get('/api/danh-muc/create');
                $scope.parent_id = response.data.danhmucs;
                console.log('áhhjasfjas', $scope.parent_id);
                $scope.$applyAsync();
            }
            const getAllDanhmuc = async function(page = 1) {
                try {
                    const response = await $http.get('/api/danh-muc?page=' + page);
                    $scope.listDanhmucs = response.data.danhmucs.data;
                    $scope.pagination = {
                        current_page: response.data.danhmucs.current_page,
                        last_page: response.data.danhmucs.last_page,
                        total: response.data.danhmucs.total,
                        per_page: response.data.danhmucs.per_page,
                    };
                    $scope.$applyAsync();
                    console.log($scope.listDanhmucs);
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
                getAllDanhmuc(page);
            }

            $scope.editDanhmuc = function(danhmuc) {
                $scope.selectedDanhmuc = JSON.parse(JSON.stringify(
                    danhmuc)); // Sao chép thông tin người dùng để chỉnh sửa 
                const modal = new bootstrap.Modal(
                    document.getElementById("editDanhmucModal")
                );
                modal.show();
            }

            $scope.saveDanhmuc = async function() {
                // Gửi yêu cầu PUT tới API để lưu thông tin người dùng
                await $http.put('/api/danh-muc/' + $scope.selectedDanhmuc.id, $scope.selectedDanhmuc)
                    .then(function(response) {
                        if (response.data.success) {
                            // Đóng modal sau khi lưu thành công
                            $("#editDanhmucModal").modal("hide");
                            // Tải lại danh sách người dùng
                            getAllDanhmuc($scope.pagination.current_page);
                            Swal.fire({
                                title: 'Thành công!',
                                text: 'Thông tin danh mục đã được cập nhật thành công.',
                                icon: 'success',
                                timer: 1500
                            });
                        }
                    })
                    .catch(function(error) {
                        console.log(error);
                        Swal.fire({
                            title: 'Lỗi!',
                            text: 'Không thể cập nhật thông tin danh mục. Vui lòng thử lại sau.',
                            icon: 'error'
                        });
                    });
            }

            $scope.deleteDanhmuc = function(id) {
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
                        $http.delete('/api/danh-muc/' + id).then(
                            function(response) {
                                if (response.data.success) {
                                    Swal.fire({
                                        title: 'Đã xóa!',
                                        text: 'Danh mục đã được xóa thành công.',
                                        icon: 'success',
                                        timer: 1500
                                    });
                                    getAllDanhmuc($scope.pagination.current_page);
                                    $scope.$applyAsync()
                                }
                            }).catch(
                            function(error) {
                                Swal.fire({
                                    title: 'Lỗi!',
                                    text: 'Không thể xóa danh mục. Vui lòng thử lại sau.',
                                    icon: 'error'
                                });
                                console.error('Lỗi khi xóa:', error);
                            }
                        );
                    }
                });
            }
            parent_id();
            getAllDanhmuc();
        });
    </script>
@endsection
