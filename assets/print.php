<?php

echo <<<END

    <tr>
      <th scope="row">$cantidad</th>
      <td><img src="$img" width="50px" /></td>
      <td>$retailer</td>
      <td>$category</td>
      <td>$titulo</td>
	  <td>$marca</td>
	  <td>$modelo</td>
      <td>$precio_lista</td>
      <td>$precio_oferta</td>
      <td><a target="_blank" href="http://mrt.com.ar/mbot/screenshots$screenshot">Screenshot</a></td>
      <td>$link</td>
      <td>$date</td>
      <td>

END;

	if($combo == FALSE) {
		echo "No contiene combo de productos";
		} else {
		echo "Combo conformado por:";
		foreach($comboProds as $comboElement) {
		echo '<br>-' . $comboElement;
		}
	}

echo <<< END
	</td></tr>

END;
