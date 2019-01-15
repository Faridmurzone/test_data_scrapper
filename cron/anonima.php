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
    $count = mysqli_query($conn,"SELECT count(*) as total FROM listado_screens WHERE laanonima_check = '1'");
    $data = mysqli_fetch_assoc($count);
    $total = $data['total'];
    $from = 0;
    $to = $total;
}

$result = mysqli_query($conn,"SELECT * FROM listado_screens WHERE laanonima_check = '1' LIMIT $from, $to;");
// Iniciar el bucle
while($row = mysqli_fetch_array($result))
{
	$link = $row['laanonima'];
    $cat = $row['category'];
    $screenshotID++;
    $validURL = get_http_response_code($link);
        if($validURL == 200) {
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
            $retailer = "laanonima";
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
            
            $producto = $html->find('div[class=itemBox]');
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
        echo "\n <div class='alert alert-warning'>URL $link es inválida...</div> \n";
        }
}
$time_elapsed = microtime(true) - $start;
$tieme_readable = conversorSegundosHoras($time_elapsed);
echo " <div class='alert alert-info'>El script de LaAnonima se ejecutó en $tieme_readable segundos y se cargaron $cantidad productos</div> \n";
$htmlStr = ob_get_contents();
ob_end_clean(); 
$filename = date('Y-m-d') . "laanonima_log.php";
file_put_contents('/var/www/html/mbot/cron/logs/'.$filename, $htmlStr, FILE_APPEND);

?>