<?php
/*session_start();
	require_once ("../../config/Cado.php");	
	require_once ("../kardex/cHistorial.php");
	$oHistorial = new cHistorial();
	
	require_once ("../catalogo/cCatalogo.php");
	$oCatalogo = new cCatalogo();
	
	require_once ("../producto/cCatalogoproducto.php");
	$oCatalogoproducto = new cCatalogoproducto();
	
	require_once ("../formatos/formato.php");
	require_once ("../notalmacen/cNotalmacen.php");
	$oNotalmacen = new cNotalmacen();
	
	require_once ("../talonario/cTalonariointerno.php");
	$oTalonariointerno= new cTalonariointerno();
	
	$alm_id = 1;	
	
	//Nota de Almacen
	
	$doc_id=3;//nota de almacen
		
		$rws= $oTalonariointerno->correlativo_tra($alm_id,$doc_id);
		$rw = mysql_fetch_array($rws);
		
		$tal_id=$rw['tb_talonario_id'];
		$tal_ser=$rw['tb_talonario_ser'];
		$tal_num=$rw['tb_talonario_num'];
		$tal_fin=$rw['tb_talonario_fin'];
			mysql_free_result($rws);
		$tal_numero=$tal_num+1;
		$largo=strlen($tal_fin);
		
		$correlativo=str_pad($tal_numero,$largo, "0", STR_PAD_LEFT);
		
		$y=date('Y');
		
		$cod_almacen=str_pad($alm_id,2, "0", STR_PAD_LEFT);
	
		echo $codigo="$cod_almacen-$y-$correlativo";
		
	
		//registro de nota
		//Registro del Stock Inicial en las Notas de Almacen
		
		$tipo_registro=1;//1 automatico 2 manual
		$notalm_tip=1;//1 entrada 2 salida
		$documento_id=5;//5 otros
		$numdoc="";
		$tipope_id=1;//1 saldo inicial 2 compra 3 venta
		$notalm_des='SALDO INICIAL';
		$operacion_id="";//id de la operacion(modulo compras, ventas, etc)
		$usuario_id=2;
		
		//insertamos nota almacen
		$oNotalmacen->insertar($tipo_registro,
			$codigo,
			"2013-01-01",
			$notalm_tip,
			$documento_id,
			$numdoc,
			$tipope_id,
			$notalm_des,
			$operacion_id,
			$alm_id,
			$usuario_id,
			$_SESSION['empresa_id']
		);

	//ultimo nota de almacen
	$rs_na =$oNotalmacen->ultimoInsert();
	$dt_na = mysql_fetch_array($rs_na);
	$notalm_id=$dt_na['last_insert_id()'];
	mysql_free_result($rs_na);
	//Fin Nota de Almacen
	
	//actualizamos talonario de nota de almacen
	$tal_estado='ACTIVO';
	if($tal_numero==$tal_fin)$tal_estado='INACTIVO';
	$rs= $oTalonariointerno->actualizar_correlativo($tal_id,$tal_numero,$tal_estado); 
	
	$dts = $oCatalogo->mostrar_todos();
	$i=1;
	while($dt = mysql_fetch_array($dts)){
		$cat_id = $dt['tb_catalogo_id'];
		$pro_nom = $dt['tb_producto_nom'];			
		//1
		$dts1 = $oHistorial->consultar_historial_compras_por_producto($cat_id,$alm_id);	
		$num_rows_1 = mysql_num_rows($dts1);
		
		$sum_can_com = 0;//Suma Cantidades de Compras por Producto		
		
		if($num_rows_1>=1){		
			while($dt1 = mysql_fetch_array($dts1)){
				$sum_can_com += $dt1['tb_compradetalle_can'];						
			}	
			mysql_free_result($dts1);
		}

		//2
		$dts2 = $oHistorial->consultar_historial_ventas_por_producto($cat_id,$alm_id);	
		$num_rows_2 = mysql_num_rows($dts2);
		
		$sum_can_ven = 0;//Suma Cantidades de Ventas por Producto
		$sum_tot_ven = 0;//Suma Total de Los SubTotales por Producto		
		
		if($num_rows_2>=1){
			while($dt2 = mysql_fetch_array($dts2)){
				$sum_can_ven += $dt2['tb_ventadetalle_can'];
			}	
			mysql_free_result($dts2);
		}

		//3
		$dts3 = $oHistorial->consultar_historial_traspasos_entrada_por_producto($cat_id,$alm_id);	
		$num_rows_3 = mysql_num_rows($dts3);
		
		$sum_can_tra_ent = 0;//Suma Cantidades de Trasnferencias de Entrada por Producto
				
		if($num_rows_3>=1){
			while($dt3 = mysql_fetch_array($dts3)){
				$sum_can_tra_ent += $dt3['cantidad'];
			}	
			mysql_free_result($dts3);
		}	
		 
		//4
		$dts4 = $oHistorial->consultar_historial_traspasos_salida_por_producto($cat_id,$alm_id);	
		$num_rows_4 = mysql_num_rows($dts4);
		
		$sum_can_tra_sal = 0;//Suma Cantidades de Trasnferencias de Salida por Producto
				
		if($num_rows_4>=1){
			while($dt4 = mysql_fetch_array($dts4)){
				$sum_can_tra_sal += $dt4['cantidad'];
			}	
			mysql_free_result($dts4);	
		}
		
        //5
		$dts5 = $oHistorial->consultar_historial_ventanotas_por_producto($cat_id,$alm_id);	
		$num_rows_5 = mysql_num_rows($dts5);
		
		$sum_can_vennot = 0;//Suma Cantidades de Ventas por Producto
		$sum_tot_vennot = 0;//Suma Total de Los SubTotales por Producto
		
		if($num_rows_5>=1){
			while($dt5 = mysql_fetch_array($dts5)){
				$sum_can_vennot += $dt5['tb_ventadetalle_can'];
			}	
			mysql_free_result($dts5);
		}
		?>
        
		<!--6-->
		<div align="left" style="width:20%">
			<fieldset>
				<legend>Datos Stock</legend>
                <strong><?php echo $i++?> Cat&aacute;logo Id: </strong><?php echo $cat_id;?><br />
                <strong>Producto: </strong><?php echo $pro_nom;?><br />
				<strong>Stock Actual: </strong>
				<?php
				$rs = $oCatalogoproducto->presentacion_catalogo_stock_almacen($cat_id, $alm_id);
				$dt = mysql_fetch_array($rs);
				$stock_id = $dt['tb_stock_id'];
				$stock_actual = $dt['tb_stock_num'];
				echo $stock_actual;
				mysql_free_result($rs);
				
				$stock_inicial = $stock_actual - $sum_can_com + $sum_can_ven + $sum_can_vennot - $sum_can_tra_ent + $sum_can_tra_sal;?>
				<br />
				<strong>Stock Inicial: </strong>
				<?php 
				echo $stock_inicial;
				?> 
                <br />
				<strong>Registro en stock: </strong>
				<?php 				
				if($stock_id>0) echo 'SI</br>';
				echo ' C: '.$sum_can_com;
				echo ' V: '.$sum_can_ven;
				echo ' NV: '.$sum_can_vennot;
				echo ' TE: '.$sum_can_tra_ent;
				echo ' TS: '.$sum_can_tra_sal;
				?>    
			</fieldset>
		</div><br /><?php	
			if($stock_id>0){
		//registro detalle de notalmacen
		$oNotalmacen->insertar_detalle(
				$cat_id,
				$stock_inicial,
				0,
				0,
				$notalm_id				
		);
			}
		//Fin Registro del Stock Inicial en las Notas de Almacen		
	}
	mysql_free_result($dts);
*/
?>