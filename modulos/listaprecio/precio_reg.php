<?php
require_once ("../../config/Cado.php");
require_once("cPrecio.php");
$oPrecio = new cPrecio();

if($_POST['action_precio']=="insertar")
{
	if(!empty($_POST['txt_precio_nom']))
	{
        $oPrecio->insertar(strip_tags($_POST['txt_precio_nom']));
		
			$dts=$oPrecio->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$precio_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['precio_id']=$precio_id;
		$data['precio_msj']='Se registró la lista de precio correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_precio']=="editar")
{
	if(!empty($_POST['txt_precio_nom']))
	{
        $oPrecio->modificar($_POST['hdd_precio_id'],strip_tags($_POST['txt_precio_nom']));
		
		$data['precio_msj']='Se modificó la lista de precio correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['precio_id']))
	{
		$cst1 = $oPrecio->verifica_precio_tabla($_POST['precio_id'],'tb_cliente');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Cliente';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
            $oPrecio->eliminar($_POST['precio_id']);
			echo 'Se eliminó la lista de precio correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>