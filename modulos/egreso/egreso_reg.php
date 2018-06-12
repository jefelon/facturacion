<?php
require_once ("../../config/Cado.php");

require_once ("cEgreso.php");
$oEgreso = new cEgreso();
//require_once ("../talonario/cTalonario.php");
//$oTalonario= new cTalonario();
require_once ("../gasto/cGasto.php");
$oGasto = new cGasto();
require_once("../formatos/formato.php");

if($_POST['action_egreso']=="insertar")
{
	if(!empty($_POST['hdd_emp_id']) and !empty($_POST['txt_egr_fec']))
	{

		//talonario numero documento
		/*$dts= $oTalonario->correlativo($_POST['cmb_doc_id']);
			$dt = mysql_fetch_array($dts);
		$tal_id=$dt['tb_talonario_id'];
		$talser=$dt['tb_talonario_ser'];
		$talnum=$dt['tb_talonario_num'];
		$talfin=$dt['tb_talonario_fin'];
			mysql_free_result($dts);

		if($tal_id>0)
		{
			$largo=strlen($talfin);
			$talnum=str_pad($talnum,$largo, "0", STR_PAD_LEFT);
			
			$numdoc=$talser.'-'.$talnum;

			//actualizamos talonario
			$estado='ACTIVO';
			if($talnum==$talfin)$estado='INACTIVO';
			$numero=$talnum+1;
			$oTalonario->actualizar_correlativo($tal_id,$numero,$estado);
		}
		else
		{
			$numdoc=$_POST['txt_egr_numdoc'];
		}*/

		$numdoc=$_POST['txt_egr_numdoc'];

		$xac=1;
		$mon_id=1;

		$oEgreso->insertar(
			$_POST['hdd_egr_usureg'],
			$_POST['hdd_egr_usumod'],
			$xac,
			fecha_mysql($_POST['txt_egr_fec']),
			$_POST['cmb_doc_id'],
			$numdoc,
			strip_tags($_POST['txt_egr_det']),
			moneda_mysql($_POST['txt_egr_imp']),
			$_POST['cmb_egr_est'],
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['hdd_pro_id'],
			$_POST['cmb_caj_id'],
			$mon_id,
			$mod_id,
			$modide,
			$_POST['hdd_emp_id']
		);

		//ultimo egreso
			
			$dts=$oEgreso->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$egr_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		/*
		if($_POST['hdd_gas_id']>0)
		{
			//INFO GASTO
			$dts= $oGasto->mostrarUno($_POST['hdd_gas_id']);
			$dt = mysql_fetch_array($dts);
				
				$gas_imp		=$dt['tb_gasto_imp'];
				
				//$caj_id		=$dt['tb_caja_id'];
				
				//$gas_est		=$dt['tb_gasto_est'];
				
			mysql_free_result($dts);

			//MODIFICAR ESTADO GASTO
		    $estado="'1'";
		    $rws1=$oEgreso->mostrar_por_gasto($_POST['hdd_gas_id'],$estado);
		    $filas= mysql_num_rows($rws1);
		    while($rw1 = mysql_fetch_array($rws1)){
		      $egreso_total+=$rw1['tb_egreso_imp'];
		    }
		    mysql_free_result($rws1);

		    if($gas_imp==$egreso_total)
		    {
		    	//$oGasto->modificar_campo($_POST['hdd_gas_id'],$_POST['hdd_egr_usumod'],'est','1');	
		    }
		}*/

		if($_POST['chk_imprimir']==1)$data['egr_act']='imprimir';
		$data['egr_id']=$egr_id;
		$data['egr_msj']='Se registró egreso correctamente.';
		
	}
	else
	{
		$data['egr_msj']='Intentelo nuevamente.';
	}
	echo json_encode($data);
}

if($_POST['action_egreso']=="editar")
{
	if(!empty($_POST['txt_egr_fec']) and !empty($_POST['cmb_cue_id']))
	{
		$mon_id=1;

		$oEgreso->modificar(
			$_POST['hdd_egr_id'],
			$_POST['hdd_egr_usumod'],
			fecha_mysql($_POST['txt_egr_fec']),
			strip_tags($_POST['txt_egr_det']),
			moneda_mysql($_POST['txt_egr_imp']),
			$_POST['cmb_egr_est'],
			$_POST['cmb_cue_id'],
			$_POST['cmb_subcue_id'],
			$_POST['cmb_caj_id'],
			$mon_id
		);
		
		/*
		if($_POST['hdd_gas_id']>0)
		{
			//INFO GASTO
			$dts= $oGasto->mostrarUno($_POST['hdd_gas_id']);
			$dt = mysql_fetch_array($dts);
				
				$gas_imp		=$dt['tb_gasto_imp'];
				
				//$caj_id		=$dt['tb_caja_id'];
				
				//$gas_est		=$dt['tb_gasto_est'];
				
			mysql_free_result($dts);

			//MODIFICAR ESTADO VENTA
		    $estado="'1'";
		    $rws1=$oEgreso->mostrar_por_gasto($_POST['hdd_gas_id'],$estado);
		    $filas= mysql_num_rows($rws1);
		    while($rw1 = mysql_fetch_array($rws1)){
		      $egreso_total+=$rw1['tb_egreso_imp'];
		    }
		    mysql_free_result($rws1);

		    if($gas_imp==$egreso_total)
		    {
		    	//$oGasto->modificar_campo($_POST['hdd_gas_id'],$_POST['hdd_egr_usumod'],'est','1');	
		    }
		}*/

		$data['egr_msj']='Se registró egreso correctamente.';
		
	}
	else
	{
		$data['egr_msj']='Intentelo nuevamente.';
	}
	echo json_encode($data);
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['egr_id']))
	{
		//$cst1 = $oEgreso->verifica_egreso_tabla($_POST['egr_id'],'tb_egreso');
		//$rst1= mysql_num_rows($cst1);
		//if($rst1>0)$msj1=' - Egresos';
		
		/*if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{*/
			$oEgreso->modificar_campo($_POST['egr_id'],$_SESSION['usuario_id'],'xac','0');
			echo 'Se envió a la papelera correctamente.';
		//}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>