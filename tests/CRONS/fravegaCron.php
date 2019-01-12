<?php
set_time_limit(0);
// error_reporting(0);
$start = microtime(true);
ob_start();
require_once('./simple_html_dom.php');

// FUNCIONES
// Chequear headers para ver si URL funciona
function get_http_response_code($link) {
    $headers = get_headers($link);
    $validURL = substr($headers[0], 9, 3);
    return $validURL;   
}
// Convertir segundos
function conversorSegundosHoras($tiempo_en_segundos) {
    $horas = floor($tiempo_en_segundos / 3600);
    $minutos = floor(($tiempo_en_segundos - ($horas * 3600)) / 60);
    $segundos = $tiempo_en_segundos - ($horas * 3600) - ($minutos * 60);

    return $horas . 'h ' . $minutos . "m " . $segundos . "s ";
}

// DB
$servername = "localhost";
$username = "mbot";
$password = "Sismrt_2013";
$dbname = "mbot";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Charset
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// OTRAS
$titulo = $link = $img = $precio_lista = $precio_oferta = $category = $retailer = $date = $prodComboA = $prodComboB = $marca = $modelo = $combo = $screenshot = NULL;
$cantidad=0;
$defaultFromArray = 0;
$defaultToArray = 1;
$defaultCant = $defaultToArray + 1;
$screenshotID = 0;
$date = date('Y-m-d');
$yesterday = strtotime( '-1 day', strtotime ( $date ));
$yesterday = date( 'Y-m-j', $yesterday);
$retailer = basename(__FILE__, '.php'); 


if(isset($argv[1])) {
    $from = $argv[1];
    $to = $argv[2] - $from;
} else {
    $count = mysqli_query($conn,"SELECT count(*) as total FROM listado_screens WHERE fravega_check = '1'");
    $data = mysqli_fetch_assoc($count);
    $total = $data['total'];
    $from = 0;
    $to = $total;
}

$result = mysqli_query($conn,"SELECT * FROM listado_screens WHERE fravega_check = '1' LIMIT $from, $to;");
// Iniciar el bucle
while($row = mysqli_fetch_array($result))
{
	$link = $row['fravega'];
    $cat = $row['category'];
    $screenshotID++;
    $context = stream_context_create(array(
	    'http' => array(
	        'header' => array('User-Agent: Mozilla/5.0 (Windows; U; Windows NT 6.1; rv:2.2) Gecko/20110201'),
	    ),
	));
    $validURL = get_http_response_code($link);
        if($validURL == 200) {
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
            // Inserta en la DB
            $query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND retailer = '$retailer' AND date LIKE '%" . date("Y-m-d") . "%'");
            $exists = mysqli_num_rows($query);
            if(!$exists){
                $sql = "INSERT INTO listado_productos (title, precio_lista, precio_oferta, category, retailer, marca, modelo, date, combo, imagen, link, screenshot) 
                    VALUES ('$titulo', '$precio_lista', '$precio_oferta', '$category', '$retailer', '$marca', '$modelo', '$date', '$combo', '$img', '$link', '$screenshot')";
                if ($conn->query($sql) === TRUE) {
                    echo ".";
                } else {
                    echo "Error: " . $sql . " " . $conn->error;
                }
            echo $conn->error;
            } else {
                echo "El producto " . $titulo . " ya fue cargado hoy \n";
            }
            // Fin del insert    
        }
        // Imprimir mensajes
        $date = date("Y-m-d H:i:s");
        echo "$date : Categoría $cat cargada... ok \n";
        } else {
        echo "URL $link es inválida... \n";
        }
}
$time_elapsed = microtime(true) - $start;
$tieme_readable = conversorSegundosHoras($time_elapsed);
echo "El script de Fravega se ejecutó en $tieme_readable segundos y se cargaron $cantidad productos \n";
$htmlStr = ob_get_contents();
ob_end_clean(); 
$filename = date('Y-m-d') . $retailer . "_log.php";
file_put_contents('logs/'.$filename, $htmlStr, FILE_APPEND);

?>