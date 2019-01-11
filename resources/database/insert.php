<?php

	$query = $conn->query("SELECT * FROM listado_productos WHERE title LIKE '%$titulo%' AND retailer = '$retailer' AND date LIKE '%" . date("Y-m-d") . "%'");
	$exists = mysqli_num_rows($query);
	if(!$exists){
		$sql = "INSERT INTO listado_productos (title, precio_lista, precio_oferta, category, retailer, marca, modelo, date, combo, imagen, link, screenshot) 
			VALUES ('$titulo', '$precio_lista', '$precio_oferta', '$category', '$retailer', '$marca', '$modelo', '$date', '$combo', '$img', '$link', '$screenshot')";

		if ($conn->query($sql) === TRUE) {
		    echo "";
		} else {
		    echo "Error: " . $sql . "<br>" . $conn->error;
		}
    echo $conn->error;
	} else {
		echo " <br />El producto " . $titulo . " ya fue cargado hoy.";
	}
