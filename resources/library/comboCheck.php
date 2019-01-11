<?php 
function combo($title) {
	if (strpos($title, '+') !== false) {
	    echo 'Combo: No';
	} else {
		$comboElements = ;
		echo 'Combo: Si';
		foreach(explode($title, '+', 4) as $comboElement) {
		echo 'Conformado por:<ul><li>' . strstr($comboElement, 'Combo', true) . '</li></ul>';
		}
	}
}