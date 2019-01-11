  <?php
// Esto no está ni empezado casi. La idea es hacer una barra que vaya marcando el progreso.
// Lo dejo para no olvidarme.
  $total = count($producto);
  $current = 0;
  while ($current < $total) {
    $progress = round($current * 100 / $total, 2);

    // ... accion del contador
    sleep(1);
    $current++;
  }