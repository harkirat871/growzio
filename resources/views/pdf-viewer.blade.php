<!DOCTYPE html>
<html>
<head>
  <title>Viewer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:black; overflow:hidden;">

<button onclick="goFull()" 
        style="position:fixed; top:10px; right:10px; z-index:999;"
        class="btn btn-light">
  ⛶ Fullscreen
</button>

<div id="carouselPDF" class="carousel slide" data-bs-ride="false">
  <div class="carousel-inner">

    @for ($i = 1; $i <= 21; $i++)
      @php
        $num = str_pad($i, 4, '0', STR_PAD_LEFT);
      @endphp

      <div class="carousel-item {{ $i == 1 ? 'active' : '' }}">
        <img src="{{ asset('slides/pdf_pages-to-jpg-' . $num . '.jpg') }}"
             class="d-block w-100"
             style="height: 100vh; object-fit: contain;">
      </div>
    @endfor

  </div>

  <button class="carousel-control-prev" data-bs-target="#carouselPDF" data-bs-slide="prev"></button>
  <button class="carousel-control-next" data-bs-target="#carouselPDF" data-bs-slide="next"></button>
</div>

<!-- Page counter -->
<div style="position:fixed; bottom:10px; right:15px; color:white;">
  <span id="pageNum">1</span>/21
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
document.getElementById('carouselPDF').addEventListener('slid.bs.carousel', function () {
  const active = document.querySelector('.carousel-item.active img').src;
  const match = active.match(/(\\d{4})\\.jpg/);

  if (match) {
    document.getElementById('pageNum').innerText = parseInt(match[1]);
  }
});

function goFull() {
  let el = document.getElementById("carouselPDF");
  if (el.requestFullscreen) el.requestFullscreen();
}

document.addEventListener('keydown', e => {
  if (e.key === 'ArrowRight') {
    document.querySelector('.carousel-control-next').click();
  }
  if (e.key === 'ArrowLeft') {
    document.querySelector('.carousel-control-prev').click();
  }
});
</script>

</body>
</html>