<?php
$start = microtime(true);
ob_start();
require_once('/var/www/html/mbot/cron/simple_html_dom.php');
include('/var/www/html/mbot/config.php');
include('/var/www/html/mbot/library/utils.php');

takeArgs();

// Iniciar el bucle
while($row = mysqli_fetch_array($result))
{
	$link = $row['compumundo'];
    $cat = $row['category'];
    $id = $row['id'];
    
    $screenshotID++;
    $validURL = get_http_response_code($link);
        if($validURL == 200) {
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
                $precio_oferta = $prod->find('span[class=value-item]',0)->plaintext; 
                if($prod->find('del',0)) { 
                $precio_lista = $prod->find('del',0)->plaintext;
                } else {
                $precio_lista = $prod->find('span[class=value-note]',0)->plaintext;	
                }
            }

            if($precio_oferta > $precio_lista) {
                $temp = $precio_oferta;
                $precio_lista = $precio_oferta;
                $precio_oferta = $temp;
            }

            $category = preg_replace('/[0-9]+/', '', $cat);
            $retailer = "compumundo";
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
            // Inserta en la DB
            $query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND retailer = '$retailer' AND date LIKE '%" . date("Y-m-d") . "%'");
            $exists = mysqli_num_rows($query);
            if(!$exists){
                $sql = "INSERT INTO listado_productos (title, precio_lista, precio_oferta, category, retailer, marca, modelo, date, combo, imagen, link, screenshot) 
                    VALUES ('$titulo', '$precio_lista', '$precio_oferta', '$category', '$retailer', '$marca', '$modelo', '$date', '$combo', '$img', '$link', '$screenshot')";
                if ($conn->query($sql) === TRUE) {
                     echo "";
                }
            echo $conn->error;
            }
            // Fin del insert    
        }
        // Imprimir mensajes
        $date = date("Y-m-d H:i:s");
            $catStatus = "<span class='text-success'>[Id: $id] $date : Categoría $cat cargada.</span><br />\n";
        } else {
            $catStatus = "<span class='text-warning'>[Id: $id] Hubo un error con la categoría $cat . Compruebe el link: $link .</span><br /> \n";
        }   
        $htmlStr = $catStatus;
        file_put_contents('/var/www/html/mbot/cron/logs/'.$filename, $htmlStr, FILE_APPEND);
}
$time_elapsed = microtime(true) - $start;
$tieme_readable = conversorSegundosHoras($time_elapsed);
echo " <div class='alert alert-info'>El script de $retailer se ejecutó en $tieme_readable segundos y se cargaron $cantidad productos</div> \n";
$htmlStr = ob_get_contents();
ob_end_clean(); 
file_put_contents('/var/www/html/mbot/cron/logs/'.$filename, $htmlStr, FILE_APPEND);

?>
