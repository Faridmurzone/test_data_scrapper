<?php 
include('../../config.php');
include('../../assets/header.php'); 	 	

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
ini_set("user_agent","Mozilla/5.0 (Windows NT 6.1; rv:8.0) Gecko/20100101 Firefox/8.0");

// Iniciar el bucle con slice de los parámetros pasados
$controlador = array_slice($links['fravega'], $fromArray, $toArray);
foreach($controlador as $cat => $link) {
	$screenshotID++;
	$context = stream_context_create(array(
	    'http' => array(
	        'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
	    ),
	));
	if($link != NULL) {
	$html = file_get_html($link, false, $context);
	$producto = $html->find('div[class*=wrapData]');
	foreach ($producto as $prod) {
		$cantidad++;
		$titulo = $prod->find('h2',0)->plaintext;
		$link = $prod->find('a',0)->href;
		$precio_lista = $prod->find('em[class=ListPrice]',0)->plaintext; 
		$category = preg_replace('/[0-9]+/', '', $cat);
		$retailer = "FRAVEGA";
		$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
		
		// Query para ver si el producto existe y es igual
		$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND precio_lista LIKE '%$precio_lista%' AND date LIKE '%$yesterday%' AND retailer LIKE '%$retailer%';");
		while($row = mysqli_fetch_array($query)) {
			if($row['title'] == $titulo) {
				$marca = $row['marca'];
				$modelo = $row['modelo'];
				$precio_oferta = $row['precio_oferta'];
			} 
		}
		$date = date("Y-m-d H:i:s");
		if(!mysqli_fetch_array($query)){
			// Tomar marca y modelo
			$html_prod = file_get_html($link);
			if($html_prod != FALSE) {
				$precio_oferta = $html_prod->find('strong[class=skuBestPrice]',0)->plaintext;
				$modelo = $html_prod->find('td[class=value-field Modelo]',0)->plaintext;	
				$hgroup = $html_prod->find('hgroup[class=title]',0);	
				$marca = $hgroup->find('div[class=brandName]',0)->plaintext;
			}
		}
		
		// Busca Combos
		include(LIB.'/findCombo.php');
		// Imprimir resultados
		include(ASSETS.'print.php');	
		// PARA INSERTAR EN DB
		include(DB.'insert.php');			
	}
	// Carga completa mensajes
	echo "<div class='p-3 mb-2 bg-success text-white'>Categoría $cat cargada... ok</div>";
	} else {
	echo "<div class='p-3 mb-2 bg-warning text-white'>Categoría $cat no contiene productos nuevos...</div>";
	}
}

// Genera parámetros para el próximo slice
if(isset($_GET_['toArray'])) {
	$newTo = $_GET['toArray'] + $defaultCant; }
else {
	$newTo = 1;
}
if($fromArray < 317) {
	$remain = 317 - $toArray;
echo "<br />Ye cargaron ". $toArray . " categorías. Faltan " . $remain .". Si desea que la carga se siga realizando automáticamente: 
<a href='./fravega.php?fromArray=".++$toArray."&toArray=".$newTo."&auto' />haga click aquí</a>. De lo contrario continuará automáticamente en algunos segundos";

// Pasa a la próxima carga
$newURL = "./fravega.php?fromArray=".++$toArray."&toArray=".$newTo."&auto";
	if(isset($_GET['auto'])){
	echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $newURL . '">';
	}
} else {
echo "<br />Ye se cargaron todas las categorías.";
}

include(ASSETS . 'footer.php');
?>

