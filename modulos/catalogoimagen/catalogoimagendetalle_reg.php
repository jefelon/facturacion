<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("../catalogoimagen/cCatalogoimagen.php");
$oCatalogoimg = new cCatalogoimagen();


if ($_POST['action']=="insertar") {

	if (!empty($_POST['catimg_id'])) 
	{	

		$dts=$oCatalogoimg->registroAcceso($_POST['cat_id']);
		$dt = mysql_fetch_array($dts);
		//verificar si esta bloqueado

		if($dt['tb_catalogo_id']==$_POST['cat_id']){
			echo "<script type='text/javascript'>alert('Producto ya se encuentra registrado. Por favor Seleccione otro Producto');</script>";
		}
		else
		{
			$oCatalogoimg->insertar_det(		
			$_POST['catimg_id'],
			$_POST['cat_id']	
			);	

			echo 'Se registró Catalogo correctamente.';
		}		
		 
	}
	else
	{		
		echo 'Intentelo nuevamente.';		
	}
	
}

?>

