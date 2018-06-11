<?php
require_once ("../../config/Cado.php");
require_once("cCaja.php");
$oMarca = new cMarca();

if($_POST['action_marca']=="insertar")
{
	if(!empty($_POST['txt_mar_nom']))
	{
		$oMarca->insertar(strip_tags($_POST['txt_mar_nom']));
		
			$dts=$oMarca->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$mar_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['mar_id']=$mar_id;
		$data['mar_msj']='Se registró marca correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_marca']=="editar")
{
	if(!empty($_POST['txt_mar_nom']))
	{
		$oMarca->modificar($_POST['hdd_mar_id'],strip_tags($_POST['txt_mar_nom']));
		
		$data['mar_msj']='Se registró marca correctamente.';
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
		$cst1 = $oMarca->verifica_marca_tabla($_POST['id'],'tb_producto');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Producto';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oMarca->eliminar($_POST['id']);
			echo 'Se eliminó marca correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>