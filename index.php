<?php
ini_set("display_errors", "1");
error_reporting(E_ALL);
ini_set('memory_limit', '-1');


require_once('./config.php');
include(ASSETS . 'header2.php'); 
include('./assets/stats.php'); 

?>


<div class="card mt-5">
  <div class="card-body">
    <h2 class="card-title">Administración</h2>
    <p class="alert alert-danger" role="alert">Advertencia: Desde la administración se pueden borrar y modificar valores que pueden ser irreversibles.</p>
    <p class="card-text"><small class="text-muted"></small></p>
    <div class="row"><div class="col-md-5 ml-5 mr-5 card">
      <h5>Borrar</h5>
      <form class="text-center" action="./resources/database/delete.php" method="get"> 
      <label class="form-control-label mb-0">Retailer: </label><br /><input type="text" placeholder="Ejemplo: FRAVEGA" name="retailer" type="text"><br /><br />
      <label class="form-control-label mb-0">Fecha (YYYY-MM-DD): </label><br /><input type="text" placeholder="Ejemplo: 2018-05-20"name="date" type="text"><br><br />
      <button class="btn btn-danger" type="submit">Borrar</button><br /><br />
      </form>
    </div>  
    <div class="col-md-5 ml-5 card">
      <h5>Backup</h5>
      <form class="text-center" name="export" method="post" action="./resources/database/exportdb.php">
      <button class="btn btn-info" type="submit">Exportar base de datos</button><br /><br />
      </form>
      </div></div><br />
  </div><br />
</div><br />

<script language="JavaScript" type="text/JavaScript">
function elegir() {
if (confirm('Estás seguro que deseas volver a cargar los productos de hoy? No se sobreescribirán los que ya se hayan cargado más temprano.')) {
alert('Sí, cargar');
} else {
alert('No cargar');
}
}
</script>

<?php
include(ASSETS . 'footer.php'); 

