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

$result = mysqli_query($conn,"SELECT * FROM listado_screens WHERE ribeiro_check = '1' LIMIT 2 OFFSET $fromArray;");

// Iniciar el bucle
while($row = mysqli_fetch_array($result))
{
	$link = $row['ribeiro'];
	$cat = $row['category'];
	$screenshotID++;
	if($link != NULL) {
	$html = file_get_html($link);
	$producto = $html->find('li[class=odd]');
	$producto2 = $html->find('li[class=even]');
	foreach ($producto as $prod) {
	while($prod->find('h2[class=prodNom]',0)) {
		$cantidad++;
		$titulo = $prod->find('h2[class=prodNom]',0)->plaintext;
		$link = "https://www.ribeiro.com.ar" . $prod->find('a',0)->href;
		$precio_lista = $prod->find('span[id=priceOnline]',0)->plaintext; 
		$precio_oferta = $prod->find('span[style=font-weight: bold;font-size: 16px;color: #F26532; display:inline;]',0)->plaintext;
		$marca = $prod->find('span[class=prodMarca]',0)->plaintext;
		//echo $marca."test marca";
		$category = preg_replace('/[0-9]+/', '', $cat);
		$retailer = "RIBEIRO";
		$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
		
		// Query para ver si el producto existe y es igual
		$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND precio_lista LIKE '%$precio_lista%' AND date LIKE '%$yesterday%' AND retailer LIKE '%$retailer%';");
		// Para no cargar DOM de producto individual busca primero si ya existe el producto
		while($row = mysqli_fetch_array($query)) {
			if($row['title'] == $titulo) {
				$modelo = $row['modelo'];
				$img = $row['imagen'];
			} 
		}
		if(!mysqli_fetch_array($query)){
			$html_prod = file_get_html($link) ;
			$prod_indiv= $html_prod->find('div[id=ContenedorDescripciones]');
			$prod_indiv2= $html_prod->find('div[class=contImg]');
			foreach ($prod_indiv2 as $prod3){
				$img = $prod3->find('img[id=zoom_03f]',0)->src;
			}
			foreach ($prod_indiv as $prodi){
				$modelo = $prodi->find('h2[class=texto_descrip2]',0)->plaintext;
					
			}
		}
		$date = date("Y-m-d H:i:s");

		// Busca Combos
		include(LIB.'findCombo.php');
		
		include(ASSETS.'print.php');	
		// PARA INSERTAR EN DB
		include(DB.'insert.php');	
		break;
		}
	}
	foreach ($producto2 as $prod2) {
	while($prod2->find('h2[class=prodNom]',0)) {
		$cantidad++;
		$titulo = $prod2->find('h2[class=prodNom]',0)->plaintext;
		$link = "https://www.ribeiro.com.ar" . $prod2->find('a',0)->href;
		$precio_lista = $prod2->find('span[id=priceOnline]',0)->plaintext; 
		$precio_oferta = $prod2->find('span[style=font-weight: bold;font-size: 16px;color: #F26532; display:inline;]',0)->plaintext;
		$marca = $prod2->find('span[class=prodMarca]',0);
		$category = $cat;
		$retailer = "RIBEIRO";
		$prodComboA = "id";
		$prodComboB = "id";
		
		// Query para ver si el producto existe y es igual
		$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND precio_lista LIKE '%$precio_lista%' AND date LIKE '%$date%' AND retailer LIKE '%RIBEIRO%';");
		// Para no cargar DOM de producto individual busca primero si ya existe el producto
		while($row = mysqli_fetch_array($query)) {
			if($row['title'] == $titulo) {
				$modelo = $row['modelo'];
				$img = $row['imagen'];
			} 
		}
		if(!mysqli_fetch_array($query)){
			$html_prod2 = file_get_html($link) ;
			$prod_indiv2= $html_prod2->find('div[id=ContenedorDescripciones]');
			foreach ($prod_indiv2 as $prodi2){
				$modelo = $prodi2->find('h2[class=texto_descrip2]',0)->plaintext; 
			}
		}
		$date = date("Y-m-d H:i:s");

		// Busca Combos
		if (strpos($titulo, '+') == FALSE) {
	    	$combo = FALSE;
		} else {
			$combo = TRUE;
			$comboProds = preg_split('/[+]/', $titulo);
		} 
		
		include(ASSETS.'print.php');	
		// PARA INSERTAR EN DB
		include(DB.'insert.php');	
		break;
		}
	}
	// Imprimir mensajes
	echo "<div class='p-3 mb-2 bg-success text-white' id='helpdiv'>Categoría $cat cargada... ok<br /> <br /></div>";
	} else {
	echo "<div class='p-3 mb-2 bg-warning text-white' id='helpdiv'>Categoría $cat no contiene productos nuevos...</span><br />";
	}
}

	// Genera parámetros para el próximo slice
	$newTo = $toArray + $defaultCant;
	echo "<br />Ye se cargó la categoría. Si desea continuar cargando productos automáticamente: 
	<a href='./ribeiro.php?fromArray=".++$toArray."&toArray=".$newTo."&auto' />haga click aquí</a>.";
	// Pasa a la próxima carga
	$newURL = "./ribeiro.php?fromArray=".++$toArray."&toArray=".$newTo."&auto";
		if(isset($_GET['auto'])){
		echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $newURL . '">';
		}

include(ASSETS . 'footer.php');
?>