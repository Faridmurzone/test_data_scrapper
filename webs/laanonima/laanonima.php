<?php 
include('../../config.php');
include(ASSETS . 'header.php'); 

echo "<a href='../../index.php' class='btn btn-info mb-3' role='button'>Volver al index</a>";

// Chequear si se le pasan parámetros para leer los links
if(isset($_GET['fromArray'])) {
$fromArray = $_GET['fromArray'];
} else {
$fromArray = $defaultFromArray;
}
if(isset($_GET['toArray'])) {
$toArray = $_GET['toArray'];
} else {
$toArray = $defaultToArray;	
}

$controlador = array_slice($links['laanonima'], $fromArray, $toArray);
foreach($controlador as $cat => $link) {
	$screenshotID++;
	// $link = "https://www.laanonimaonline.com/pequenos-electrodomesticos/n1_3/";
    $html = file_get_html($link);    
	if($html != FALSE) {
	$producto = $html->find('div[class=producto]');
    foreach ($producto as $prod) {
		$cantidad++;
		$titulo = $prod->find('div[class=titulo02]',0)->plaintext;
		$link  = "http://www.laanonimaonline.com/" . $prod->find('a',0)->href . "";
		$img = $prod->find('img[class=imagenIz]',0)->src;	
		$precio_lista = $prod->find('span[class=precio anterior codigo]',0)->plaintext;
		$precio_oferta = $prod->find('span[class=precio semibold aux1]',0)->plaintext;

		$category = preg_replace('/[0-9]+/', '', $cat);
		$retailer = "LA ANONIMA";
		$date = date("Y-m-d H:i:s");
		$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
		$html_prod = file_get_html($link) ;
		
		$marca = $html_prod->find('div[class=der atributo medio valor]', 0)->plaintext;
		$modelo = $html_prod->find('div[class=der atributo medio valor]', 1)->plaintext;
		$combo = FALSE;
		// Busca Combos
		// if (strpos($titulo, '+') == FALSE) {
	 //    $combo = FALSE;
		// } else {
		// $combo = TRUE;
		// $comboProds = preg_split('/[+]/', $titulo);
		// } 

		include(ASSETS.'print.php');
		// PARA INSERTAR EN DB
		include(DB.'insert.php');
	}
	// Imprimir mensajes
	// echo "<div class='p-3 mb-2 bg-success text-white' id='div-alert'>Categoría $cat cargada... ok</div>";
	// } else {
	// echo "<div class='p-3 mb-2 bg-warning text-white' id='div-alert'>Categoría $cat no contiene productos nuevos...</div>";
	}
}

include(ASSETS . 'footer.php');
?>
