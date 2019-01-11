<?php 
require_once(LIB . '/simple_html_dom.php');
require_once(LIB.'/links.php');
/*error_reporting(0);
ignore_user_abort(true);
set_time_limit(290);
*/
ini_set("display_errors", "1");
error_reporting(E_ALL);
ini_set('memory_limit', '-1');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.22.1/locale/ar.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/js/tempusdominus-bootstrap-4.min.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.0.0-alpha14/css/tempusdominus-bootstrap-4.min.css" />
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js" integrity="sha384-cs/chFZiN24E4KMATLdqdvsezGxaGsi4hLGOzlXwp5UZB1LY//20VyM2taTB4QvJ" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.0/js/bootstrap.min.js" integrity="sha384-uefMccjFJAIv6A+rW+L4AHf99KvxDjWSu1z9VI8SKNVmz4sk7buKt/6v9KI65qnm" crossorigin="anonymous"></script>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-118964129-1"></script>
	<script>
  	window.dataLayer = window.dataLayer || [];
  	function gtag(){dataLayer.push(arguments);}
  	gtag('js', new Date());
  	gtag('config', 'UA-118964129-1');
	</script>
	<script>
	setInterval(function() {
    $('.text-white').fadeOut('slow');
	}, 15000);
	</script>
</head>  
<body>

<div class="container-fluid col-sm-10 offset-1">
<br />
   <div class="row"><img src="/mbot/assets/img/logo.png" /></div><hr />

    <h1>Productos encontrados</h1>
	<hr />
	<div class="row">
		<div class="table-responsive">
		<table class="table table-striped" id="myTable">
		  <thead>
		    <tr>
		      <th scope="col">#</th>
  		      <th scope="col">IMG</th>
		      <th scope="col">Retailer</th>
		      <th scope="col">Categoría</th>
		      <th scope="col">Título</th>
			  <th scope="col">Marca</th>
			  <th scope="col">Modelo</th>
		      <th scope="col">Precio de Lista</th>
		      <th scope="col">Precio oferta</th>
		      <th scope="col">Screenshot</th>
		      <th scope="col">Link</th>
		      <th scope="col">Fecha</th>
		      <th scope="col">Combo</th>
		    </tr>
		  </thead>
		  <tbody>
