<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Slides Only Carousel</title>
    
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    /* ==== Slides Only Carousel Style ==== */
    body {
      margin: 0;
      background: #f4f4f4;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .carousel {
      position: relative;
      width: 80%;
      max-width: 800px;
      height: 400px;
      overflow: hidden;
      border-radius: 16px;
      box-shadow: 0 4px 15px rgba(0,0,0,0.2);
    }

    .carousel-inner {
      width: 100%;
      height: 100%;
      position: relative;
    }

    .carousel-item {
      position: absolute;
      width: 100%;
      height: 100%;
      opacity: 0;
      transition: opacity 1s ease-in-out;
    }

    .carousel-item.active {
      opacity: 1;
      position: relative;
    }

    .carousel-item img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      filter: brightness(95%);
      transition: filter 0.5s ease;
    }

    .carousel-item img:hover {
      filter: brightness(100%);
    }
  </style>
</head>
<body>

  <div id="carouselExampleSlidesOnly" class="carousel slide" data-ride="carousel">
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
    // Script sederhana untuk mengganti slide otomatis
    let index = 0;
    const slides = document.querySelectorAll('.carousel-item');
    setInterval(() => {
      slides[index].classList.remove('active');
      index = (index + 1) % slides.length;
      slides[index].classList.add('active');
    }, 2000); // ganti slide setiap 2 detik
  </script>

</body>
</html>