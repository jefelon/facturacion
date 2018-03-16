<?php
require_once ("../../config/Cado.php");
require_once("../formula/cFormula.php");
$oFormula = new cFormula();

if($_POST['action_formula']=="insertar")
{
	if(!empty($_POST['txt_for_ele']))
	{
		$oFormula->insertar($_POST['txt_for_ele'], $_POST['txt_for_ide'], $_POST['txt_for_dat'], $_POST['txt_for_des']);
		
			$dts=$oFormula->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$for_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['for_id']=$for_id;
		$data['for_msj']='Se registró formula correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_formula']=="editar")
{
	if(!empty($_POST['txt_for_ele']))
	{
		$oFormula->modificar($_POST['hdd_for_id'],$_POST['txt_for_ele'], $_POST['txt_for_ide'], $_POST['txt_for_dat'], $_POST['txt_for_des']);
		
		$data['for_msj']='Se registró formula correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['for_id'])){
		
		$oFormula->eliminar($_POST['for_id']);
		echo 'Se eliminó formula correctamente.';
		
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="consultar_dato_formula"){			
	$rs = $oFormula->consultar_dato_formula($_POST['ide']);
	$dt = mysql_fetch_array($rs);
	$dato = $dt['tb_formula_dat'];
	mysql_free_result($rs);
	$data['dato'] = $dato;
	echo json_encode($data);
}

?>