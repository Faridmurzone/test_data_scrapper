<?php 
	echo "<h2>Valores por POST:</h2>";

	if(isset($_GET['precio_lista'])) {
		echo "Precio de lista:" . $_GET['precio_lista'] . "<br />";
	} else {
		echo "Por POST no entra ningun precio_lista<br/>";
	}

	if(isset($_GET['precio_oferta'])) {
		echo "Precio de oferta: " . $_GET['precio_oferta'] . "<br />";
	} else {
		echo "Por POST no entra ningun precio_oferta<br/>";
	}

	file_put_contents("./test.log", print_r($_GET, true), FILE_APPEND);


	echo "<h2>log</h2>";
	$myfile = fopen("test.log", "r") or die("No se pudo abrir el log!");
	echo fread($myfile,filesize("test.log"));
	fclose($myfile);

?>