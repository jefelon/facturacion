<?php
require_once ("../../config/Cado.php");
require_once("cLetras.php");
$oLetras = new cLetras();

if($_POST['action_letra']=="insertar")
{
	if(!empty($_POST['txt_mar_nom']))
	{
		$oLetras->insertar(strip_tags($_POST['txt_mar_nom']));
		
			$dts=$oLetras->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$mar_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['mar_id']=$mar_id;
		$data['mar_msj']='Se registró letra correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_letra']=="editar")
{
	if(!empty($_POST['txt_mar_nom']))
	{
		$oLetras->modificar($_POST['hdd_mar_id'],strip_tags($_POST['txt_mar_nom']));
		
		$data['mar_msj']='Se registró letra correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$cst1 = $oLetras->verifica_letra_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oLetras->eliminar($_POST['id']);
			echo 'Se eliminó letra correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>