<?php
  include('../config.php');
  include('../assets/header2.php');   
  // Check GET
  if(isset($_GET['retailer'])) {
    $retailer = $_GET['retailer'];
  } 
  if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM listado_screens WHERE id = $id");
  } else {
    $id = NULL;	
    $result = mysqli_query($conn, "SELECT * FROM listado_screens WHERE id = 1");
  }

  if(isset($_GET['edit'])) {
    $link = $_POST['link'];
    $id = $_POST['id'];
    $retailer = $_REQUEST['retailer'];
    $sql = "UPDATE listado_screens SET $retailer = '$link' WHERE id = $id";
    if ($conn->query($sql) === TRUE) {
      echo "Se actualizó el valor del link. <a href='./cats.php?retailer=".$retailer."'>Volver</a>";
    } 
    echo $conn->error;

  } else {
  while($row = mysqli_fetch_array($result))
  {
    echo '<h2>';
    echo $row['category'] . ' de ' . $retailer;
    echo '</h2>';
?>


<form action="editcat.php?edit" method="post">
  <div class="form-group">
    <label for="idInput">Id</label>
    <input class="form-control" type="text" name="id" id="idInput" value="<?php echo $id; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="retInput">Retailer</label>
    <input class="form-control" type="text" name="retailer" id="retInput" value="<?php echo $retailer; ?>" readonly>
  </div>
  <div class="form-group">
    <label for="linkInput">Link</label>
    <input class="form-control" type="text" name="link" id="linkInput" value="<?php echo $row[$retailer]; ?>">
  </div>
  <button type="submit">Guardar</button>
</form>



<?php  
  }
}
  include('../assets/footer.php');