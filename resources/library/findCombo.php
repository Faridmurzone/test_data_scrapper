<?php		
		if (strpos($titulo, '+') == FALSE) {
	    	$combo = FALSE;
		} else {
			$combo = TRUE;
			$comboProds = preg_split('/[+]/', $titulo);
		} 