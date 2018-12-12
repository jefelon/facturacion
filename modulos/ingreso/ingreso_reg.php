<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cIngreso.php");
$oIngreso = new cIngreso();
/*require_once ("../talonario/cTalonario.php");
$oTalonario= new cTalonario();*/
require_once ("../venta/cVenta.php");
$oVenta = new cVenta();
require_once("../formatos/formato.php");

if($_POST['action_ingreso']=="insertar")
{
	if(!empty($_POST['hdd_emp_id']) and !empty($_POST['txt_ing_fec']))
	{

		//talonario numero documento
		/*	$dts= $oTalonario->correlativo($_POST['cmb_doc_id']);
				$dt = mysql_fetch_array($dts);
			$tal_id=$dt['tb_talonario_id'];
			$talser=$dt['tb_talonario_ser'];
			$talnum=$dt['tb_talonario_num'];
			$talfin=$dt['tb_talonario_fin'];
				mysql_free_result($dts);

			$largo=strlen($talfin);
			$talnum=str_pad($talnum,$largo, "0", STR_PAD_LEFT);
			
			$numdoc=$talser.'-'.$talnum;

			//actualizamos talonario
			$estado='ACTIVO';
			if($talnum==$talfin)$estado='INACTIVO';
			$numero=$talnum+1;
			$oTalonario->actualizar_correlativo($tal_id,$numero,$estado);*/

			$numdoc=strip_tags($_POST['txt_ing_numdoc']);

		$xac=1;
		$mon_id=1;

		$oIngreso->insertar(
			$_POST['hdd_ing_usureg'],
			$_POST['hdd_ing_usumod'],
			$xac,
			fecha_mysql($_POST['txt_ing_fec']),
			$_POST['cmb_doc_id'],
			$numdoc,
            strip_tags($_POST['txt_ing_det']),
			moneda_mysql($_POST['txt_ing_imp']),
			$_POST['cmb_ing_est'],
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['hdd_cli_id'],
			$_POST['cmb_caj_id'],
			$mon_id,
			$mod_id,
			$modide,
			$_POST['hdd_emp_id']
		);

		//ultimo ingreso
			
			$dts=$oIngreso->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$ing_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		/*if($_POST['hdd_ven_id']>0)
		{
			//INFO VENTA
			$dts= $oVenta->mostrarUno($_POST['hdd_ven_id']);
			$dt = mysql_fetch_array($dts);
				
				$ven_imp		=$dt['tb_venta_imp'];
				
				//$caj_id		=$dt['tb_caja_id'];
				
				//$ven_est		=$dt['tb_venta_est'];
				
			mysql_free_result($dts);

			//MODIFICAR ESTADO VENTA
		    $estado="'1'";
		    $rws1=$oIngreso->mostrar_por_venta($_POST['hdd_ven_id'],$estado);
		    $filas= mysql_num_rows($rws1);
		    while($rw1 = mysql_fetch_array($rws1)){
		      $ingreso_total+=$rw1['tb_ingreso_imp'];
		    }
		    mysql_free_result($rws1);

		    if($ven_imp==$ingreso_total)
		    {
		    	//$oVenta->modificar_campo($_POST['hdd_ven_id'],$_POST['hdd_ing_usumod'],'est','1');	
		    }
		}*/

		if($_POST['chk_imprimir']==1)$data['ing_act']='imprimir';
		$data['ing_id']=$ing_id;
		$data['ing_msj']='Se registró ingreso correctamente.';
	}
	else
	{
		$data['ing_msj']='Intentelo nuevamente.';
	}
	echo json_encode($data);
}

if($_POST['action_ingreso']=="editar")
{
	if(!empty($_POST['txt_ing_fec']) and !empty($_POST['cmb_cue_id']))
	{
		$mon_id=1;

		$oIngreso->modificar(
			$_POST['hdd_ing_id'],
			$_POST['hdd_ing_usumod'],
			fecha_mysql($_POST['txt_ing_fec']),
            strip_tags($_POST['txt_ing_det']),
			moneda_mysql($_POST['txt_ing_imp']),
			$_POST['cmb_ing_est'],
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['cmb_caj_id'],
			$mon_id
		);
		
		/*
		if($_POST['hdd_ven_id']>0)
		{
			//INFO VENTA
			$dts= $oVenta->mostrarUno($_POST['hdd_ven_id']);
			$dt = mysql_fetch_array($dts);
				
				$ven_imp		=$dt['tb_venta_imp'];
				
				//$caj_id		=$dt['tb_caja_id'];
				
				//$ven_est		=$dt['tb_venta_est'];
				
			mysql_free_result($dts);

			//MODIFICAR ESTADO VENTA
		    $estado="'1'";
		    $rws1=$oIngreso->mostrar_por_venta($_POST['hdd_ven_id'],$estado);
		    $filas= mysql_num_rows($rws1);
		    while($rw1 = mysql_fetch_array($rws1)){
		      $ingreso_total+=$rw1['tb_ingreso_imp'];
		    }
		    mysql_free_result($rws1);

		    if($ven_imp==$ingreso_total)
		    {
		    	//$oVenta->modificar_campo($_POST['hdd_ven_id'],$_POST['hdd_ing_usumod'],'est','1');	
		    }
		}*/

		$data['ing_msj']='Se registró ingreso correctamente.';
		
	}
	else
	{
		$data['ing_msj']='Intentelo nuevamente.';
	}
	echo json_encode($data);
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['ing_id']))
	{
		//$cst1 = $oIngreso->verifica_ingreso_tabla($_POST['ing_id'],'tb_ingreso');
		//$rst1= mysql_num_rows($cst1);
		//if($rst1>0)$msj1=' - Ingresos';
		
		/*if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			$oIngreso->modificar_campo($_POST['ing_id'],$_SESSION['usuario_id'],'xac','0');
			echo 'Se envió a la papelera correctamente.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>