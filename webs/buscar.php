<?php
include('../config.php');
include('../assets/header.php');   
?>
  
<div class="table-responsive">
<a href='../index.php' class='btn btn-light' role='button'>Volver al index</a> 
      <!-- Búsqueda avanzada -->
<button type="button" class="btn btn-dark" data-toggle="modal" data-target="#buscar" data-whatever="@mdo">Realizar otra búsqueda</button>
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
          <div class="form-group">
            <label for="message-text" class="col-form-label">Fecha de inicio:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
          <div class="form-group">
            <label for="message-text" class="col-form-label">Fecha final:</label>
            <input type="text" class="form-control" id="recipient-name">
          </div>
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


<!-- VER POR BUSQUEDA --> 
          <?php
          // Check connection
          if (mysqli_connect_errno())
          {
          echo "Failed to connect to MySQL: " . mysqli_connect_error();
          }

          if(isset($_GET['date'])) {
          $retailer = $_GET['date'];
          } else {
          $retailer = '';
          }

          $cantidad = 0;
          $result = mysqli_query($conn,"SELECT * FROM listado_productos WHERE retailer LIKE '%$retailer%';");



          while($row = mysqli_fetch_array($result))
          {
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
              <td><a href=".$row['link'].">Link</a></td>
              <td>" . $row['date'] . "</td>
              <td>" . $combo . "</td>
              <td>";
          }

  include('../assets/footer.php');