<?php
include('../config.php');
include('../assets/header.php');   
?>

<script>
function myFunction() {
  // Declare variables 
  var input, filter, table, tr, td, i;
  input = document.getElementById("myInput");
  filter = input.value.toUpperCase();
  table = document.getElementById("myTable");
  tr = table.getElementsByTagName("tr");

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[3];
    td2 = tr[i].getElementsByTagName("td")[5];
    if (td || td2) {
      if (td.innerHTML.toUpperCase().indexOf(filter) > -1 || td2.innerHTML.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    } 
  }
}
</script>
<style>
#myInput {
    background-image: url('/css/searchicon.png'); /* Add a search icon to input */
    background-position: 10px 12px; /* Position the search icon */
    background-repeat: no-repeat; /* Do not repeat the icon image */
    width: 100%; /* Full-width */
    font-size: 16px; /* Increase font-size */
    padding: 12px 20px 12px 40px; /* Add some padding */
    border: 1px solid #ddd; /* Add a grey border */
    margin-bottom: 12px; /* Add some space below the input */
}

#myTable {
    border-collapse: collapse; /* Collapse borders */
    width: 100%; /* Full-width */
    border: 1px solid #ddd; /* Add a grey border */
    font-size: 18px; /* Increase font-size */
}

#myTable th, #myTable td {
    text-align: left; /* Left-align text */
    padding: 12px; /* Add padding */
}

#myTable tr {
    /* Add a bottom border to all table rows */
    border-bottom: 1px solid #ddd; 
}

#myTable tr.header, #myTable tr:hover {
    /* Add a grey background color to the table header and on hover */
    background-color: #f1f1f1;
}</style>
  
    <div class="table-responsive">
      <a href='../index.php' class='btn btn-light' role='button'>Volver al index</a> 
      <!-- Búsqueda avanzada -->
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#buscar" data-whatever="@mdo">Búsqueda avanzada</button>

<div class="modal fade" id="buscar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Búsqueda</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Artículo:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Modelo:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Marca:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Retailer:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Fecha:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Buscar</button>
      </div>
    </div>
  </div>
</div>
      <!-- Fin de búsqueda avanzada -->
      <!-- Comparación -->
<button type="button" class="btn btn-warning" data-toggle="modal" data-target="#comparar" data-whatever="@mdo">Comparar en el tiempo</button>

<div class="modal fade" id="comparar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Comparar un artículo</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form>
          <div class="form-group">
            <label for="recipient-name" class="col-form-label">Artículo:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Modelo:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
<!-- TIME PICKER -->
<div class="container">
    <div class='col-md-5'>
        <div class="form-group">
           <div class="input-group date" id="datetimepicker7" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker7"/>
                <div class="input-group-append" data-target="#datetimepicker7" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
    <div class='col-md-5'>
        <div class="form-group">
           <div class="input-group date" id="datetimepicker8" data-target-input="nearest">
                <input type="text" class="form-control datetimepicker-input" data-target="#datetimepicker8"/>
                <div class="input-group-append" data-target="#datetimepicker8" data-toggle="datetimepicker">
                    <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function () {
        $('#datetimepicker7').datetimepicker();
        $('#datetimepicker8').datetimepicker({
            useCurrent: false
        });
        $("#datetimepicker7").on("change.datetimepicker", function (e) {
            $('#datetimepicker8').datetimepicker('minDate', e.date);
        });
        $("#datetimepicker8").on("change.datetimepicker", function (e) {
            $('#datetimepicker7').datetimepicker('maxDate', e.date);
        });
    });
</script>
<!-- TIME PICKER -->
        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary">Comparar</button>
      </div>
    </div>
  </div>
</div><br />
      <!-- Comparación -->




      <input class="mt-3" type="text" id="myInput" onkeyup="myFunction()" placeholder="Busqueda rápida por nombre o modelo.."></div>

<!-- VER POR RETAILER --> 
          <?php
          // Check connection
          if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }

          // Toma Retailer y define cantidad
          if(isset($_GET['retailer'])) {
          $retailer = $_GET['retailer'];
          } else {
          $retailer = '';
          }
          $cantidad = 0;
          // Toma date y la convierte si es Last. Realiza querys
          if(isset($_GET['date'])) {
            $date = $_GET['date'];
            if($date = "last") {
              $date = date('Y-m-d');
            }
            $result = mysqli_query($conn,"SELECT * FROM listado_productos WHERE retailer LIKE '%$retailer%' AND date LIKE '%$date%';");
          } else {
            $result = mysqli_query($conn,"SELECT * FROM listado_productos WHERE retailer LIKE '%$retailer%';");
          }


          while($row = mysqli_fetch_array($result))
          {
            $cat_id_get = $row['category'];
            $cat_id_sql = mysqli_query($conn,"SELECT * FROM listado_screens WHERE subcat LIKE '$cat_id_get' LIMIT 1;");
            $cat_id = $cat_id_sql->fetch_assoc();
            if($row['combo'] = 1) { $combo = "No"; } else { $combo = "Si"; }
            echo "
            <tr>
              <th scope='row'>" . $cantidad++ . "</th>
              <td><img src='" . $row['imagen'] . "' width='50px' /></td>
              <td>" . $row['retailer'] . "</td>
              <td>" . $row['category'] . "</td>
              <td>" . $row['title'] . "</td>
              <td>" . $row['marca'] . "</td>
              <td>" . $row['modelo'] . "</td>
              <td>" . $row['precio_lista'] . "</td>
              <td>" . $row['precio_oferta'] . "</td>
              <td><a target='_blank' href='http://mrt.com.ar/mbot/screenshots/" . $row['date'] . "/" . strtolower($row['retailer']) . "_" . $cat_id['id'] .".png'>Screenshot </td>
              <td><a href=".$row['link'].">Link</a></td>
              <td>" . $row['date'] . "</td>
              <td>" . $combo . "</td>
              <td></tr>";
          }

  include('../assets/footer.php');