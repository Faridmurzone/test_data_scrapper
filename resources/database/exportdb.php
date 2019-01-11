<?php
// DB
include('../../config.php');

function cleanData(&$str) {
	// Omitir chars
	$str = preg_replace("/\t/", "\\t", $str); 
	// Omitir lineas
	$str = preg_replace("/\r?\n/", "\\n", $str); 
	// Convertir t/f a booleanos 
	if($str == 't') $str = 'TRUE'; 
	if($str == 'f') $str = 'FALSE'; 
	// Force number/date formats como strings 
	if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) 
		{ $str = "'$str"; } 
	// Escapar doble quotes 
	if(strstr($str, '"')) 
		$str = '"' . str_replace('"', '""', $str) . '"'; 
} 
function export() {
        // Nombre del archivo
        $filename = "membership_data_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false; 
        $result = mysql_query("SELECT * FROM listado_producto ORDER BY id") or die('Query failed!'); 
        while(false !== ($row = mysql_fetch_assoc($result))) { 
	        if(!$flag) { 
		        // Mostrar field/column como primera columna 
		        echo implode("\t", array_keys($row)) . "\n"; $flag = true; 
	        }         
	        array_walk($row, 'cleanData'); 
	        echo implode("\t", array_values($row)) . "\n"; 
        } 
}
if(isset($_REQUEST['export'])) {
        export();
}

?>
