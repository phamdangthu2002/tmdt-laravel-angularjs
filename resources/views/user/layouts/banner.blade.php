<script src="{{ asset('assets/vendor/bootstrap-5.3.3-dist/js/bootstrap.bundle.min.js') }}"></script>
<style>
    #bannerCarousel{
        width: 100%;
        height: 700px;
        background-size: cover;
    }
</style>
<div id="bannerCarousel" class="carousel slide mt-5" data-bs-ride="carousel">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="/assets/images/banner/H2_614x212_e97abfb675.png" class="d-block w-100" alt="Banner 1">
            <div class="carousel-caption d-none d-md-block">
                <h5>Khuyến Mãi 1</h5>
                <p>Giảm giá lên tới 50% cho các sản phẩm mới nhất.</p>
                <a href="#" class="btn btn-primary">Xem Chi Tiết</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/assets/images/banner/H2_0e742c164c.png" class="d-block w-100" alt="Banner 2">
            <div class="carousel-caption d-none d-md-block">
                <h5>Khuyến Mãi 2</h5>
                <p>Mua 1 tặng 1 cho tất cả các mặt hàng mùa hè.</p>
                <a href="#" class="btn btn-primary">Xem Chi Tiết</a>
            </div>
        </div>
        <div class="carousel-item">
            <img src="/assets/images/banner/H2_614x212_db0cbe1006.png" class="d-block w-100" alt="Banner 3">
            <div class="carousel-caption d-none d-md-block">
                <h5>Khuyến Mãi 3</h5>
                <p>Miễn phí vận chuyển cho tất cả đơn hàng trên 500k.</p>
                <a href="#" class="btn btn-primary">Xem Chi Tiết</a>
            </div>
        </div>
    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>
<script>
    // Lấy đối tượng carousel
    var myCarousel = document.getElementById('bannerCarousel');
    var carousel = new bootstrap.Carousel(myCarousel, {
        interval: 3000, // Điều chỉnh thời gian thay đổi slide (3 giây)
        ride: 'carousel' // Cho phép carousel tự động quay
    });
</script>
