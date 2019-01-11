<?php
include('../config.php');
include('../assets/header2.php');   

// Recibe parámetros
if(isset($_REQUEST['retailer'])) {
    $retailer = $_REQUEST['retailer'];
    $ret_check = $retailer."_check";
} else {
	$retailer = NULL;
}

echo "Guardando...";
if(!empty($_POST['check_list'])) {
    $sql = "UPDATE listado_screens SET $ret_check = '0';"; //  WHERE $ret_check = '1'
    $conn->query($sql);
    foreach($_POST['check_list'] as $check) {
            $sql = "UPDATE listado_screens SET $ret_check = '1' WHERE id = '$check';";
            if ($conn->query($sql) === TRUE) {
                echo ".";
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
        echo $conn->error;
    }
    echo "... Listo. <a href='/mbot/'> Volver al inicio</a>";

}




?>