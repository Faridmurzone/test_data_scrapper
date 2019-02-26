<?php
// DB
include('../../config.php');
$command = 'mysqldump --all-databases --single-transaction --quick --lock-tables=false > full-backup-$(date +%F).sql -u root -p';
exec($command,$output);
if($output != 0) {
	echo 'Error during backup';
} else {
	echo 'Database saved';
}
?>
