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

if(isset($_GET['link'])) {
	$link = $_GET['link'];
	$cat = $_GET['cat'];
	$html = file_get_html($link);
	$producto = $html->find('article[class=product]');
			foreach ($producto as $prod) {
			$cantidad++;
			$titulo = $prod->find('a[class=name]',0)->plaintext;
			$link = $prod->find('a[class=name]',0)->href;	
			$img = $prod->find('img[style=background-color:transparent]',0)->src;	
			$category = preg_replace('/[0-9]+/', '', $cat);
			$retailer = "MUSIMUNDO";
			$date = date("Y-m-d H:i:s");
			$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
			// Si no hay oferta toma precio online como precio de lista
			if($prod->find('span[class=price cash]',0)) {
				$precio_lista = $prod->find('span[class=price cash]',0)->plaintext;
				$precio_oferta = $prod->find('span[class=price online]',0)->plaintext;
			} else {
				$precio_lista = $prod->find('span[class=price online]',0)->plaintext;
				$precio_oferta = NULL;
			}
			// Busca Combos
			if (strpos($titulo, '+') == FALSE) {
				$combo = FALSE;
				} else {
				$combo = TRUE;
				$comboProds = preg_split('/[+]/', $titulo);
				} 
				
			$yesterday = strtotime( '-1 day', strtotime ( $date ));
			$yesterday = date( 'Y-m-j', $yesterday);
			$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND date LIKE '%$yesterday%' AND retailer LIKE '%$retailer%';");
			// Para no cargar DOM de producto individual busca primero si ya existe el producto
			while($row = mysqli_fetch_array($query)) {
				if($row['title'] == $titulo) {
					$marca = $row['marca'];
					$modelo = $row['modelo'];
				} 
			}
			// Caso contrario lo carga nuevamente
			if(!mysqli_fetch_array($query)){
				$html_prod = file_get_html($link) ;
				$prod_indiv= $html_prod->find('div[class=description technic]');
				// Busca las tr de las especificaciones.
				$trs=$html_prod->find('tr');
				foreach($trs as $tds){
				if($tds->find('td', 0)->plaintext == 'MARCA'){
					$marca = $tds->find('td', 1)->plaintext;
				} elseif($tds->find('td', 0)->plaintext == 'Modelo') {
					$modelo = $tds->find('td', 1)->plaintext;
					}
				}
			}

			// Mostrar productos obtenidos
			include(ASSETS.'print.php');
			// Insertar en la DB
			include(DB.'insert.php');
		}
} else {
	$result = mysqli_query($conn,"SELECT * FROM listado_screens WHERE musimundo_check = '1' LIMIT 2 OFFSET $fromArray;");
	// Iniciar el bucle
	while($row = mysqli_fetch_array($result))
	{
		$link = $row['musimundo'];
		$cat = $row['category'];
		$screenshotID++;
		if($link != NULL) {
		$html = file_get_html($link);    
		$producto = $html->find('article[class=product]');
			foreach ($producto as $prod) {
			$cantidad++;
			$titulo = $prod->find('a[class=name]',0)->plaintext;
			$link = $prod->find('a[class=name]',0)->href;	
			$img = $prod->find('img[style=background-color:transparent]',0)->src;	
			$category = preg_replace('/[0-9]+/', '', $cat);
			$retailer = "MUSIMUNDO";
			$date = date("Y-m-d H:i:s");
			$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
			// Si no hay oferta toma precio online como precio de lista
			if($prod->find('span[class=price cash]',0)) {
				$precio_lista = $prod->find('span[class=price cash]',0)->plaintext;
				$precio_oferta = $prod->find('span[class=price online]',0)->plaintext;
			} else {
				$precio_lista = $prod->find('span[class=price online]',0)->plaintext;
				$precio_oferta = NULL;
			}
			// Busca Combos
			if (strpos($titulo, '+') == FALSE) {
				$combo = FALSE;
				} else {
				$combo = TRUE;
				$comboProds = preg_split('/[+]/', $titulo);
				} 
				
			$yesterday = strtotime( '-1 day', strtotime ( $date ));
			$yesterday = date( 'Y-m-j', $yesterday);
			$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND date LIKE '%$yesterday%' AND retailer LIKE '%$retailer%';");
			// Para no cargar DOM de producto individual busca primero si ya existe el producto
			while($row = mysqli_fetch_array($query)) {
				if($row['title'] == $titulo) {
					$marca = $row['marca'];
					$modelo = $row['modelo'];
				} 
			}
			// Caso contrario lo carga nuevamente
			if(!mysqli_fetch_array($query)){
				$html_prod = file_get_html($link) ;
				$prod_indiv= $html_prod->find('div[class=description technic]');
				// Busca las tr de las especificaciones.
				$trs=$html_prod->find('tr');
				foreach($trs as $tds){
				if($tds->find('td', 0)->plaintext == 'MARCA'){
					$marca = $tds->find('td', 1)->plaintext;
				} elseif($tds->find('td', 0)->plaintext == 'Modelo') {
					$modelo = $tds->find('td', 1)->plaintext;
					}
				}
			}

			// Mostrar productos obtenidos
			include(ASSETS.'print.php');
			// Insertar en la DB
			include(DB.'insert.php');
		}
		// Imprimir mensajes
		echo "<div class='p-3 mb-2 bg-success text-white' id='div-alert'>Categoría $cat cargada... ok<br /> <br /></div>";
		} else {
		echo "<div class='p-3 mb-2 bg-warning text-white' id='div-alert'>Categoría $cat no contiene productos nuevos...</span><br />";
		}
		break;
	}


	// Genera parámetros para el próximo slice
	$newTo = $toArray + $defaultCant;
	if($fromArray < 317) {
	$remain = 317 - $toArray;
	echo "<br />Ye cargaron ". $toArray . " categorías. Faltan " . $remain .". Si desea continuar cargando productos automáticamente: 
	<a href='./musimundo.php?fromArray=".++$toArray."&toArray=".$newTo."&auto' />haga click aquí</a>.";

	// Pasa a la próxima carga
	$newURL = "./musimundo.php?fromArray=".++$toArray."&toArray=".$newTo."&auto";
		if(isset($_GET['auto'])){
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $newURL . '">';
		}
	} else {
	echo "<br />Ye se cargaron todas las categorías.";
	}
}
include(ASSETS . 'footer.php');
?>