@extends('admin.layouts.layouts')

@section('content')
    <div class="content-wrapper">
        <div class="container-fluid">
            <div class="row">
                <h1 class="mb-4">Tổng quan</h1>

                <div class="row">
                    <!-- Doanh thu -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Doanh thu</h5>
                                <canvas id="revenueChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Đơn hàng -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Đơn hàng</h5>
                                <canvas id="ordersChart"></canvas>
                            </div>
                        </div>
                    </div>

                    <!-- Sản phẩm -->
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title">Sản phẩm</h5>
                                <canvas id="productsChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    
    <!-- Biểu đồ với Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Biểu đồ doanh thu
        var revenueCtx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],  // Thay ps -> labels
                datasets: [{
                    label: 'Doanh thu (VND)',  // Thay p -> label
                    data: [100000, 200000, 150000, 300000, 250000, 400000],
                    borderColor: 'rgba(75, 192, 192, 1)',
                    fill: false,
                    tension: 0.1
                }]
            }
        });

        // Biểu đồ đơn hàng
        var ordersCtx = document.getElementById('ordersChart').getContext('2d');
        var ordersChart = new Chart(ordersCtx, {
            type: 'bar',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],  // Thay ps -> labels
                datasets: [{
                    label: 'Đơn hàng',  // Thay p -> label
                    data: [30, 45, 25, 60, 50, 70],
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });

        // Biểu đồ sản phẩm
        var productsCtx = document.getElementById('productsChart').getContext('2d');
        var productsChart = new Chart(productsCtx, {
            type: 'pie',
            data: {
                labels: ['iPhone 12', 'iPhone 13', 'iPhone 14', 'iPhone 15'],  // Thay ps -> labels
                datasets: [{
                    data: [40, 30, 20, 10],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0'],
                }]
            }
        });
    </script>
@endsection
