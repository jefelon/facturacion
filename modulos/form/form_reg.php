<?php
require_once ("../../config/Cado.php");
require_once("cForm.php");
$oForm = new cForm();

if($_POST['action_form']=="insertar")
{
	if(!empty($_POST['txt_for_ele']))
	{
		$oForm->insertar($_POST['txt_for_ele'], $_POST['txt_for_cat'], $_POST['txt_for_des'], $_POST['txt_for_ord']);
		
			$dts=$oForm->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$for_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['for_id']=$for_id;
		$data['for_msj']='Se registró formulario correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_form']=="editar")
{
	if(!empty($_POST['txt_for_ele']))
	{
		$oForm->modificar($_POST['hdd_for_id'],$_POST['txt_for_ele'], $_POST['txt_for_cat'], $_POST['txt_for_des'], $_POST['txt_for_ord']);
		
		$data['for_msj']='Se registró formulario correctamente.';
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
		
		$oForm->eliminar($_POST['for_id']);
		echo 'Se eliminó formulario correctamente.';
		
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>