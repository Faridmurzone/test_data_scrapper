<?php
// FUNCIONES
// Chequear headers para ver si URL funciona
function get_http_response_code($link) {
    $headers = get_headers($link);
    $validURL = substr($headers[0], 9, 3);
    return $validURL;   
}
// Convertir segundos
function conversorSegundosHoras($tiempo_en_segundos) {
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);
    return $horas . 'h ' . $minutos . "m " . $segundos . "s ";
}

function takeArgs() {
  if(isset($argv[1])) {
    $from = $argv[1];
    $to = $argv[2] - $from;
  } else {
      $count = mysqli_query($conn,"SELECT count(*) as total FROM listado_screens WHERE compumundo_check = '1'");
      $data = mysqli_fetch_assoc($count);
      $total = $data['total'];
      $from = 0;
      $to = $total;
  }
  $result = mysqli_query($conn,"SELECT * FROM listado_screens WHERE compumundo_check = '1' LIMIT $from, $to;");
}