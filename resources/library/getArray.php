<?php
if(isset($_GET['fromArray'])) {
	$fromArray = $_GET['fromArray'];
	$screenshotID = $fromArray + 1;
} else {
	$screenshotID = 1;
	$fromArray = $defaultFromArray;
}
if(isset($_GET['toArray'])) {
	$toArray = $_GET['toArray'];
} else {
	$toArray = $defaultToArray;	
}