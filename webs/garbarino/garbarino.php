<?php 
include('../../config.php');
include(ASSETS . 'header.php'); 
$retailer = basename(__FILE__, '.php'); 

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

// Iniciar el bucle con slice de los parámetros pasados
$controlador = array_slice($links['garbarino'], $fromArray, $toArray);
foreach($controlador as $cat => $link) {
	$screenshotID++;
	if($link != NULL) {
    $html = file_get_html($link);    
	$producto = $html->find('div[class=itemBox]');
    foreach ($producto as $prod) {
		$cantidad++;
		$titulo = $prod->find('h3[class=itemBox--title]',0)->plaintext;
		$modelo = $titulo;	
		$link = "https://www.garbarino.com" . $prod->find('a',0)->href;
		$img = $prod->find('img',0)->src;	
		$category = preg_replace('/[0-9]+/', '', $cat);
		$retailer = "GARBARINO";
		$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
		// Query para ver si el producto existe y es igual
		$precio = $prod->find('span[class=value-item]',0);
		$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND precio_lista LIKE '%$precio%' AND date LIKE '%$yesterday%' AND retailer LIKE '%$retailer%';");
		// Para no cargar DOM de producto individual busca primero si ya existe el producto
		while($row = mysqli_fetch_array($query)) {
			if($row['title'] == $titulo) {
				$marca = $row['marca'];
				$modelo = $row['modelo'];
				$precio_lista = $row['precio_lista'];
				$precio_oferta = $row['precio_oferta'];
			} 
		}
		$date = date("Y-m-d H:i:s");
		if(!mysqli_fetch_array($query)){
			$html_prod = file_get_html($link);
			$marca = $html_prod->find('li[class=gb-breadcrumb-brand]',0)->plaintext;
			$precios = $html_prod->find('div[class=itemBox--price itemBox--price-lg]',0);
			// Si no hay oferta toma precio online como precio de lista
			if($html_prod->find('span[id=final-price]',0)) {
				$precio_oferta = $precios->find('span[id=final-price]',0)->plaintext;
				$precio_lista = $html_prod->find('del',0)->plaintext;
			} else {
				$precio_lista = $prod->find('span[id=final-price]',0);
				$precio_oferta = NULL;
			}
		}

		// Busca Combos
		include(LIB.'findCombo.php');
		// Imprime en pantalla los resultados encontrados
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
	<a href='./garbarino.php?fromArray=".++$toArray."&toArray=".$newTo."&auto' />haga click aquí</a>.";
	// Pasa a la próxima carga
	$newURL = "./garbarino.php?fromArray=".++$toArray."&toArray=".$newTo."&auto";
		if(isset($_GET['auto'])){
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $newURL . '">';
		}
	} else {
	echo "<br />Ye se cargaron todas las categorías.";
}

include(ASSETS . 'footer.php');
?>