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
  $log_filename = date('Y-m-d').$retailer.'_log.php';
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
    <!-- <a href='./add.php' class='btn btn-light' role='button'>Agregar categoría</a>  -->
    <a href='./log.php?view=<?php echo $log_filename ?>' class='btn btn-light' role='button'>Ver log de última carga</a> 
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
            <a href='./editcat.php?retailer=".$retailer."&id=".$row['id']."'>Editar</a> - 
            <a href='./".$retailer."/".$retailer.".php?cat=".$category."&link=".$link."'>Cargar</a></span></label></li>";
        } 
        ?>
    </ol>
    </form>
    <!-- <a href='../add.php' class='btn btn-light' role='button'>Agregar categoría</a>  -->
    <a class='btn btn-light' role='button' onclick="document.getElementById('checkboxes').submit()">Guardar Cambios</a> 

</div>

<?
include('../assets/footer.php');