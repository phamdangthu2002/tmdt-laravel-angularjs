@extends('admin.layouts.layouts')

@section('content')
    <style>
        .text-truncate {
            display: -webkit-box;
            -webkit-line-clamp: 2;
            /* Giới hạn số dòng hiển thị */
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3rem;
            /* Giới hạn chiều cao để kích hoạt ellipsis */
            line-height: 1.5rem;
            /* Đảm bảo khoảng cách dòng */
            max-width: 150px;
            /* Đảm bảo chiều rộng hợp lý để có thể hiển thị ellipsis */
        }

        #anhsp_preview {
            display: flex;
            flex-wrap: wrap;
            /* Cho phép các ảnh xuống dòng nếu không đủ chỗ */
            gap: 10px;
            height: 300px;
            /* Khoảng cách giữa các ảnh */
            overflow-x: hidden;
        }

        .card-img-top {
            width: 100%;
            height: 200px;
            background-size: cover;
        }
    </style>
    <!-- Trang hiển thị sản phẩm -->
    <div ng-controller="ctrlSanpham" class="container">
        <div class="mt-5 card shadow">
            <div class="card-header">
                <h1 class="mb-4">{{ $title }}</h1>
            </div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Ảnh</th>
                            <th>Tên Sản Phẩm</th>
                            <th>Danh mục</th>
                            <th>Mô Tả</th>
                            <th>Giá</th>
                            <th>Giá Giảm</th>
                            <th>Số Lượng</th>
                            <th>Trạng Thái</th>
                            <th>Thao Tác</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="product in listProduct">
                            {{-- <td><img ng-src="@{{ product.images.split(',')[0] }}" alt="@{{ product.name }}" width="50" height="50"></td> --}}
                            <td>@{{ product.id }}</td>
                            <td><img ng-src="@{{ product.images[0].image_path }}" alt="Ảnh sản phẩm" width="50" height="50">
                            </td>
                            <td>@{{ product.name }}</td>
                            <td>@{{ product.category.name }}</td>
                            <td>
                                <div class="text-truncate">@{{ product.description }}</div>
                            </td>
                            <td>@{{ product.price | number }}VND</td>
                            <td>@{{ product.discount | number }}VND</td>
                            <td>@{{ product.quantity }}</td>
                            <td>
                                <div ng-if="product.status === 'available'" class="badge text-success">Có sẳn</div>
                                <div ng-if="product.status === 'out_of_stock'" class="badge text-danger">Tạm hết hàng</div>
                            <td>
                                <a class="btn btn-warning" ng-click="editProduct(product)"><i class="bx bx-edit"></i></a>
                                <a class="btn btn-warning" ng-click="editImageProduct(product.id)"><i
                                        class="bx bx-image"></i></a>
                                <a class="btn btn-danger" ng-click="deleteProduct(product.id)"><i
                                        class="bx bx-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="card-footer">
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

        <!-- Modal sửa sản phẩm -->
        <div class="modal fade" id="editProduct" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editModalLabel">Sửa Sản Phẩm</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Tên Sản Phẩm</label>
                                        <input type="text" class="form-control" id="name"
                                            ng-model="selectedProduct.name" name="name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="quantity" class="form-label">Số Lượng</label>
                                        <input type="number" class="form-control" id="quantity"
                                            ng-model="selectedProduct.quantity">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="category_id" class="form-label">Danh mục</label>
                                <select class="form-select" name="category_id" id="category_id"
                                    ng-model="selectedProduct.category_id"
                                    ng-options="danhmuc.id as danhmuc.name for danhmuc in danhmucs">
                                </select>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Mô Tả</label>
                                        <textarea class="form-control" id="description" ng-model="selectedProduct.description" rows="7"></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="detail_description" class="form-label">Mô Tả Chi Tiết</label>
                                        <textarea class="form-control" id="detail_description" ng-model="selectedProduct.description_detail" rows="7"></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="price" class="form-label">Giá</label>
                                        <input type="number" class="form-control" id="price"
                                            ng-model="selectedProduct.price">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="discount" class="form-label">Giá Giảm</label>
                                        <input type="number" class="form-control" id="discount"
                                            ng-model="selectedProduct.discount">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Trạng thái</label>
                                        <select class="form-select" id="status" name="status"
                                            ng-model="selectedProduct.status">
                                            <option value="available">Có sẵn</option>
                                            <option value="out_of_stock">Tạm hết hàng</option>
                                        </select>
                                        <div class="text-danger" ng-if="errors.status">
                                            @{{ errors.status[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- Màu sắc -->
                                    <div class="mb-3">
                                        <label for="color" class="form-label">Màu sắc</label>
                                        <select class="form-select" name="color" id="color"
                                            ng-model="selectedProduct.color">
                                            <option value="black">Đen</option>
                                            <option value="white">Trắng</option>
                                            <option value="pink">Hồng</option>
                                            <option value="titansamac">Titan Sa mạc</option>
                                        </select>
                                        <div class="text-danger" ng-if="errors.color">
                                            @{{ errors.color[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <!-- RAM -->
                                    <div class="mb-3">
                                        <label for="ram" class="form-label">RAM</label>
                                        <select class="form-select" name="ram" id="ram"
                                            ng-model="selectedProduct.ram">
                                            <option value="4GB">4GB</option>
                                            <option value="8GB">8GB</option>
                                            <option value="16GB">16GB</option>
                                        </select>
                                        <div class="text-danger" ng-if="errors.ram">
                                            @{{ errors.ram[0] }}
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <!-- ROM -->
                                    <div class="mb-3">
                                        <label for="rom" class="form-label">ROM</label>
                                        <select class="form-select" name="rom" id="rom"
                                            ng-model="selectedProduct.rom">
                                            <option value="16GB">16GB</option>
                                            <option value="32GB">32GB</option>
                                            <option value="64GB">64GB</option>
                                            <option value="128GB">128GB</option>
                                            <option value="256GB">256GB</option>
                                            <option value="512GB">512GB</option>
                                            <option value="1TB">1TB</option>
                                        </select>
                                        <div class="text-danger" ng-if="errors.rom">
                                            @{{ errors.rom[0] }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" ng-click="saveProduct()">Lưu</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow">
            <div class="card-header">
                <h3 class="my-3">Chỉnh sửa ảnh</h3>
            </div>
            <div class="card-body">
                <!-- Hiển thị các ảnh có sẵn -->
                <div class="row mb-4">
                    <h5>Ảnh hiện có:</h5>
                    <div class="col-md-2" ng-repeat="getAllImage in getAllImages">
                        <div class="card card-image">
                            <img ng-src="@{{ getAllImage.image_path }}" class="card-img-top img-thumbnail" alt="Ảnh sẵn có">
                            <div class="card-body text-center">
                                <button class="btn btn-danger btn-sm" ng-click="removeImage(getAllImage.id)">
                                    <i class="bx bx-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Form chỉnh sửa ảnh -->
                <form>
                    <label for="anhsp" class="form-label">Chọn file (nhiều file có thể
                        chọn)</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="anhsp" name="anhsp[]" multiple />
                    </div>
                    <div id="anhsp_preview" class="image-preview"></div>
                </form>
            </div>
            <div class="card-footer">
                <button type="submit" class="btn btn-primary mt-3" ng-click="saveImage()">Lưu ảnh</button>
            </div>
        </div>
    </div>
    <script src="{{ asset('assets/js/anh.js') }}"></script>
@endsection


@section('angular')
    <script>
        app.controller('ctrlSanpham', function($scope, $http) {
            $scope.listProduct = [];
            $scope.parent_id = [];
            $scope.pagination = {};
            $scope.anhsp = [];
            const getAlldanhmuc = async function() {
                try {
                    const response = await $http.get('/api/danh-muc/create');
                    $scope.danhmucs = response.data.danhmucs_all;
                    console.log($scope.danhmucs);
                } catch (error) {
                    console.log(error);
                }
            }
            // Function to get all products from the API
            const getAllProduct = async function(page = 1) {
                try {
                    const response = await $http.get('/api/san-pham?page=' + page);
                    $scope.listProduct = response.data.sanphams.data;
                    $scope.pagination = {
                        current_page: response.data.sanphams.current_page,
                        last_page: response.data.sanphams.last_page,
                        total: response.data.sanphams.total,
                        per_page: response.data.sanphams.per_page,
                    };
                    $scope.$applyAsync();
                    console.log($scope.listProduct); // Log to check product list
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
                getAllProduct(page); // Load products for the selected page
            };

            $scope.editProduct = function(product) {
                $scope.selectedProduct = JSON.parse(JSON.stringify(
                    product)); // Sử dụng angular.copy thay vì JSON.parse
                $scope.selectedProduct.price = parseFloat($scope.selectedProduct.price);
                $scope.selectedProduct.discount = parseFloat($scope.selectedProduct.discount);
                $scope.selectedProduct.quantity = parseInt($scope.selectedProduct.quantity);
                $scope.selectedProduct.category_id = $scope.selectedProduct.category.id;
                $scope.selectedProduct.color = $scope.selectedProduct.attributes[0].color;
                $scope.selectedProduct.ram = $scope.selectedProduct.attributes[0].ram;
                $scope.selectedProduct.rom = $scope.selectedProduct.attributes[0].rom;
                console.log($scope.selectedProduct);

                const modal = new bootstrap.Modal(document.getElementById("editProduct"));
                modal.show(); // Hiển thị modal
            }

            $scope.saveProduct = async function() {
                try {
                    const response = await $http.put('/api/san-pham/' + $scope.selectedProduct.id, $scope
                        .selectedProduct);
                    $scope.sanphams = response.data;

                    // Hiển thị thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Sản phẩm đã được cập nhật thành công.',
                        showConfirmButton: false,
                        timer: 2000 // Đóng tự động sau 2 giây
                    });

                    // Đóng modal nếu cần thiết
                    $('#editProduct').modal('hide');
                    getAllProduct();
                } catch (error) {
                    console.error(error);

                    // Hiển thị thông báo lỗi
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Có lỗi xảy ra khi cập nhật sản phẩm. Vui lòng thử lại.',
                        confirmButtonText: 'Đóng'
                    });
                }
            };

            // Lấy phần tử input file theo ID
            var fileInput = document.getElementById('anhsp');

            // Đảm bảo rằng người dùng đã chọn ít nhất một file
            fileInput.addEventListener('change', function(event) {
                var files = event.target.files; // Lấy danh sách các file được chọn

                if (files.length > 0) {
                    // Duyệt qua các file đã chọn và thêm vào mảng anhsp
                    $scope.$apply(function() {
                        for (var i = 0; i < files.length; i++) {
                            $scope.anhsp.push(files[i]);
                        }
                    });
                    console.log($scope.anhsp); // In mảng anhsp ra console để kiểm tra
                }
            });

            $scope.saveImage = async function() {
                try {
                    // Tạo FormData
                    let formData = new FormData();

                    // Thêm các file vào FormData
                    $scope.anhsp.forEach((file) => {
                        formData.append('anhsp[]', file);
                    });

                    // Thêm ID của sản phẩm vào FormData
                    formData.append('id', $scope.id);

                    // Gửi yêu cầu POST
                    const response = await $http.post('/api/san-pham/image', formData, {
                        headers: {
                            'Content-Type': undefined
                        }
                    });

                    // Hiển thị thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Thành công!',
                        text: 'Ảnh đã được lưu thành công.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        // Reset lại mảng ảnh sau khi thông báo thành công
                        $scope.anhsp = [];
                        // Cập nhật lại danh sách ảnh
                        $scope.editImageProduct($scope.id);

                        // Xóa các ảnh đã chọn trong preview sau khi lưu thành công
                        document.getElementById('anhsp_preview').innerHTML = ''; // Xóa ảnh hiển thị
                        document.getElementById('anhsp').value = ''; // Xóa ảnh hiển thị
                        $scope.anhsp = []; // Xóa danh sách ảnh đã chọn
                    });

                } catch (error) {
                    console.error(error);

                    // Hiển thị thông báo lỗi
                    Swal.fire({
                        icon: 'error',
                        title: 'Lỗi!',
                        text: 'Không thể lưu ảnh. Vui lòng thử lại.',
                        confirmButtonText: 'Đóng'
                    });
                }
            };

            $scope.editImageProduct = async function(id) {
                $scope.id = id;
                try {
                    const reponse = await $http.get(`/api/san-pham/image/${id}`);
                    $scope.getAllImages = reponse.data;
                    console.log($scope.getAllImages);
                    $scope.$applyAsync();
                } catch (error) {
                    console.error(error);
                }
            }

            $scope.removeImage = async function(id) {
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: 'Hành động này sẽ xóa ảnh này khỏi sản phẩm!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await $http.delete(
                                `/api/san-pham/image/delete/${id}`);
                            $scope.getAllImages = response.data;

                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Ảnh đã được xóa.',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            $scope.$applyAsync();
                            $scope.editImageProduct($scope.id); // Cập nhật danh sách ảnh
                        } catch (error) {
                            console.log(error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Không thể xóa ảnh. Vui lòng thử lại.',
                                confirmButtonText: 'Đóng'
                            });
                        }
                    }
                });
            };

            $scope.deleteProduct = function(id) {
                Swal.fire({
                    title: 'Bạn có chắc chắn?',
                    text: 'Hành động này sẽ xóa sản phẩm này khỏi danh sách sản phẩm!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Xóa',
                    cancelButtonText: 'Hủy'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            // Gửi yêu cầu xóa sản phẩm từ API
                            const response = await $http.delete(`/api/san-pham/${id}`);

                            // Cập nhật lại danh sách sản phẩm sau khi xóa
                            $scope.getAllProducts = response.data.messages;

                            // Hiển thị thông báo thành công
                            Swal.fire({
                                icon: 'success',
                                title: 'Thành công!',
                                text: 'Sản phẩm đã được xóa.',
                                showConfirmButton: false,
                                timer: 1500
                            });

                            // Cập nhật lại dữ liệu (nếu cần)
                            $scope.$applyAsync();
                            getAllProduct(); // Cập nhật danh sách sản phẩm
                        } catch (error) {
                            console.error(error);

                            // Hiển thị thông báo lỗi nếu không thể xóa
                            Swal.fire({
                                icon: 'error',
                                title: 'Lỗi!',
                                text: 'Không thể xóa sản phẩm. Vui lòng thử lại.',
                                confirmButtonText: 'Đóng'
                            });
                        }
                    }
                });
            };

            // Initial call to load the first page of products
            getAllProduct();
            getAlldanhmuc();
        });
    </script>
@endsection
