<?php 
include('../../config.php');
include('../../assets/header.php'); 

echo "<a href='../../index.php' class='btn btn-info mb-3' role='button'>Volver al index</a>";


// Chequear si se le pasan parámetros para leer los links
// Chequear si se le pasan parámetros para leer los links
/*if(isset($_GET['fromArray'])) {
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
$controlador = array_slice($links['falabella'], $fromArray, $toArray);*/

	$link = "https://www.falabella.com.ar/falabella-ar/category/cat10178/TV-LED-y-Smart-TV";
	$html = file_get_html($link);    
	$producto = $html->find('div[class=fb-pod-group__item]');
	
    foreach ($producto as $prod) {
		$cantidad++;
		$titulo = $prod->find('h4[class=fb-responsive-hdng-5 fb-pod__product-title]',0)->plaintext;
		$link2 = "https://www.falabella.com" . $prod->find('a',0)->href;
		$img = $prod->find('img',0)->src;	
		$category = preg_replace('/[0-9]+/', '', $cat);
		$retailer = "Falabella";
		$date = date('Y-m-d');
		$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
		$marca = $prod->find('h3[class=fb-responsive-stylised-caps fb-pod__title]',0)->plaintext;
		$precio_lista = $prod->find('p[class=fb-price]',0);
		$precio_oferta = $prod->find('p[class=fb-price]',1);

		/*$html_prod = file_get_html($link);
		$marca = $html_prod->find('li[class=gb-breadcrumb-brand]',0)->plaintext;
		$precios = $html_prod->find('div[class=itemBox--price itemBox--price-lg]',0);

		// Si no hay oferta toma precio online como precio de lista
		if($html_prod->find('span[class=value-item]',0)->plaintext) {
			$precio_lista = $precios->find('span[class=value-item]',0)->plaintext;
			$precio_oferta = $html_prod->find('del',0)->plaintext;
		} else if ($html_prod->find('span[class=value-item]',0)->plaintext == NULL) {
			$precio_lista = $prod->find('span[class=price online]',0);
			$precio_oferta = NULL;
		}
*/
		// Busca Combos
		include('../../resources/library/findCombo.php');
		
		$modelo = "Modelo";	
					
		var_dump($titulo);
		//include('../../assets/print.php');

		// PARA INSERTAR EN DB
	//include('../../resources/database/insert.php');

echo <<<END

    <tr>
      <th scope="row">$cantidad</th>
      <td><img src="$img" width="50px" /></td>
      <td>holaaa</td>
      <td>$category</td>
      <td>$titulo</td>
	  <td>$marca</td>
	  <td>$modelo</td>
      <td>$precio_lista</td>
      <td>$precio_oferta</td>
      <td><a target="_blank" href="http://mrt.com.ar/mbot/screenshots$screenshot">Screenshot</a></td>
      <td>$link</td>
      <td>$date</td>
      <td>

END;

	}

var_dump($modelo);
// Genera parámetros para el próximo slice


include(ASSETS . 'footer.php');
?>