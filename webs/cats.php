<?php
include('../config.php');
include('../assets/header2.php');   
// Toma retailer. Realiza query.
if(isset($_GET['retailer'])) {
    $retailer = strtolower($_GET['retailer']);
    $ret_check = $retailer."_check";
    $result = mysqli_query($conn,"SELECT * FROM listado_screens WHERE $retailer != '' ORDER BY linea ASC LIMIT 500 OFFSET 1;"); // GROUP BY category
  } else {
    $result = mysqli_query($conn,"SELECT * FROM listado_screens;");
  }
?>
<div>
<h1>Categorías para <? echo $retailer; ?></h1>
<hr />
    <script language="JavaScript">
        function toggle(source) {
        checkboxes = document.getElementsByClassName('cat');
        for(var i=0, n=checkboxes.length;i<n;i++) {
            checkboxes[i].checked = source.checked;
        }
        }
    </script>
    <div>
    <a href='./add.php' class='btn btn-light' role='button'>Agregar categoría</a> 
    <a class='btn btn-light' role='button' onclick="document.getElementById('checkboxes').submit()">Guardar Cambios</a> 
    <hr />
    <label><input type="checkbox" onClick="toggle(this)" checked/> Seleccionar/Deseleccionar todo</label><br/>
    </div>
    <form id="checkboxes" action="./save.php?retailer=<?php echo $retailer;?>" method="POST">
    <ol class="categories">
        <?
        while($row = mysqli_fetch_array($result))
        {
            $linea = $row['linea'];
            $category = $row['category'];
            $link = $row[$retailer];
            $rets_check = $row[strtolower($ret_check)];

            if($rets_check == 1){
                $checked = "checked";
            } else {
                $checked = "unchecked";
            }
        echo "<li>
            <label>
            <input class='cat' type='checkbox' name='check_list[]' value='".$row['id']."' $checked>
            <span> <b>(".$linea.") </b>".$category." 
            <a href='#' data-toggle='modal' data-target='#exampleModal'>Editar</a> - 
            <a href='./".$retailer."/".$retailer.".php?cat=".$category."&link=".$link."'>Cargar</a></span></label></li>";
        } 
        ?>
    </ol>
    </form>
    <a href='../add.php' class='btn btn-light' role='button'>Agregar categoría</a> 
    <a class='btn btn-light' role='button' onclick="document.getElementById('checkboxes').submit()">Guardar Cambios</a> 

</div>

<!-- Button trigger modal -->
<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
  Launch demo modal
</button>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>

<?
include('../assets/footer.php');