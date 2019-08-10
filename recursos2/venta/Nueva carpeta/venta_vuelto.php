<?php 
	require_once ("../formatos/formato.php");
	$total = $_POST['total'];
	$importe = $_POST['importe'];	
	$vuelto = moneda_mysql($importe) - moneda_mysql($total);
	echo formato_money($vuelto);
?>