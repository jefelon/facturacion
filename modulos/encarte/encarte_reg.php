<?php
session_start();
if($_SESSION["autentificado"]!= "SI"){ header("location: ../../index.php"); exit();}
require_once ("../../config/Cado.php");
require_once("cEncarte.php");
$oEncarte = new cEncarte();
require_once ("../producto/cCatalogoproducto.php");
$oCatalogoproducto = new cCatalogoproducto();

require_once("../formatos/formato.php");

if($_POST['action_encarte']=="insertar")
{
	if(!empty($_POST['txt_enc_fecini']) and $_POST['cmb_enc_est']=='ACTIVO')
	{
		//insertamos encarte
		$oEncarte->insertar(
			fecha_mysql($_POST['txt_enc_fecini']),
			fecha_mysql($_POST['txt_enc_fecfin']),
			$_POST['txt_enc_des'],
			$_POST['txt_enc_despor'],
			$_POST['cmb_enc_est'],
			$_POST['hdd_usu_id'],
			$_POST['hdd_emp_id']
		);
		//ultimo encarte
			$dts=$oEncarte->ultimoInsert();
			$dt = mysql_fetch_array($dts);
		$enc_id=$dt['last_insert_id()'];
			mysql_free_result($dts);
		
		//detalle productos
		foreach($_SESSION['encarte_car'] as $indice=>$catalogo_id){
			
			//consulta de datos			
			$dts1=$oCatalogoproducto->presentacion_catalogo($indice);
			$dt1 = mysql_fetch_array($dts1);
			
			$cos		=$_SESSION['encarte_cos'][$indice];
			$uti1		=$_SESSION['encarte_uti1'][$indice];
			$preven1=$_SESSION['encarte_preven1'][$indice];
			$despor	=$_SESSION['encarte_despor'][$indice];
			$uti2		=$_SESSION['encarte_uti2'][$indice];
			$preven2=$_SESSION['encarte_preven2'][$indice];
				
			//registro detalle de encarte
			$oEncarte->insertar_detalle(
				$indice,
				$cos, 
				$despor,
				$uti1,
				$preven1,
				$uti2,
				$preven2,
				$enc_id
			);
			
			//actualizacion de precios
			//$dts= $oCatalogoproducto->actualizar_precio_venta($indice,$uti2,$preven2);
			//$dts= $oCatalogoproducto->actualizar_precio_costo($indice,$cos);
			
			//finalizar consulta
			mysql_free_result($dts1);
    }
		
		unset($_SESSION['encarte_car']);
		unset($_SESSION['encarte_cos']);
		unset($_SESSION['encarte_uti1']);
		unset($_SESSION['encarte_preven1']);
		unset($_SESSION['encarte_despor']);
		unset($_SESSION['encarte_uti2']);
		unset($_SESSION['encarte_preven2']);
		
		$data['enc_id']=$enc_id;
		$data['enc_msj']='Se registró encarte correctamente.';
		echo json_encode($data);
	}
	else
	{
		$data['enc_msj']='Intentelo nuevamente.';
		echo json_encode($data);
	}
}

if($_POST['action_encarte']=="editar")
{
	if($_POST['cmb_enc_est']=='ACTIVO')
	{
		$oEncarte->modificar(
			$_POST['hdd_enc_id'],
			$_POST['txt_enc_des']
		);
		
		$data['enc_msj']='Se registró encarte correctamente.';
		echo json_encode($data);
	}
	else
	{
		$data['enc_msj']='Intentelo nuevamente. Encarte INACTIVO.';
		echo json_encode($data);
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['enc_id']))
	{
//		$result = $oEncarte->verifica_encarte_producto($_POST['enc_id']);
//		$fila = mysql_fetch_array($result);
//		
//		if($fila[1] !="")
//		{
			echo "No se puede eliminar, afecta información de productos.";
//		}
//		else
//		{
//			$oEncarte->eliminar($_POST['enc_id']);
//		echo 'Se eliminó encarte correctamente.';
//		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}
?>