<?php
# Fill our vars and run on cli
# $ php -f db-connect-test.php

$dbhost = "localhost";
$dbuser = "mbot";
$dbpass = "Sismrt_2013";
$dbname = "mbot";

$link = mysqli_connect($dbhost, $dbuser, $dbpass) or die("No se pudo conectar a la db '$dbhost'");
mysqli_select_db($link, $dbname) or die("No se pudo abrir la db '$dbname'");
$test_query = "SHOW TABLES FROM $dbname";
$result = mysqli_query($link, $test_query);
$tblCnt = 0;
while($tbl = mysqli_fetch_array($result)) {
  $tblCnt++;
  #echo $tbl[0]."<br />\n";
}
if (!$tblCnt) {
  echo "No hay tablas.<br />\n";
} else {
  echo "Hay $tblCnt tablas. Funciona OK.<br />\n";
}
