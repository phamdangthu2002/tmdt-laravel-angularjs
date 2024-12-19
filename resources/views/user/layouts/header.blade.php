<style>
    /* Tổng thể Overlay */
    /* Overlay */
    .overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.7);
        z-index: 998;
        transition: opacity 0.3s ease-in-out;
    }

    /* Hiển thị overlay khi mở giỏ hàng */
    .overlay.active {
        display: block;
        opacity: 1;
    }

    /* Giỏ hàng */
    .cart-sidebar {
        position: fixed;
        top: 0;
        right: -420px;
        width: 420px;
        height: 100%;
        background: linear-gradient(135deg, #f7f7f7, #e1e1e1);
        box-shadow: -5px 0 15px rgba(0, 0, 0, 0.1);
        z-index: 999;
        transition: right 0.3s ease-in-out;
        padding: 20px;
        overflow-y: auto;
        border-radius: 10px 0 0 10px;
    }

    /* Khi Giỏ hàng được mở */
    .cart-sidebar.active {
        right: 0;
    }

    /* Header giỏ hàng */
    .cart-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 30px;
    }

    .cart-header span {
        font-size: 2rem;
        font-weight: bold;
        color: #333;
    }

    .cart-header button {
        background: none;
        border: none;
        font-size: 2rem;
        color: #333;
        cursor: pointer;
        transition: color 0.3s;
    }

    .cart-header button:hover {
        color: #e74c3c;
    }

    /* Nội dung giỏ hàng */
    .cart-content {
        margin-bottom: 30px;
    }

    /* Các mục trong giỏ hàng */
    .cart-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px;
        background-color: #fff;
        margin-bottom: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        transition: background-color 0.3s ease;
    }

    .cart-item:hover {
        background-color: #f0f0f0;
    }

    .cart-item img {
        width: 80px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        margin-right: 15px;
    }

    .cart-item-details {
        flex-grow: 1;
    }

    .cart-item-details h5 {
        font-size: 1.1rem;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .cart-item-details p {
        font-size: 1rem;
        color: #555;
    }

    /* Nút xóa sản phẩm */
    .btn-delete {
        background: none;
        border: none;
        font-size: 1.5rem;
        color: #e74c3c;
        cursor: pointer;
        transition: color 0.3s;
    }

    .btn-delete:hover {
        color: #c0392b;
    }

    /* Tổng tiền */
    .cart-total {
        font-size: 1.5rem;
        font-weight: bold;
        text-align: center;
        color: #333;
        padding: 20px;
        background-color: #f9f9f9;
        margin-top: 20px;
        border-radius: 10px;
    }

    /* Nút thanh toán */
    .btn-checkout {
        width: 100%;
        padding: 15px;
        background-color: #3498db;
        color: #fff;
        border: none;
        font-size: 1.1rem;
        cursor: pointer;
        transition: background-color 0.3s ease;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .btn-checkout:hover {
        background-color: #2980b9;
    }

    .btn-checkout:active {
        background-color: #2471a3;
    }

    /* Style cho nút giỏ hàng */
    .cart-button {
        position: relative;
        display: inline-flex;
        align-items: center;
        font-size: 1.5rem;
        padding: 10px;
        background-color: transparent;
        border: 1px solid #ddd;
        border-radius: 50px;
        color: #333;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .cart-button:hover {
        background-color: #f1f1f1;
    }

    /* Số lượng trong giỏ hàng */
    .cart-button span {
        position: absolute;
        top: 7px;
        right: 0;
        background-color: #e74c3c;
        color: white;
        font-size: 1rem;
        font-weight: bold;
        padding: 5px 10px;
        border-radius: 50%;
        min-width: 20px;
        height: 20px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Khi số lượng > 9, thay đổi kích thước */
    .cart-button span {
        font-size: 0.9rem;
        padding: 10px;
    }
</style>

<header class="header" ng-controller="ctrlDanhmuc">
    <nav class="navbar navbar-expand-lg navbar-light container">
        {{-- phần 1 --}}
        <a class="navbar-brand" href="/">iPhone Store</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        {{-- phần 2 --}}
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0 justify-content-center">
                <li class="nav-item position-relative" style="padding-left: 150px">
                    <a class="nav-link" href="#">Danh mục sản phẩm</a>
                    <div class="dropdown-menu-custom">
                        <!-- Danh mục cấp 1 -->
                        <div ng-repeat="danhmuc in danhmuc_hierarchy" class="position-relative">
                            <a href="#">@{{ danhmuc.name }}</a>
                            <!-- Danh mục cấp 2 -->
                            <div class="submenu" ng-if="danhmuc.children.length">
                                <a ng-repeat="subdanhmuc in danhmuc.children" href="#">@{{ subdanhmuc.name }}</a>
                            </div>
                        </div>
                    </div>
                </li>
            </ul>
            <form class="d-flex me-5">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Tìm kiếm" id="searchInput"
                        aria-label="Search">
                    <a class="btn btn-search" href="#" id="searchButton">
                        <i class='bx bx-search'></i>
                    </a>
                </div>
            </form>

            {{-- phần 3 --}}
            @if (Auth::check())
                <!-- User Dropdown Button -->
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item position-relative me-3">
                        <a href="#" class="nav-link">
                            <i class="bx bx-user" style="font-size: 2rem; cursor: pointer;"></i>
                        </a>
                        <div class="dropdown-menu-user-custom">
                            <div class="position-relative"
                                style="background-color: blue;border-radius: 5px;color: white;">
                                <span>Xin chào </span>
                                <div>{!! getLoggedInUser()->name !!}</div>
                            </div>
                            <!-- Hồ sơ -->
                            <div class="position-relative">
                                <a href="#"><i class="bx bx-user"></i> Hồ sơ</a>
                            </div>
                            <!-- Cài đặt -->
                            <div class="position-relative">
                                <a href="/user/don-hang"><i class="bx bx-cog"></i> Cài đặt</a>
                            </div>
                            <!-- Đăng xuất -->
                            <div class="position-relative">
                                <a href="#" class="text-danger" ng-click="logout()">
                                    <i class="bx bx-power-off"></i> Đăng xuất
                                </a>
                            </div>
                        </div>
                    </li>
                    <!-- Hiển thị giỏ hàng và nút logout -->
                    <li>
                        <a class="btn btn-outline cart-button" style="font-size: 30px">
                            <i class='bx bx-cart'></i>
                            <span>@{{ totalQuantity }}</span>
                        </a>
                    </li>
                </ul>
            @else
                <!-- Hiển thị đăng nhập và đăng ký -->
                <a href="/auth/dang-nhap" class="btn btn-outline-primary me-3">Đăng nhập</a>
                <a href="/auth/dang-ky" class="btn btn-warning">Đăng ký</a>
            @endif
        </div>
    </nav>
</header>


<!-- Overlay -->
<div class="overlay" id="cartOverlay"></div>

<!-- Sidebar Giỏ Hàng -->
<div class="cart-sidebar" id="cartSidebar" ng-controller="ctrlCart">
    <div class="cart-header">
        <span>Giỏ Hàng</span>
        <button>✕</button>
    </div>
    <div class="cart-content">
        <div ng-if="carts.length == 0" class="text-center">Giỏ hàng của bạn trống!</div>
        <div class="cart-item" ng-repeat="cart in carts">
            <img ng-src="@{{ cart.product_image }}" alt="@{{ cart.product_name }}" class="cart-item-image">
            <div class="cart-item-details">
                <h5>@{{ cart.product_name }}</h5>
                <p>@{{ cart.price }}</p>
                <p>Số lượng: @{{ cart.quantity }}</p>
            </div>
            <a class="btn btn-outline-danger bx bx-trash"></a>
        </div>
    </div>
    <div class="cart-total">
        Tổng: @{{ total | number }} VND
    </div>
    <div class="cart-actions">
        <a href="/user/gio-hang"><button class="btn-checkout">Xem chi tiết</button></a>
    </div>
</div>
<script>
    document.getElementById('searchButton').addEventListener('click', function(e) {
        e.preventDefault(); // Ngăn chặn hành động mặc định của thẻ a
        var searchValue = document.getElementById('searchInput').value.trim(); // Lấy giá trị input

        if (searchValue) {
            // Cập nhật href của thẻ a với từ khóa tìm kiếm
            var searchUrl = `/user/tim-kiem/${encodeURIComponent(searchValue)}`;
            window.location.href = searchUrl; // Thực hiện chuyển hướng
        } else {
            alert('Vui lòng nhập từ khóa tìm kiếm!');
        }
    });
</script>
<script>
    // Lấy các phần tử DOM
    const cartSidebar = document.getElementById('cartSidebar');
    const cartOverlay = document.getElementById('cartOverlay');
    const cartButton = document.querySelector('.cart-button');
    const closeCartButton = document.querySelector('.cart-header button');
    const btnDeleteItems = document.querySelectorAll('.btn-outline-danger');

    // Mở giỏ hàng
    cartButton.addEventListener('click', () => {
        cartSidebar.classList.add('active'); // Hiển thị giỏ hàng
        cartOverlay.classList.add('active'); // Hiển thị overlay
    });

    // Đóng giỏ hàng khi click vào overlay
    cartOverlay.addEventListener('click', () => {
        cartSidebar.classList.remove('active'); // Ẩn giỏ hàng
        cartOverlay.classList.remove('active'); // Ẩn overlay
    });

    // Đóng giỏ hàng
    closeCartButton.addEventListener('click', () => {
        cartSidebar.classList.remove('active'); // Ẩn giỏ hàng
        cartOverlay.classList.remove('active'); // Ẩn overlay
    });

    // Xóa sản phẩm khỏi giỏ hàng
    btnDeleteItems.forEach((btnDelete) => {
        btnDelete.addEventListener('click', (e) => {
            const cartItem = e.target.closest('.cart-item'); // Lấy phần tử sản phẩm
            cartItem.remove(); // Xóa sản phẩm khỏi giỏ hàng
            updateCartTotal(); // Cập nhật lại tổng tiền sau khi xóa sản phẩm
        });
    });

    // Cập nhật tổng tiền giỏ hàng
    function updateCartTotal() {
        const cartItems = document.querySelectorAll('.cart-item');
        let total = 0;

        cartItems.forEach((item) => {
            const priceText = item.querySelector('.cart-item-details p').textContent;
            const price = parseInt(priceText.replace(' VND', '').replace(',', ''));
            total += price;
        });

        // Cập nhật tổng tiền
        document.querySelector('.cart-total').textContent = 'Tổng: ' + total.toLocaleString() + ' VND';
    }
</script>
