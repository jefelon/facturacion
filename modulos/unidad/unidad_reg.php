<?php
require_once ("../../config/Cado.php");
require_once("cUnidad.php");
$oUnidad = new cUnidad();

if($_POST['action_unidad']=="insertar")
{
	if(!empty($_POST['txt_uni_nom']))
	{
		$uni_tip=$_POST['cmb_uni_tip'];
		if($_POST['cmb_uni_tip']=="")$uni_tip=$_POST['hdd_uni_tip'];
		
		$oUnidad->insertar(strip_tags($_POST['txt_uni_abr']), strip_tags($_POST['txt_uni_nom']), $uni_tip);
		
			$dts=$oUnidad->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$uni_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		$data['uni_id']=$uni_id;
		$data['uni_msj']='Se registró unidad correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_unidad']=="editar")
{
	if(!empty($_POST['txt_uni_nom']))
	{
		$oUnidad->modificar($_POST['hdd_uni_id'],strip_tags($_POST['txt_uni_abr']),strip_tags($_POST['txt_uni_nom']), $_POST['cmb_uni_tip']);
		
		$data['uni_msj']='Se registró unidad correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['id']))
	{
		$cst1 = $oUnidad->verifica_unidad_tabla($_POST['id'],'tb_catalogo','tb_unidad_id_bas');
		$rst1= mysql_num_rows($cst1);
		//if($rst1>0)$msj1=' - Catálogo';
		
		$cst2 = $oUnidad->verifica_unidad_tabla($_POST['id'],'tb_catalogo','tb_unidad_id_equ');
		$rst2= mysql_num_rows($cst2);
		if($rst1>0 or $rst2>0)$msj2=' Catálogo';

		if($rst1>0 or $rst2>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.$msj2.".";
		}
		else
		{
			$oUnidad->eliminar($_POST['id']);
			echo 'Se eliminó unidad correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>