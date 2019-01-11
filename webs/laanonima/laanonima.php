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
	if($link != FALSE) {
    $html = file_get_html($link);    
	$producto = $html->find('div[class=producto]');
    foreach ($producto as $prod) {
		$cantidad++;
		$titulo = $prod->find('div[class=titulo02]',0)->plaintext;
		$link  = "http://www.laanonimaonline.com/" . $prod->find('a',0)->href . "";
		$img = $prod->find('img[class=imagenIz]',0)->src;	
		$precio_lista = $prod->find('span[class=precio anterior codigo]',0);
		$precio_oferta = $prod->find('span[class=precio semibold aux1]',0)->plaintext;
		if($precio_lista == NULL) {
			$precio_lista = $precio_oferta;
			$precio_oferta = NULL;
		}
		$category = preg_replace('/[0-9]+/', '', $cat);
		$retailer = "LA ANONIMA";
		$date = date("Y-m-d H:i:s");
		$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
		
		// Query para ver si el producto existe y es igual
		$precio = $prod->find('span[class=value-item]',0);
		$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND precio_lista LIKE '%$precio%' AND date LIKE '%$date%' AND retailer LIKE '%$retailer%';");
		// Para no cargar DOM de producto individual busca primero si ya existe el producto igual
		while($row = mysqli_fetch_array($query)) {
			if($row['title'] == $titulo) {
				$marca = $row['marca'];
				$modelo = $row['modelo'];
			} 
		}
		$date = date("Y-m-d H:i:s");
		if(!mysqli_fetch_array($query)){
			$html_prod = file_get_html($link) ;
			$marca = $html_prod->find('div[class=der atributo medio valor]', 0)->plaintext;
			$modelo = $html_prod->find('div[class=der atributo medio valor]', 1)->plaintext;
		}
		// Busca Combos
		include(LIB.'findCombo.php');
		// Imprime resultados en pantalla
		include(ASSETS.'print.php');
		// Inserta en la DB
		include(DB.'insert.php');
	}
	// Imprimir mensajes
	echo "<div class='p-3 mb-2 bg-success text-white'>Categoría $cat cargada... ok</div>";
	} else {
	echo "<div class='p-3 mb-2 bg-warning text-white'>Categoría $cat no contiene productos nuevos...</div>";
	}
}

// Genera parámetros para el próximo slice
$newTo = $toArray + $defaultCant;
if($fromArray < 317) {
	$remain = 317 - $toArray;
	echo "<br />Ye cargaron ". $toArray . " categorías. Faltan " . $remain .". Si desea continuar cargando productos automáticamente: 
	<a href='./laanonima.php?fromArray=".++$toArray."&toArray=".$newTo."&auto' />haga click aquí</a>.";
	// Pasa a la próxima carga
	$newURL = "./laanonima.php?fromArray=".++$toArray."&toArray=".$newTo."&auto";
		if(isset($_GET['auto'])){
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $newURL . '">';
		}
	} else {
	echo "<br />Ye se cargaron todas las categorías.";
}

include(ASSETS . 'footer.php');
?>