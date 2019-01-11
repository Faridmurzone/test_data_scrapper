<?php 

include('../config.php');
echo "<table><th>";
          $date = date('Y-m-d');
          $result = mysqli_query($conn,"SELECT id, link FROM listado_productos WHERE retailer LIKE '%falabella%' AND date LIKE '%$date%';");
          while($row = mysqli_fetch_array($result))
          {
            echo "
            <tr>
              <th scope='row'>" . $cantidad++ . "</th>
              <td>" . $row['id'] . "</td>
              <td>" . $row['link'] . "</td>
              <td></tr>";
          }
echo "</th></table>";
?>

<!-- SELECT id, link FROM listado_productos WHERE retailer LIKE '%falabella%' AND date LIKE '%$date%' -->