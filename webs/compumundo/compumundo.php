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
$controlador = array_slice($links['compumundo'], $fromArray, $toArray);
foreach($controlador as $cat => $link) {
		$screenshotID++;
		if($link != NULL) {
			$html = file_get_html($link);
				$producto = $html->find('div[class=itemBox]');
				foreach ($producto as $prod) {
						$cantidad++;
						$titulo = $prod->find('h3[class=itemBox--title]',0)->plaintext;
						$link = "http://compumundo.com.ar" . $prod->find('a',0)->href;
						$img = $prod->find('img',0)->src;
						// Cambia el formato según si el precio de lista tiene promo o no
						if($prod->find('span[class=value-item--full-price ]',0)) {
								$precio_lista = $prod->find('span[class=value-item]',0)->plaintext;
								$precio_oferta = NULL;
						} else {
								$precio_lista = $prod->find('span[class=value-item]',0)->plaintext;
								if($prod->find('del',0)) {
								$precio_oferta = $prod->find('del',0)->plaintext;
							}
					}
	
					$category = preg_replace('/[0-9]+/', '', $cat);
					$retailer = "COMPUMUNDO";
					$screenshot = "/" . date('Y-m-d') . "/". strtolower($retailer) . "_" . $screenshotID . ".jpg";
	
					// Query para ver si el producto existe y es igual
					$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND precio_lista LIKE '%$precio_lista%' AND date LIKE '%$yesterday%' AND retailer LIKE '%$retailer%';");
					// Para no cargar DOM de producto individual busca primero si ya existe el producto
					while($row = mysqli_fetch_array($query)) {
							if($row['title'] == $titulo) {
									$marca = $row['marca'];
									$modelo = $row['modelo'];
									$precio_lista = $row['precio_lista'];
									$precio_oferta = $row['precio_oferta'];
								}
							}
							if(!mysqli_fetch_array($query)){
									$html_prod = file_get_html($link);
									$marca = $html_prod->find('li[class=gb-breadcrumb-brand]',0)->plaintext;
									$modelo = $titulo;
							}
							$date = date("Y-m-d H:i:s");

                // Busca Combos
                include('../../resources/library/findCombo.php');

                // Preview de subida
                include(ASSETS.'print.php');
                // PARA INSERTAR EN DB
                include(DB.'insert.php');
        }
        // Imprimir mensajes
        echo "<span class='p-3 mb-2 text-secondary'>Categoría $cat cargada... ok<br /> <br /></div>";
        } else {
        echo "<span class='p-3 mb-2 text-warning'>Categoría $cat no contiene productos nuevos...</span><br />";
        }
}


// Genera parámetros para el próximo slice
$newTo = $toArray + $defaultCant;
        if($fromArray < 317) {
                $remain = 317 - $toArray;
                echo "<br />Ye cargaron ". $toArray . " categorías. Faltan " . $remain .". Si desea que la carga se siga realizando automáticamente:
                <a href='./compumundo.php?fromArray=".++$toArray."&toArray=".$newTo."&auto' />haga click aquí</a>. De lo contrario continuará automáticamente en algunos segundos";
                // Pasa a la próxima carga
                $newURL = "./compumundo.php?fromArray=".++$toArray."&toArray=".$newTo."&auto";
                if(isset($_GET['auto'])){
                        echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $newURL . '">';
                }
        } else {
                echo "<br />Ye se cargaron todas las categorías.";
        }

        include(ASSETS . 'footer.php');


?>


			
			
	