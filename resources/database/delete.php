<?php

// DB
include('../../config.php');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Toma Retailer
	if(isset($_GET['retailer'])) {
		$retailer = $_GET['retailer'];
		if($retailer = "all") {
			$retailer = "*";
		}
     } else {
     	$retailer = 'none';
     }
// Toma date
     if(isset($_GET['date'])) {
		$date = $_GET['date'];
     } else {	
     	$date = 'none';
     }

    if($retailer === "none" && $date === "none") {
	echo "none";
	} elseif($retailer === "" || $date === "") {
	echo "Faltó completar alguno de los campos";
	} else {
		$retailer = $_GET['retailer'];
		if($_GET['date'] == "last") {
        	$date = date('Y-m-d');
        } else { $date = $_GET['date']; }
    	$result = mysqli_query($conn,"DELETE FROM listado_productos WHERE retailer LIKE '%$retailer%' AND date LIKE '%$date%'");
    	echo "Se borró " . $_GET['retailer'] . " para la fecha " . $date;
    }

    	if ($conn->query($result) === TRUE) {
		    echo "Ok...";
		}
