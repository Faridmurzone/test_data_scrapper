<?php
set_time_limit(0);
error_reporting(0);
$start = microtime(true);
ob_start();
require_once('/var/www/html/mbot/cron/simple_html_dom.php');

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

$result = mysqli_query($conn,"SELECT * FROM listado_screens WHERE falabella_check = '1' LIMIT $from, $to;");
// Iniciar el bucle
while($row = mysqli_fetch_array($result))
{
	$link = $row['falabella'];
	$cat = $row['category'];
	$id = $row['id'];

    $validURL = get_http_response_code($link);
        if($validURL == 200) {
			$html = file_get_html($link);
			$producto = $html->find('div[class=fb-pod-group__item]');
			foreach ($producto as $prod) {
				$cantidad++;
				$tituloiso = $prod->find('h4[class=fb-responsive-hdng-5 fb-pod__product-title]',0)->plaintext;
				$titulo = iconv("ISO-8859-1", "UTF-8", $tituloiso);
				$link = "https://www.falabella.com.ar" . $prod->find('a',0)->href;
				$img = $prod->find('img',0)->src;	
				$category = preg_replace('/[0-9]+/', '', $cat);
				$retailer = "falabella";
				$screenshot = "/" . $date . "/". $retailer . "_" . $screenshotID . ".jpg";
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
				// Inserta en la DB
				$sql = "INSERT INTO listado_productos (title, precio_lista, precio_oferta, category, retailer, marca, modelo, date, combo, imagen, link, screenshot) 
						VALUES ('$titulo', '$precio_lista', '$precio_oferta', '$category', '$retailer', '$marca', '$modelo', '$date', '$combo', '$img', '$link', '$screenshot')";
					if ($conn->query($sql) === TRUE) {
						echo "";
					} 
				$date = date("Y-m-d H:i:s");
			}
			echo "<span class='text-success'>[Id: $id] $date : Categoría $cat cargada.</span><br />\n";
        } else {
        echo "<span class='text-warning'>[Id: $id] Hubo un error con la categoría $cat . Compruebe el $link .</span><br /> \n";
        }
}
$time_elapsed = microtime(true) - $start;
$tieme_readable = conversorSegundosHoras($time_elapsed);
echo " <div class='alert alert-info'>El script de $retailer se ejecutó en $tieme_readable segundos y se cargaron $cantidad productos</div> \n";
$htmlStr = ob_get_contents();
ob_end_clean(); 
$filename = date('Y-m-d') . $retailer . "_log.php";
file_put_contents('/var/www/html/mbot/cron/logs/'.$filename, $htmlStr, FILE_APPEND);

?>
