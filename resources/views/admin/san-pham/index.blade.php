@extends('admin.layouts.layouts')

@section('content')
    <style>
        #anhsp_preview {
            display: flex;
            flex-wrap: wrap;
            /* Cho phép các ảnh xuống dòng nếu không đủ chỗ */
            gap: 10px;
            height: 300px;
            /* Khoảng cách giữa các ảnh */
            overflow-x: hidden;
        }
    </style>
    <div class="container mt-5" ng-controller="ctrlSanpham">
        <form enctype="multipart/form-data">
            <div class="container">
                <div class="card shadow">
                    <div class="card-header">
                        <label for="form-lable">{{ $title }}</label>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Tên sản phẩm -->
                                <div class="mb-3">
                                    <label for="name" class="form-label">Tên sản phẩm</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                        ng-model="sanpham.name">
                                    <div class="text-danger" ng-if="errors.name">
                                        @{{ errors.name[0] }}
                                    </div>
                                </div>

                                <!-- Mô tả ngắn -->
                                <div class="mb-3">
                                    <label for="description" class="form-label">Mô tả ngắn</label>
                                    <textarea class="form-control" id="description" name="description" rows="3" ng-model="sanpham.description"></textarea>
                                    <div class="text-danger" ng-if="errors.description">
                                        @{{ errors.description[0] }}
                                    </div>
                                </div>

                                <!-- Mô tả chi tiết -->
                                <div class="mb-3">
                                    <label for="description_detail" class="form-label">Mô tả chi tiết</label>
                                    <textarea class="form-control" id="description_detail" name="description_detail" rows="5"
                                        ng-model="sanpham.description_detail"></textarea>
                                    <div class="text-danger" ng-if="errors.description_detail">
                                        @{{ errors.description_detail[0] }}
                                    </div>
                                </div>

                                <!-- Giá sản phẩm -->
                                <div class="mb-3">
                                    <label for="price" class="form-label">Giá</label>
                                    <input type="number" class="form-control" id="price" name="price"
                                        ng-model="sanpham.price">
                                    <div class="text-danger" ng-if="errors.price">
                                        @{{ errors.price[0] }}
                                    </div>
                                </div>

                                <!-- Giảm giá -->
                                <div class="mb-3">
                                    <label for="discount" class="form-label">Giá giảm (%)</label>
                                    <input type="number" class="form-control" id="discount" name="discount"
                                        ng-model="sanpham.discount">
                                    <div class="text-danger" ng-if="errors.discount">
                                        @{{ errors.discount[0] }}
                                    </div>
                                </div>

                                <!-- Số lượng -->
                                <div class="mb-3">
                                    <label for="quantity" class="form-label">Số lượng</label>
                                    <input type="number" class="form-control" id="quantity" name="quantity"
                                        ng-model="sanpham.quantity">
                                    <div class="text-danger" ng-if="errors.quantity">
                                        @{{ errors.quantity[0] }}
                                    </div>
                                </div>

                                <!-- Category -->
                                <div class="mb-3">
                                    <label for="category_id" class="form-label">Danh mục</label>
                                    <select class="form-select" id="category_id" name="category_id"
                                        ng-model="sanpham.category_id">
                                        <option ng-repeat="danhmuc in danhmucs" value="@{{ danhmuc.id }}">
                                            @{{ danhmuc.name }}</option>
                                    </select>
                                    <div class="text-danger" ng-if="errors.category_id">
                                        @{{ errors.category_id[0] }}
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <!-- Trạng thái -->
                                <div class="mb-3">
                                    <label for="status" class="form-label">Trạng thái</label>
                                    <select class="form-select" id="status" name="status" ng-model="sanpham.status">
                                        <option value="available">Có sẵn</option>
                                        <option value="out_of_stock">Tạm hết hàng</option>
                                    </select>
                                    <div class="text-danger" ng-if="errors.status">
                                        @{{ errors.status[0] }}
                                    </div>
                                </div>

                                <!-- RAM -->
                                <div class="mb-3">
                                    <label for="ram" class="form-label">RAM</label>
                                    <select class="form-select" name="ram" id="ram" ng-model="sanpham.ram">
                                        <option value="4GB">4GB</option>
                                        <option value="8GB">8GB</option>
                                        <option value="16GB">16GB</option>
                                    </select>
                                    <div class="text-danger" ng-if="errors.ram">
                                        @{{ errors.ram[0] }}
                                    </div>
                                </div>

                                <!-- ROM -->
                                <div class="mb-3">
                                    <label for="rom" class="form-label">ROM</label>
                                    <select class="form-select" name="rom" id="rom" ng-model="sanpham.rom">
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

                                <!-- Màu sắc -->
                                <div class="mb-3">
                                    <label for="color" class="form-label">Màu sắc</label>
                                    <select class="form-select" name="color" id="color" ng-model="sanpham.color">
                                        <option value="Đen">Đen</option>
                                        <option value="Trắng">Trắng</option>
                                        <option value="Hồng">Hồng</option>
                                        <option value="Titan Sa mạc">Titan Sa mạc</option>
                                        <option value="Vàng">Vàng</option>
                                        <option value="Xanh ngọc">Xanh ngọc</option>
                                        <option value="Tím">Tím</option>
                                        <option value="Xám">Xám</option>
                                    </select>
                                    <div class="text-danger" ng-if="errors.color">
                                        @{{ errors.color[0] }}
                                    </div>
                                </div>

                                <!-- Ảnh sản phẩm -->
                                <div class="mb-3">
                                    <div class="col">
                                        <label for="anhsp" class="form-label">Chọn file (nhiều file có thể
                                            chọn)</label>
                                        <div class="input-group">
                                            <input type="file" class="form-control" id="anhsp" name="anhsp[]"
                                                ng-model="sanpham.anhsp" multiple />
                                        </div>
                                        <div id="anhsp_preview" class="image-preview"></div>
                                    </div>
                                    <div class="text-danger" ng-if="errors.anhsp">
                                        @{{ errors.anhsp[0] }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <!-- Nút lưu -->
                        <div class="d-flex justify-content-end">
                            <button type="reset" class="btn btn-secondary me-2">Quay lại</button>
                            <a ng-click="addSanpham()" class="btn btn-primary">Thêm sản phẩm</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <script src="{{ asset('assets/js/anh.js') }}"></script>
@endsection

@section('angular')
    <script>
        app.controller('ctrlSanpham', function($scope, $http) {
            // Khởi tạo đối tượng sanpham với anhsp là mảng rỗng
            $scope.sanpham = {
                status: 'available',
                ram: '4GB',
                rom: '64GB',
                color: 'black',
                discount: 0.00,
                anhsp: [],
            };
            $scope.errors = [];
            const getDanhmuc = async function() {
                try {
                    const response = await $http.get('/api/danh-muc/create');
                    $scope.danhmucs = response.data.danhmucs_all;
                    console.log($scope.danhmucs);
                    $scope.$applyAsync();
                } catch (error) {
                    console.error(error);
                }
            }
            // Lấy phần tử input file theo ID
            var fileInput = document.getElementById('anhsp');

            // Đảm bảo rằng người dùng đã chọn ít nhất một file
            fileInput.addEventListener('change', function(event) {
                var files = event.target.files; // Lấy danh sách các file được chọn

                if (files.length > 0) {
                    // Duyệt qua các file đã chọn và thêm vào mảng anhsp
                    $scope.$apply(function() {
                        for (var i = 0; i < files.length; i++) {
                            $scope.sanpham.anhsp.push(files[i]);
                        }
                    });
                    // console.log($scope.sanpham.anhsp); // In mảng anhsp ra console để kiểm tra
                }
            });
            // Hàm thêm sản phẩm
            $scope.addSanpham = async function() {
                try {
                    $scope.errors = [];
                    // Tạo FormData
                    let formData = new FormData();

                    // Thêm các file vào FormData
                    $scope.sanpham.anhsp.forEach((file, index) => {
                        formData.append(`anhsp[]`, file);
                    });

                    // Thêm các thông tin khác vào FormData
                    for (let key in $scope.sanpham) {
                        if (key !== 'anhsp') { // Bỏ qua anhsp vì đã thêm riêng ở trên
                            formData.append(key, $scope.sanpham[key]);
                        }
                    }

                    // Gửi request POST
                    const response = await $http.post('/api/san-pham', formData, {
                        headers: {
                            'Content-Type': undefined
                        }
                    });

                    // Thông báo thành công
                    Swal.fire({
                        icon: 'success',
                        title: 'Tạo sản phẩm thành công!',
                        text: 'Sản phẩm đã được thêm vào danh sách.',
                    });
                    // Reset form
                    $scope.sanpham = {};
                    document.getElementById('anhsp_preview').innerHTML = ''; // Xóa ảnh hiển thị
                    document.getElementById('anhsp').value = ''; // Xóa ảnh hiển thị
                    $scope.sanpham.anhsp = []; // Xóa danh sách ảnh đã chọn
                    $scope.$applyAsync();

                    console.log(response.data);
                } catch (error) {
                    if (error.status === 422) {
                        $scope.errors = error.data.error;
                        $scope.$applyAsync();

                        // Hiển thị lỗi bằng SweetAlert2
                        Swal.fire({
                            icon: 'error',
                            title: 'Có lỗi xảy ra!',
                            text: 'Vui lòng kiểm tra lại các thông tin nhập vào.',
                        });
                    }
                    console.error(error);
                }
            };
            getDanhmuc();
        });
    </script>
@endsection
