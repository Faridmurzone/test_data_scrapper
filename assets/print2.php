<?php
/*	    echo "<div class='col-md-4 col-sm-12'>";
		echo "<div>---------------------------------------------------------</div>";
	    echo "<img src='$img' />";
	    echo "<div>","Producto N: ", $cantidad,"</div>";
		echo "<div>","Titulo: ", $titulo,"</div>";
		echo "<div>","LINK: ", $link,"</div>";
		echo "<div>","Marca: ",$marca,"</div>";
		echo "<div>","Modelo: ",$modelo,"</div>";
		echo "<div>","Precio Lista: ",$precio_lista,"</div>";
		echo "<div>","Precio Oferta: ",$precio_oferta,"</div>";
		echo "<div>","Categoria: ", $category,"</div>";
		echo "<div>","Retailer: ", $retailer,"</div>";
		echo "<div>","Fecha: ", $date,"</div>";
		echo "<div>","ProdComboA ID: ", $prodComboA,"</div>";
		echo "<div>","ProdComboB ID: ", $prodComboB,"</div>";
		echo "<div></div>";
		echo "<div></div>";		
		echo "</div>";
*/
echo <<<END

<div class="col-md-3">
	<div class="card border-success mr-0 ml-0 mb-3" style="max-width: 18rem;">
	  <div class="card-header bg-transparent border-success">$retailer</div>
	  <img class="card-img-top" src="$img" alt="Card image cap">
	  <div class="card-body text-success">
	    <h5 class="card-title">$titulo</h5>
	    <p class="card-text">
	    <ul>
	    <li>Precio de lista: $precio_lista</li>
	    <li>Precio oferta: $precio_oferta</li>
	    </p>
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
	    <a href="$link" class="btn btn-primary">Ver en su web</a>
	  </div>
	  <div class="card-footer bg-transparent border-success">Fecha: $date</div>
	</div>
</div>
END;
