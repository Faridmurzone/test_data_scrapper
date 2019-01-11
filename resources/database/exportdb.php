<?php
// DB
include('../../config.php');

function cleanData(&$str) {
	// escape tab characters 
	$str = preg_replace("/\t/", "\\t", $str); 
	// escape new lines 
	$str = preg_replace("/\r?\n/", "\\n", $str); 
	// convert 't' and 'f' to boolean values 
	if($str == 't') $str = 'TRUE'; 
	if($str == 'f') $str = 'FALSE'; 
	// force certain number/date formats to be imported as strings 
	if(preg_match("/^0/", $str) || preg_match("/^\+?\d{8,}$/", $str) || preg_match("/^\d{4}.\d{1,2}.\d{1,2}/", $str)) 
		{ $str = "'$str"; } 
	// escape fields that include double quotes 
	if(strstr($str, '"')) 
		$str = '"' . str_replace('"', '""', $str) . '"'; 
} 
function export() {
        // file name for download 
        $filename = "membership_data_" . date('Ymd') . ".xls"; 
        header("Content-Disposition: attachment; filename=\"$filename\""); 
        header("Content-Type: application/vnd.ms-excel"); 
        $flag = false; 
        $result = mysql_query("SELECT * FROM listado_producto ORDER BY id") or die('Query failed!'); 
        while(false !== ($row = mysql_fetch_assoc($result))) { 
	        if(!$flag) { 
		        // display field/column names as first row 
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
