<?php
// TIMEZONE
date_default_timezone_set('America/Argentina/Buenos_Aires');

// PATHS
$path = $_SERVER['DOCUMENT_ROOT'].'/mbot';
define('ASSETS', $path . '/assets/');
define('RES', $path .'/resources/');
define('DB', $path .'/resources/database/');
define('LIB', $path . '/resources/library/');

// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
// DB -> YOU NEED TO COMPLETE THIS
// !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!

$servername = "";
$username = "";
$password = "";
$dbname = "";
// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Charset
$conn->set_charset("utf8");
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 


// OTHERS
$titulo = $link = $img = $precio_lista = $precio_oferta = $category = $retailer = $date = $prodComboA = $prodComboB = $marca = $modelo = $combo = $screenshot = NULL;
$cantidad=0;
$defaultFromArray = 0;
$defaultToArray = 1;
$defaultCant = $defaultToArray + 1;
$screenshotID = 0;
$date = date('Y-m-d');
$yesterday = strtotime( '-1 day', strtotime ( $date ));
$yesterday = date( 'Y-m-j', $yesterday);

