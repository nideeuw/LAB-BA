<?php
// Get active banners from database
$bannerItems = BannerModel::getActiveBanner($conn);
?>

<div id="carouselExampleSlidesOnly" class="carousel slide">
    <div class="carousel-inner">
        <?php if (!empty($bannerItems)): ?>
            <?php foreach ($bannerItems as $index => $banner): ?>
                <div class="carousel-item <?php echo $index === 0 ? 'active' : ''; ?>">
                    <img class="d-block w-100"
                        src="<?php echo $base_url; ?>/assets/<?php echo htmlspecialchars($banner['image']); ?>"
                        alt="<?php echo htmlspecialchars($banner['title'] ?? 'Banner ' . ($index + 1)); ?>"
                        onerror="this.src='<?php echo $base_url; ?>/assets/img/default-banner.jpg'">
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <!-- Default banners jika database kosong -->
            <div class="carousel-item active">
                <img class="d-block w-100" src="<?php echo $base_url; ?>/assets/img/images_1.jpg" alt="First slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?php echo $base_url; ?>/assets/img/images_2.jpg" alt="Second slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100" src="<?php echo $base_url; ?>/assets/img/images_3.jpg" alt="Third slide">
            </div>
        <?php endif; ?>
    </div>
</div>

<script>
    let index = 0;
    const slides = document.querySelectorAll('.carousel-item');

    function showNextSlide() {
        slides[index].classList.remove('active');
        index = (index + 1) % slides.length;
        slides[index].classList.add('active');
    }

    // Auto slide every 3 seconds
    setInterval(showNextSlide, 3000);
</script>