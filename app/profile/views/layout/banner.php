<link rel="stylesheet" href="/PBL/assets/css/home.css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

<div id="carouselExampleSlidesOnly" class="carousel slide">
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img class="d-block w-100" src="/PBL/assets/img/images_1.jpg" alt="First slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="/PBL/assets/img/images_2.jpg" alt="Second slide">
        </div>
        <div class="carousel-item">
            <img class="d-block w-100" src="/PBL/assets/img/images_3.jpg" alt="Third slide">
        </div>
    </div>
</div>

<script>
let index = 0;
const slides = document.querySelectorAll('.carousel-item');
setInterval(() => {
    slides[index].classList.remove('active');
    index = (index + 1) % slides.length;
    slides[index].classList.add('active');
}, 2000);
</script>
