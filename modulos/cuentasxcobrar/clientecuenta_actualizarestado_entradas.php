<?php 
session_start();
	require_once ("../../config/Cado.php");
	require_once("cClientecuenta.php");
	$oClientecuenta = new cClientecuenta();
	
	$emp_id=$_SESSION['empresa_id'];
	
	$cli_id = $_POST['cli_id'];
	
	$dts = $oClientecuenta->obtener_sumatoria_entradas_por_estado($cli_id,$emp_id);
	$entradas = array();
	while($dt = mysql_fetch_array($dts)){	
		$estado = $dt['estado'];
		if($estado == 1){
			//Este array contiene 2 filas en el primer elemento registra la sumatoria de los montos de las entradas con el estado cancelado
			$entradas['monto_cancelado'] = $dt['monto'];		
		}
		if($estado == 2){
			//Este array contiene 2 filas en el 2do elemento registra la sumatoria de los montos de las entradas con el estado por cancelar
			$entradas['monto_por_cancelar'] = $dt['monto'];		
		}
	}
	mysql_free_result($dts);
	
	$dts = $oClientecuenta->obtener_sumatoria_salidas($cli_id,$emp_id);
	$dt = mysql_fetch_array($dts);
	$sumatoria_salidas = $dt['monto'];//esta variable almacena la sumatoria de los montos de salidas de la cuenta cliente	
	mysql_free_result($dts);
	
	$sumatoria_salidas = $sumatoria_salidas - $entradas['monto_cancelado'];
	
	$dts = $oClientecuenta->mostrar_cuenta_por_cliente($cli_id,$emp_id);
	$num_rows = mysql_num_rows($dts);	
	while($dt = mysql_fetch_array($dts)){
		$tip = $dt['tb_clientecuenta_tip'];//Tipo 1:Entrada; 2:Salida
		
		if($tip == 1 && ($dt['tb_clientecuenta_est'] == 2 || $dt['tb_clientecuenta_est'] == 3)){
			$mon = $dt['tb_clientecuenta_mon'];//Monto de la Cuenta Cliente de Entrada
			//echo "Monto:".$mon.'<br>';
			if($sumatoria_salidas >= $mon){				
				//echo $dt['tb_clientecuenta_id'].'<br>';
				//echo $sumatoria_salidas.'<br>';
				$oClientecuenta->actualizar_estado_entradas($dt['tb_clientecuenta_id'], 1);
				$sumatoria_salidas -= $mon;//Actualizando la variable sumatoria
			}else{
				if($sumatoria_salidas > 0){
					$oClientecuenta->actualizar_estado_entradas($dt['tb_clientecuenta_id'], 3);
				}
				break;
			}
		}					
	}

?>