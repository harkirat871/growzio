<!DOCTYPE html>

<html>
<head>
  <title>Viewer</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Bootstrap (optional, kept since you had it) -->

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:black; margin:0; overflow:hidden;">

<!-- Fullscreen button -->

<button onclick="goFull()" 
     style="position:fixed; top:10px; right:10px; z-index:999;"
     class="btn btn-light">
⛶ Fullscreen </button>

<!-- Scroll container -->

<div id="viewer" style="height:100vh; overflow-y:auto; scroll-snap-type:y mandatory;">

@for ($i = 1; $i <= 21; $i++)
@php
$num = str_pad($i, 4, '0', STR_PAD_LEFT);
@endphp

```
<div class="page" style="height:100vh; display:flex; align-items:center; justify-content:center; scroll-snap-align:start;">
  <img 
    data-src="{{ asset('slides/pdf_pages-to-jpg-' . $num . '.webp') }}"
    class="lazy-img"
    style="max-height:100vh; max-width:100%; object-fit:contain;">
</div>
```

@endfor

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
// ===== LAZY LOAD + UNLOAD =====
const images = document.querySelectorAll('.lazy-img');

const observer = new IntersectionObserver((entries) => {
  entries.forEach(entry => {
    const img = entry.target;

    if (entry.isIntersecting) {
      if (!img.src) {
        img.src = img.dataset.src;
      }
    } else {
      // unload images far away → reduces lag
      if (Math.abs(entry.boundingClientRect.top) > window.innerHeight * 2) {
        img.src = "";
      }
    }
  });
}, {
  rootMargin: "300px"
});

images.forEach(img => observer.observe(img));


// ===== FULLSCREEN =====
function goFull() {
  let el = document.getElementById("viewer");
  if (el.requestFullscreen) el.requestFullscreen();
}


// ===== OPTIONAL: KEYBOARD SCROLL =====
document.addEventListener('keydown', e => {
  const viewer = document.getElementById('viewer');

  if (e.key === 'ArrowDown') {
    viewer.scrollBy({ top: window.innerHeight, behavior: 'smooth' });
  }

  if (e.key === 'ArrowUp') {
    viewer.scrollBy({ top: -window.innerHeight, behavior: 'smooth' });
  }
});
</script>

</body>
</html>
