<?php
require_once ("../../config/Cado.php");
require_once("cLote.php");
$oLote = new cLote();

if($_POST['action_lote']=="insertar")
{
	if(!empty($_POST['txt_lot_nom']))
	{
		$oLote->insertar(strip_tags($_POST['txt_lot_nom']));
		
			$dts=$oLote->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$lot_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['lot_id']=$lot_id;
		$data['lot_msj']='Se registró lote correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

if($_POST['action_lote']=="editar")
{
	if(!empty($_POST['txt_lot_nom']))
	{
		$oLote->modificar($_POST['hdd_lot_id'],strip_tags($_POST['txt_lot_nom']));
		
		$data['lot_msj']='Se registró lote correctamente.';
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
		$cst1 = $oLote->verifica_lote_tabla($_POST['id'],'tb_venta');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' - Venta';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oLote->eliminar($_POST['id']);
			echo 'Se eliminó lote correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>