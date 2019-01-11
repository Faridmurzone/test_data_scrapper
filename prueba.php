<?php
require_once('config.php');
include(ASSETS . 'header2.php'); 

/*
$key = array_search(100, array_keys($a), true);
if ($key !== false) {
    $slice = array_slice($a, $key, null, true);
    var_export($slice);
}*/



$controlador = array_slice($links['musimundo'], 0, 9);
var_dump($controlador);



include(ASSETS . 'footer.php');
?>