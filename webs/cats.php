<?php
include('../config.php');
include('../assets/header2.php');   
// Toma retailer. Realiza query.
if(isset($_GET['retailer'])) {
    $retailer = $_GET['retailer'];
    $ret_check = $retailer."_check";
    $result = mysqli_query($conn,"SELECT id, $retailer, $ret_check, linea, category FROM listado_screens WHERE $retailer != '' ORDER BY linea ASC LIMIT 500 OFFSET 1;"); // GROUP BY category
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
    <a href='../add.php' class='btn btn-light' role='button'>Agregar categoría</a> 
    <a class='btn btn-light' role='button' onclick="document.getElementById('checkboxes').submit()">Guardar Cambios</a> 
    <hr />
    <label><input type="checkbox" onClick="toggle(this)" checked/> Seleccionar/Deseleccionar todo</label><br/>
    </div>
    <form id="checkboxes" action="./save.php?retailer=<?php echo $retailer;?>" method="POST">
    <ol class="categories">
        <?
        while($row = mysqli_fetch_array($result))
        {
            if($row[$ret_check] == 1){
                $checked = "checked";
            } else {
                $checked = "unchecked";
            }
        echo "<li><label><input class='cat' type='checkbox' name='check_list[]' value='".$row['id']."' $checked><span> <b>(".$row['linea'].") </b>".$row['category']." </span></label></li>";
        } 
        ?>
    </ol>
    </form>
    <a href='../add.php' class='btn btn-light' role='button'>Agregar categoría</a> 
    <a href='../add.php' class='btn btn-light' role='button'>Guardar Cambios</a> 

</div>

<?
include('../assets/footer.php');