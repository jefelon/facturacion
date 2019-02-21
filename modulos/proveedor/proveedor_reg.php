<?php
require_once ("../../config/Cado.php");
require_once("../proveedor/cProveedor.php");
$oProveedor = new cProveedor();
require_once("../formatos/formato.php");

if($_POST['action_proveedor']=="insertar")
{
	if(!empty($_POST['txt_pro_doc']))
	{
		$cst1 = $oProveedor->verifica_proveedor_doc($_POST['txt_pro_doc'],0);
		$rst1= mysql_num_rows($cst1);
		
		if($rst1>0)
		{
			$dt = mysql_fetch_array($cst1);
			$pro_id=$dt['tb_proveedor_id'];
			mysql_free_result($cst1);
			
			$data['pro_id']=$pro_id;
			$data['pro_msj']='Existe proveedor con el mismo número de documento '.$_POST['txt_pro_doc'].'.';
		}
		else
		{
			$oProveedor->insertar(
				$_POST['rad_pro_tip'], 
				strip_tags(limpia_espacios($_POST['txt_pro_nom'])),
				$_POST['txt_pro_doc'],
                strip_tags($_POST['txt_pro_dir']),
                strip_tags(limpia_espacios($_POST['txt_pro_con'])),
				$_POST['txt_pro_tel'], 
				$_POST['txt_pro_ema'],
                $_POST['cmb_pais_id']
            );
			
				$dts=$oProveedor->ultimoInsert();
				$dt = mysql_fetch_array($dts);
			$pro_id=$dt['last_insert_id()'];
				mysql_free_result($dts);
			
			$data['pro_id']=$pro_id;
			$data['pro_msj']='Se registró proveedor correctamente.';
		}
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action_proveedor']=="editar")
{
	if(!empty($_POST['txt_pro_doc']))
	{
		$cst1 = $oProveedor->verifica_proveedor_doc($_POST['txt_pro_doc'],$_POST['hdd_pro_id']);
		$rst1= mysql_num_rows($cst1);
		
		if($rst1>0)
		{
			$dt = mysql_fetch_array($cst1);
			$pro_id=$dt['tb_proveedor_id'];
			mysql_free_result($cst1);
			
			$data['pro_id']=$pro_id;
			$data['pro_msj']='Existe proveedor con el mismo número de documento '.$_POST['txt_pro_doc'].'.';
		}
		else
		{
			$oProveedor->modificar(
				$_POST['hdd_pro_id'], 
				$_POST['rad_pro_tip'],
				strip_tags(limpia_espacios($_POST['txt_pro_nom'])),
				$_POST['txt_pro_doc'],
                strip_tags($_POST['txt_pro_dir']),
                strip_tags(limpia_espacios($_POST['txt_pro_con'])),
				$_POST['txt_pro_tel'], 
				$_POST['txt_pro_ema'],
                $_POST['cmb_pais_id']
            );
			
			$data['pro_id']=$_POST['hdd_pro_id'];
			$data['pro_msj']='Se registró proveedor correctamente.';
		}
		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action']=="eliminar")
{
	if(!empty($_POST['pro_id']))
	{
		$cst1 = $oProveedor->verifica_proveedor_tabla($_POST['pro_id'],'tb_compra');
		$rst1= mysql_num_rows($cst1);
		if($rst1>0)$msj1=' Compra';
		
		if($rst1>0)
		{
			echo "No se puede eliminar, afecta información de: ".$msj1.".";
		}
		else
		{
			$oProveedor->eliminar($_POST['pro_id']);
			echo 'Se eliminó proveedor correctamente.';
		}
	}
	else
	{
		echo 'Intentelo nuevamente.';
	}
}

if($_POST['action'] == "obtener_datos"){
	if(!empty($_POST['pro_id'])){
		$rs = $oProveedor->mostrarUno($_POST['pro_id']);		
		$fila = mysql_fetch_array($rs);
			$data['direccion'] = $fila['tb_proveedor_dir'];
			$data['documento'] = $fila['tb_proveedor_doc'];			
			$data['nombre'] = $fila['tb_proveedor_nom'];
		
		echo json_encode($data);
	}else{
		echo "Error en la obtención de datos del Proveedor!";	
	}
}
?>