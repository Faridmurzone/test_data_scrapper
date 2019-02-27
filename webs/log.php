<?php
include('../config.php');
include('../assets/header2.php');   

// Check GET
  if(isset($_GET['retailer'])) {
    $retailer = $_GET['retailer'];
  } else {
    $retailer = NULL;
  }
  if(isset($_GET['date'])) {
    $byDate = $_GET['date'];
  } else {
    $byDate = NULL;	
  }
  if(isset($_GET['view'])) {
    $view = $_GET['view'];
  } else {
    $view = NULL;	
  }
?>

<ul class="list-inline">
   <li class="list-inline-item">Por retailer:</li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=*">Todos</a></li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=compumundo">Compumundo</a></li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=falabella">Falabella</a></li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=fravega">Fravega</a></li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=garbarino">Garbarino</a></li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=laanonima">La Anonima</a></li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=musimundo">Musimundo</a></li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?retailer=ribeiro">Ribeiro</a></li>
</ul>
<ul class="list-inline">
   <li class="list-inline-item">Por fecha:</li>
   <li class="list-inline-item"><a class="social-icon text-xs-center" href="./log.php?date=<?php echo $date; ?>">Hoy</a></li>
</ul>

<?php
$results_array = array();

$itemsByRet = glob($log_directory.'*'.$retailer.'*');
$itemsByDate = glob($log_directory.'*'.$byDate.'*');
$substr = -1 * (strlen($retailer) + 8);
$retailer === '*' ? $substr++ : $substr; // Check if retailers are All and fix substr

if($retailer) {
  foreach($itemsByRet as $filename){
    $fileDate = substr(str_replace($log_directory, "", $filename), 0, $substr);
    echo '- Log del  <a href="./log.php?view='.$fileDate.$retailer.'_log.php">' . $fileDate, '</a><br>'; 
  }
} else if($view) {
  include('../cron/logs/'.$view);
} else if($byDate) {
  foreach($itemsByDate as $filename){
    $fileDate = substr(str_replace($log_directory, "", $filename), 0, $substr);
    echo '- Log del  <a href="./log.php?view='.$fileDate.$retailer.'_log.php">' . $fileDate, '</a><br>'; 
  }
}



?>