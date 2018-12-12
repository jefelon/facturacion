<?php
require_once ("../../config/Cado.php");
require_once("../conductor/cConductor.php");
$oConductor = new cConductor();

if($_POST['action_conductor']=="insertar")
{
	if(!empty($_POST['txt_con_doc']))
	{
		$oConductor->insertar($_POST['rad_con_tip'], $_POST['txt_con_nom'], $_POST['txt_con_doc'], $_POST['txt_con_dir'], $_POST['txt_con_tel'], $_POST['txt_con_ema'], $_POST['txt_con_lic'], $_POST['txt_con_cat'], $_POST['cmb_con_tra']);
		
			$dts=$oConductor->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$con_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		$data['con_id']=$con_id;
		$data['con_msj']='Se registró conductor correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_conductor']=="editar")
{
	if(!empty($_POST['txt_con_doc']))
	{
		$oConductor->modificar($_POST['hdd_con_id'], $_POST['rad_con_tip'], $_POST['txt_con_nom'], $_POST['txt_con_doc'], $_POST['txt_con_dir'], $_POST['txt_con_tel'], $_POST['txt_con_ema'], $_POST['txt_con_lic'], $_POST['txt_con_cat'], $_POST['cmb_con_tra']);
		
		$data['con_msj']='Se registró conductor correctamente.';
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['con_id']))
	{
		$cst1 = $oConductor->verifica_conductor_tabla($_POST['con_id'],'tb_guia');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Guia de Remision';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oConductor->eliminar($_POST['con_id']);
			echo 'Se eliminó conductor correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action'] == "obtener_datos"){
	if(!empty($_POST['con_id'])){
		$rs = $oConductor->mostrarUno($_POST['con_id']);		
		$fila = mysql_fetch_array($rs);
			$data['direccion'] = $fila['tb_conductor_dir'];
			$data['documento'] = $fila['tb_conductor_doc'];			
			$data['nombre'] = $fila['tb_conductor_nom'];
		
		echo json_encode($data);
	}else{
		echo "Error en la obtención de datos del Conductor!";	
	}
}
?>