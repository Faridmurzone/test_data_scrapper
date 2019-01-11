<?php
// Articles
$date = date('Y-m-d');

$art_today = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%';");
$art_all = $conn->query("SELECT * FROM listado_productos");

// Cada uno
$art_today_musimundo = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%' AND retailer LIKE 'MUSIMUNDO';");
$art_all_musimundo = $conn->query("SELECT * FROM listado_productos WHERE retailer LIKE '%MUSIMUNDO%';");
$art_today_compumundo = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%' AND retailer LIKE 'COMPUMUNDO';");
$art_all_compumundo = $conn->query("SELECT * FROM listado_productos WHERE retailer LIKE '%COMPUMUNDO%';");
$art_today_fravega = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%' AND retailer LIKE 'FRAVEGA';");
$art_all_fravega = $conn->query("SELECT * FROM listado_productos WHERE retailer LIKE '%FRAVEGA%';");
$art_today_garbarino = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%' AND retailer LIKE 'GARBARINO';");
$art_all_garbarino = $conn->query("SELECT * FROM listado_productos WHERE retailer LIKE '%GARBARINO%';");
$art_today_ribeiro = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%' AND retailer LIKE 'RIBEIRO';");
$art_all_ribeiro = $conn->query("SELECT * FROM listado_productos WHERE retailer LIKE '%RIBEIRO%';");
$art_today_falabella = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%' AND retailer LIKE 'FALABELLA';");
$art_all_falabella = $conn->query("SELECT * FROM listado_productos WHERE retailer LIKE '%FALABELLA%';");
$art_today_anonima = $conn->query("SELECT * FROM listado_productos WHERE date LIKE '%$date%' AND retailer LIKE '%ANONIMA%';");
$art_all_anonima = $conn->query("SELECT * FROM listado_productos WHERE retailer LIKE '%ANONIMA%';");
$conn->close();


// Screenshots
    $i = 0; 
    $dir = '../mbot_screens/' . date('Y-m-d') . '/';
    if ($handle = opendir($dir)) {
        while (($file = readdir($handle)) !== false){
            if (!in_array($file, array('.', '..')) && !is_dir($dir.$file)) {
                $i++; }
        }
    }


// Screenshots Musimundo
$directory = '../mbot_screens/' . date('Y-m-d') . '/';
$files = glob($directory . 'musimundo_*');

if ( $files !== false )
{
  $musimundo_files = count( $files );
} else {
  $musimundo_files = "0";
}
$files2 = glob($directory . 'compumundo_*');
if ( $files !== false )
{
  $compumundo_files = count( $files2 );
}
else
{
  $compumundo_files = "0";
}
$files3 = glob($directory . 'fravega_*');
if ( $files !== false )
{
    $fravega_files = count( $files3 );
}
else
{
  $fravega_files = "0";
}
$files4 = glob($directory . 'garbarino_*');
if ( $files !== false )
{
    $garbarino_files = count( $files4 );
}
else
{
  $garbarino_files = "0";
}

$files5 = glob($directory . 'ribeiro_*');
if ( $files !== false )
{
  $ribeiro_files = count( $files5 );
}
else
{
   $ribeiro_files = "0";
}

$files6 = glob($directory . 'falabella_*');
if ( $files !== false )
{
  $falabella_files = count( $files6 );
}
else
{
   $falabella_files = "0";
}

$files7 = glob($directory . 'anonima_*');
if ( $files !== false )
{
  $anonima_files = count( $files6 );
}
else
{
   $anonima_files = "0";
}

?>


<div class="card">
  <img class="card-img-top" src="./assets/img/todos.png" alt="Ver todos"></a>
  <div class="card-body">
    <h5 class="card-title"><a href="./webs/ver.php?date=last">Ver todos los productos cargados hoy</a></h5>
    <div class="row">
      <div class="col-md-11 ml-5 mr-5 card">
        <h5>Estadísticas</h5>
        <form class="text-center" action="./resources/database/delete.php" method="get"> 
        <label class="form-control-label mb-0">Artículos encontrados hoy: <?php echo mysqli_num_rows($art_today); ?> </label><br />
        <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $i; ?></label><br />
        <label class="form-control-label mb-0">Artículos desde el origen de los tiempos: <?php echo mysqli_num_rows($art_all); ?></label><br /><br />
        </form>
      </div>  
	 </div>
  </div>
</div>
</br>


<div class="card-deck">
    <div class="card">
      <img class="card-img-top" src="./assets/img/musimundo.png" alt="Musimundo">
        <div class="card-body">
        <p class="card-text text-center">
          <a href="./webs/ver.php?retailer=MUSIMUNDO&date=last">Ver productos</a> <br />
          <a href="./webs/cats.php?retailer=MUSIMUNDO">Ver por categorías</a> <br />
          <a href='./webs/musimundo/musimundo.php' onclick="return confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')">Volver a capturar productos</a></p>
        <form class="text-center" method="get"> 
        <label class="form-control-label mb-0">Encontrados hoy: <?php echo mysqli_num_rows($art_today_musimundo); ?> </label><br />
        <label class="form-control-label mb-0">Total musimundo: <?php echo mysqli_num_rows($art_all_musimundo); ?>
        </label>
        <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $musimundo_files; ?></label><br />
        </form>
      </div>
    </div> 
    <div class="card">
    <img class="card-img-top" src="./assets/img/compumundo.png" alt="Compumundo">
    <div class="card-body">
      <p class="card-text text-center"><a href="./webs/ver.php?retailer=COMPUMUNDO&date=last">Ver productos</a> <br />
      <a href="./webs/cats.php?retailer=COMPUMUNDO">Ver por categorías</a> <br />
      <a href='./webs/compumundo/compumundo.php' onclick="return confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')">Volver a capturar productos</a></p>
      <form class="text-center" method="get"> 
      <label class="form-control-label mb-0">Encontrados hoy: <?php echo mysqli_num_rows($art_today_compumundo); ?> </label><br />
      <label class="form-control-label mb-0">Total compumundo: <?php echo mysqli_num_rows($art_all_compumundo); ?>
      </label>
      <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $compumundo_files; ?></label><br />
      <br /><br />
      </form>
    </div>
    </div> 
    <div class="card">
    <img class="card-img-top" src="./assets/img/fravega.png" alt="Fravega">
    <div class="card-body">
      <p class="card-text text-center"><a href="./webs/ver.php?retailer=FRAVEGA&date=last">Ver productos </a><br />
      <a href="./webs/cats.php?retailer=FRAVEGA">Ver por categorías</a> <br />
      <a href='./webs/fravega/fravega.php' onclick="return confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')">Volver a capturar productos</a></p>
      <form class="text-center" method="get"> 
      <label class="form-control-label mb-0">Encontrados hoy: <?php echo mysqli_num_rows($art_today_fravega); ?> </label><br />
      <label class="form-control-label mb-0">Total fravega: <?php echo mysqli_num_rows($art_all_fravega); ?>
      </label>
      <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $fravega_files; ?></label><br />
      <br /><br />
      </form>
    </div>
    </div> 
</div><br />
<div class="card-deck">
    <div class="card">
      <img class="card-img-top" src="./assets/img/garbarino.png" alt="Garbarino">
      <div class="card-body">
      <p class="card-text text-center"><a href="./webs/ver.php?retailer=GARBARINO&date=last">Ver productos</a> <br />
      <a href="./webs/cats.php?retailer=GARBARINO">Ver por categorías</a> <br />
      <a href='./webs/garbarino/garbarino.php' onclick="return confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')">Volver a capturar productos</a></p>
      <form class="text-center" method="get"> 
      <label class="form-control-label mb-0">Encontrados hoy: <?php echo mysqli_num_rows($art_today_garbarino); ?> </label><br />
      <label class="form-control-label mb-0">Total garbarino: <?php echo mysqli_num_rows($art_all_garbarino); ?>
      </label>
      <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $garbarino_files; ?></label><br />
      <br /><br />
      </form>
    </div>
    </div> 
    <div class="card">
    <img class="card-img-top" src="./assets/img/ribeiro.png" alt="Ribeiro">
    <div class="card-body">
      <p class="card-text text-center"><a href="./webs/ver.php?retailer=RIBEIRO&date=last">Ver productos </a><br />
      <a href="./webs/cats.php?retailer=RIBEIRO">Ver por categorías</a> <br />
      <a href='./webs/ribeiro/ribeiro.php' onclick="return confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')">Volver a capturar productos</a></p>
      <form class="text-center" method="get"> 
      <label class="form-control-label mb-0">Artículos encontrados hoy: <?php echo mysqli_num_rows($art_today_ribeiro); ?> </label><br />
      <label class="form-control-label mb-0">Artículos total ribeiro: <?php echo mysqli_num_rows($art_all_ribeiro); ?>
      </label>
      <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $ribeiro_files; ?></label><br />
      <br /><br />
      </form>
    </div>
    </div>
    <div class="card">
      <img class="card-img-top" src="./assets/img/falabella.png" alt="Falabella">
      <div class="card-body">
      <p class="card-text text-center"><a href="./webs/ver.php?retailer=FALABELLA&date=last">Ver productos </a><br />
      <a href="./webs/cats.php?retailer=FALABELLA">Ver por categorías</a> <br />
      <a href='./webs/falabella/falabella.php' onclick="return confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')">Volver a capturar productos</a></p>
      <form class="text-center" method="get"> 
      <label class="form-control-label mb-0">Artículos encontrados hoy: <?php echo mysqli_num_rows($art_today_falabella); ?> </label><br />
      <label class="form-control-label mb-0">Artículos total Falabella: <?php echo mysqli_num_rows($art_all_falabella); ?>
      </label>
      <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $falabella_files; ?></label><br />
      <br /><br />
      </form>
      </div>
    </div>
    <div class="card">
      <img class="card-img-top" src="./assets/img/laanonima.jpg" alt="La Anonima">
      <div class="card-body">
      <p class="card-text text-center"><a href="./webs/ver.php?retailer=ANONIMA&date=last">Ver productos </a><br />
      <a href="./webs/cats.php?retailer=LAANONIMA">Ver por categorías</a> <br />
      <a href='./webs/laanonima/laanonima.php' onclick="return confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')">Volver a capturar productos</a></p>
      <form class="text-center" method="get"> 
      <label class="form-control-label mb-0">Artículos encontrados hoy: <?php echo mysqli_num_rows($art_today_anonima); ?> </label><br />
      <label class="form-control-label mb-0">Artículos total La Anonima: <?php echo mysqli_num_rows($art_all_anonima); ?>
      </label>
      <label class="form-control-label mb-0">Capturas de imágen hoy: <?php  echo $anonima_files; ?></label><br />
      <br /><br />
      </form>
      </div>
    </div>
</div> 
<br />
