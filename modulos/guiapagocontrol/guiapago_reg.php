<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../guiapagocontrol/cGuiapago.php");
$oGuiapago = new cGuiapago();
require_once("../formatos/formato.php");

if($_POST['action']=="insertar")
{
	if(!empty($_POST['hdd_cli_id']) and !empty($_POST['hdd_per_id']) and !empty($_POST['hdd_eje_id']))
	{
		$xac=1;
		$envcor=1;
		$est=1;

		if($_POST['cmb_guipagtip_id']==1){
			$pag 		=$_POST['cmb_guipag_pag'];
			$codtri 	=$_POST['txt_guipag_codtri'];
			$imppag 	=moneda_mysql($_POST['txt_guipag_imppag']);
			$codtriaso 	=$_POST['txt_guipag_codtriaso'];
			$numdoc		=$_POST['txt_guipag_numdoc'];
		}

		if($_POST['cmb_guipagtip_id']==2){
			$tipdocinq 	=$_POST['txt_guipag_tipdocinq'];
			$numdocinq 	=$_POST['txt_guipag_numdocinq'];
			$monalq 	=moneda_mysql($_POST['txt_guipag_monalq']);
			$arrrec 	=$_POST['cmb_guipag_arrrec'];
			$numordope 	=$_POST['txt_guipag_numordope'];
			$imppagser 	=$_POST['txt_guipag_imppagser'];

			$arrimppag 	=moneda_mysql($_POST['txt_guipag_monalq'])*0.05;
		}
		
		if($_POST['cmb_guipagtip_id']==3){
			$toting 	=moneda_mysql($_POST['txt_guipag_toting']);
			$cat 		=$_POST['txt_guipag_cat'];
			$moncom 	=moneda_mysql($_POST['txt_guipag_moncom']);
			$rusimppag 	=moneda_mysql($_POST['txt_guipag_rusimppag']);
			$privez 	=$_POST['cmb_guipag_privez'];
			$compag 	=moneda_mysql($_POST['txt_guipag_compag']);
		}

		if($_POST['cmb_guipagtip_id']==4){
			$numrucarr 	=$_POST['txt_guipag_numrucarr'];

			$tipdocinq 	=$_POST['txt_guipag_tipdocinq2'];
			$numdocinq 	=$_POST['txt_guipag_numdocinq2'];
			$monalq 	=moneda_mysql($_POST['txt_guipag_monalq2']);
			$arrrec 	=$_POST['cmb_guipag_arrrec2'];
			$numordope 	=$_POST['txt_guipag_numordope2'];
			$imppagser 	=$_POST['txt_guipag_imppagser2'];

			$arrimppag 	=moneda_mysql($_POST['txt_guipag_monalq2'])*0.05;
		}

		$oGuiapago->insertar(
			$xac,
			$_SESSION['usuario_id'],
			$_SESSION['usuario_id'],
			$_POST['cmb_guipagtip_id'],
			$_POST['hdd_cli_id'], 
			$_POST['hdd_per_id'],
			$_POST['hdd_eje_id'],
			fecha_mysql($_POST['txt_guipag_fecven']),
			fecha_mysql($_POST['txt_guipag_fecpag']),
			limpia_texto($_POST['txt_guipag_des']),
			$pag,
			$codtri,
			$imppag,
			$codtriaso,
			$numdoc,
			$numrucarr,
			$tipdocinq,
			$numdocinq,
			$monalq,
			$arrrec,
			$numordope,
			$imppagser,
			$arrimppag,
			$toting,
			$cat,
			$moncom,
			$rusimppag,
			$privez,
			$compag,
			moneda_mysql($_POST['txt_guipag_imppagbas']),
			$_POST['txt_guipag_numdia'],
			moneda_mysql($_POST['txt_guipag_tas']),
			moneda_mysql($_POST['txt_guipag_int']),
			moneda_mysql($_POST['txt_guipag_monact']),
			$envcor,
			$est
		);
		
			$dts=$oGuiapago->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$guipag_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		
		$data['guipag_id']=$guipag_id;
		$data['guipag_msj']='Se registró correctamente.';
		
	}
	else
	{
		$data['guipag_msj']='Intentelo nuevamente.';
	}

	echo json_encode($data);
}

if($_POST['action']=="insertar_actualizacion")
{
	if(!empty($_POST['hdd_cli_id']) and !empty($_POST['hdd_per_id']) and !empty($_POST['hdd_eje_id']))
	{
		$xac=1;
		$envcor=1;
		$est=1;

		if($_POST['hdd_guipag_id']>0)
		{
			$dts=$oGuiapago->mostrarUno($_POST['hdd_guipag_id']);
			$dt = mysql_fetch_array($dts);
				$guipagtip_id=$dt['tb_guiapagotipo_id'];
				$fecven 	=$dt['tb_guiapago_fecven'];
				$fecpag 	=mostrarFecha($dt['tb_guiapago_fecpag']);
				//$des 		=$dt['tb_guiapago_des'].' (ACT)';
				$imppagbas 	=$dt['tb_guiapago_imppagbas'];
				//$est 		=$dt['tb_guiapago_est'];

				if($guipagtip_id==1){
					$pag 		=$dt['tb_guiapago_pag'];
					$codtri 	=$dt['tb_guiapago_codtri'];
					//$imppag 	=formato_money($dt['tb_guiapago_imppag']);
					$imppag 	=moneda_mysql($_POST['txt_guipag_monact']);
					$codtriaso 	=$dt['tb_guiapago_codtriaso'];
					$numdoc		=$dt['tb_guiapago_numdoc'];
				}

				if($guipagtip_id==2){
					$tipdocinq 	=$dt['tb_guiapago_tipdocinq'];
					$numdocinq 	=$dt['tb_guiapago_numdocinq'];
					$monalq 	=$dt['tb_guiapago_monalq'];
					$arrrec 	=$dt['tb_guiapago_arrrec'];
					$numordope 	=$dt['tb_guiapago_numordope'];
					$imppagser 	=$dt['tb_guiapago_imppagser'];

					//$arrimppag 	=$dt['tb_guiapago_arrimppag'];
					$arrimppag 	=moneda_mysql($_POST['txt_guipag_monact']);
				}
				
				if($guipagtip_id==3){
					$toting 	=$dt['tb_guiapago_toting'];
					$cat 		=$dt['tb_guiapago_cat'];
					$moncom 	=$dt['tb_guiapago_moncom'];
					$rusimppag 	=moneda_mysql($_POST['txt_guipag_monact']);
					$privez 	=$dt['tb_guiapago_privez'];
					$compag 	=$dt['tb_guiapago_compag'];
				}

				if($guipagtip_id==4){
					$numrucarr 	=$dt['tb_guiapago_numrucarr'];
					$tipdocinq 	=$dt['tb_guiapago_tipdocinq'];
					$numdocinq 	=$dt['tb_guiapago_numdocinq'];
					$monalq 	=$dt['tb_guiapago_monalq'];
					$arrrec 	=$dt['tb_guiapago_arrrec'];
					$numordope 	=$dt['tb_guiapago_numordope'];

					//$arrimppag2 	=$dt['tb_guiapago_arrimppag'];
					$arrimppag 	=moneda_mysql($_POST['txt_guipag_monact']);
				}

			mysql_free_result($dts);
		}

		$oGuiapago->insertar(
			$xac,
			$_SESSION['usuario_id'],
			$_SESSION['usuario_id'],
			$guipagtip_id,
			$_POST['hdd_cli_id'], 
			$_POST['hdd_per_id'],
			$_POST['hdd_eje_id'],
			$fecven,
			fecha_mysql($_POST['txt_guipag_fecpag']),
			limpia_texto($_POST['txt_guipag_des']),
			$pag,
			$codtri,
			$imppag,
			$codtriaso,
			$numdoc,
			$numrucarr,
			$tipdocinq,
			$numdocinq,
			$monalq,
			$arrrec,
			$numordope,
			$imppagser,
			$arrimppag,
			$toting,
			$cat,
			$moncom,
			$rusimppag,
			$privez,
			$compag,
			$imppagbas,
			$_POST['txt_guipag_numdia'],
			moneda_mysql($_POST['txt_guipag_tas']),
			moneda_mysql($_POST['txt_guipag_int']),
			moneda_mysql($_POST['txt_guipag_monact']),
			$envcor,
			$est
		);
		
			$dts=$oGuiapago->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$guipag_id=$dt['last_insert_id()'];
			mysql_free_result($dts);

		$envcor=0;
		$oGuiapago->modificar_campo($_POST['hdd_guipag_id'],$_SESSION['usuario_id'],'envcor',$envcor);

		$data['guipag_id']=$guipag_id;
		$data['guipag_msj']='Se registró correctamente.';
		
	}
	else
	{
		$data['guipag_msj']='Intentelo nuevamente.';
	}

	echo json_encode($data);
}

if($_POST['action']=="editar")
{
	if(!empty($_POST['probalnot_id']))
	{

		$oGuiapago->editar_control(
			$_POST['probalnot_id'], 
			$_POST['xac']
		);
		
		$data['probalnot_id']=$_POST['probalnot_id'];
		$data['probalnot_msj']='Se registró correctamente.';
		
	}
	else
	{
		$data['probalnot_msj']='Intentelo nuevamente.';
	}

	echo json_encode($data);
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['guipag_id']))
	{
		$oGuiapago->modificar_campo($_POST['guipag_id'],$_SESSION['usuario_id'],'xac','0');

		$data['guipag_msj']='Se envió a la papelera correctamente.';
	}
	else
	{
		$data['guipag_msj']='Intentelo nuevamente.';
	}

	echo json_encode($data);
}

if($_POST['action']=="correo")
{
	if(!empty($_POST['guipag_id']))
	{
		$oGuiapago->modificar_campo($_POST['guipag_id'],$_SESSION['usuario_id'],'envcor',$_POST['guipag_envcor']);

		$data['guipag_msj']='Se actualizó correctamente.';
	}
	else
	{
		$data['guipag_msj']='Intentelo nuevamente.';
	}

	echo json_encode($data);
}
?>