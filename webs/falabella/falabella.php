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

// Iniciar el bucle con slice de los parámetros pasados
$controlador = array_slice($links['falabella'], $fromArray, $toArray);
foreach($controlador as $cat => $link) {
	$screenshotID++;
	if($link != FALSE) {
		$html = file_get_html($link);
		$producto = $html->find('div[class=fb-pod-group__item]');
		foreach ($producto as $prod) {
		$cantidad++;
		$tituloiso = $prod->find('h4[class=fb-responsive-hdng-5 fb-pod__product-title]',0)->plaintext;
		$titulo = iconv("ISO-8859-1", "UTF-8", $tituloiso);
		$link = "https://www.falabella.com.ar" . $prod->find('a',0)->href;
		$img = $prod->find('img',0)->src;	
		$category = preg_replace('/[0-9]+/', '', $cat);
		$retailer = "FALABELLA";
		$screenshot = "/" . $date . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
		$marca = $prod->find('h3[class=fb-responsive-stylised-caps fb-pod__title]',0)->plaintext;
		
		// Query para ver si el producto existe y es igual
		$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND date LIKE '%$yesterday%' AND retailer LIKE '%$retailer%';");
		while($row = mysqli_fetch_array($query)) {
			if($row['title'] == $titulo) {
				$modelo = $row['modelo'];
			} 
		}
		$date = date("Y-m-d H:i:s");
		if(!mysqli_fetch_array($query)){
			// Entrando al producto
			$html_prod = file_get_html($link);
			$modelo = $html_prod->find('td[class=fb-product-information__specification__table__data]',0)->plaintext;
		}
		// Busca Combos
		include(LIB.'findCombo.php');
		
		// Imprime resultados encontrados
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
echo "<br />Ye cargaron ". $toArray . " categorías. Faltan " . $remain .". Si desea que la carga se siga realizando automáticamente: 
<a href='./falabella.php?fromArray=".++$toArray."&toArray=".$newTo."&auto' />haga click aquí</a>. De lo contrario continuará automáticamente en algunos segundos";

// Pasa a la próxima carga
$newURL = "./falabella.php?fromArray=".++$toArray."&toArray=".$newTo."&auto";
	if(isset($_GET['auto'])){
	echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $newURL . '">';
	}
} else {
echo "<br />Ye se cargaron todas las categorías.";
}

include(ASSETS . 'footer.php');

?>