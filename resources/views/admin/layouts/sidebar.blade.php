<div class="sidebar" ng-controller="ctrlSidebar">
    <div class="logo">
        <h3>Admin</h3>
    </div>
    <ul>
        <li class="{{ Route::currentRouteName() == 'admin' ? 'active' : '' }}">
            <a href="/admin/"><i class="bx bx-home"></i>Dashboard</a>
        </li>
        <li>
            <p><i class="bx bx-box"></i>Quản lý sản phẩm</p>
            <ul class="submenu">
                <li class="{{ Route::currentRouteName() == 'admin.sanpham' ? 'active' : '' }}">
                    <a href="{{ route('admin.sanpham') }}">Thêm sản phẩm</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'admin.sanpham.show' ? 'active' : '' }}">
                    <a href="{{ route('admin.sanpham.show') }}">Danh sách sản phẩm</a>
                </li>
            </ul>
        </li>
        <li>
            <p><i class="bx bx-cart"></i>Quản lý đơn hàng</p>
            <ul class="submenu">
                <li class="{{ Route::currentRouteName() == 'admin.donhang' ? 'active' : '' }}">
                    <a href="{{ route('admin.donhang') }}">Danh sách đơn hàng</a>
                </li>
            </ul>
        </li>
        <li>
            <p><i class="bx bx-user"></i>Quản lý khách hàng</p>
            <ul class="submenu">
                <li class="{{ Route::currentRouteName() == 'admin.user' ? 'active' : '' }}">
                    <a href="{{ route('admin.user') }}">Thêm tài khoản người dùng</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'admin.user.show' ? 'active' : '' }}">
                    <a href="{{ route('admin.user.show') }}">Danh sách tài khoản</a>
                </li>
            </ul>
        </li>
        <li>
            <p><i class="bx bx-category"></i>Quản lý danh mục</p>
            <ul class="submenu">
                <li class="{{ Route::currentRouteName() == 'admin.danhmuc' ? 'active' : '' }}">
                    <a href="{{ route('admin.danhmuc') }}">Thêm danh mục</a>
                </li>
                <li class="{{ Route::currentRouteName() == 'admin.danhmuc.show' ? 'active' : '' }}">
                    <a href="{{ route('admin.danhmuc.show') }}">Danh sách danh mục</a>
                </li>
            </ul>
        </li>
        <li class="{{ Route::currentRouteName() == 'admin.' ? 'active' : '' }}">
            <a ng-click="logout()" class="text-danger"><i class="bx bx-log-out"></i>Đăng xuất</a>
        </li>
    </ul>
</div>
