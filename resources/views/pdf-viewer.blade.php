<!DOCTYPE html>
<html>
<head>
  <title>Viewer</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background:black; margin:0;">

<!-- Fullscreen button -->
<button onclick="goFull()" 
        style="position:fixed; top:10px; right:10px; z-index:999;"
        class="btn btn-light">
  ⛶ Fullscreen
</button>

<!-- Scroll container -->
<div id="viewer" style="height:100vh; overflow-y:scroll; scroll-snap-type:y mandatory;">

  @for ($i = 1; $i <= 21; $i++)
    @php
      $num = str_pad($i, 4, '0', STR_PAD_LEFT);
    @endphp

    <div style="height:100vh; display:flex; align-items:center; justify-content:center; scroll-snap-align:start;">
      <img src="{{ asset('slides/pdf_pages-to-jpg-' . $num . '.webp') }}"
           style="max-height:100vh; max-width:100%; object-fit:contain;">
    </div>
  @endfor

</div>

<script>
function goFull() {
  let el = document.getElementById("viewer");
  if (el.requestFullscreen) el.requestFullscreen();
}
</script>

</body>
</html>