<?php
require_once ("../../config/Cado.php");	
require_once ("../kardex/cKardex.php");
require_once ("../historial/cHistorial.php");
//require_once ("../notalmacen/cNotalmacen2.php");

function stock_kardex($cat_id,$alm_id,$fecini,$fecfin,$emp_id)
{
	$oKardex = new cKardex();
	
	if($fecini=="")$fecini='2016-01-01';
	
	$rws1 = $oKardex->inventario_tipo_por_producto($cat_id,$alm_id,'1',$fecini,$fecfin,$emp_id);
	$rw1 = mysql_fetch_array($rws1);
	$cantidad_entrada=$rw1['cantidad'];
	mysql_free_result($rws1);
	
	$rws1 = $oKardex->inventario_tipo_por_producto($cat_id,$alm_id,'2',$fecini,$fecfin,$emp_id);
	$rw1 = mysql_fetch_array($rws1);
	$cantidad_salida=$rw1['cantidad'];
	mysql_free_result($rws1);
	
	$stock_unidad=$cantidad_entrada-$cantidad_salida;
	
	return $stock_unidad;
}


function stock_kardex_reg($cat_id,$alm_id,$fecini,$fecfin,$emp_id)
{
    $oKardex = new cKardex();
    $rws1 = $oKardex->inventario_tipo_por_producto_fecha_reg($cat_id,$alm_id,'1',$fecini,$fecfin,$emp_id);
    $rw1 = mysql_fetch_array($rws1);
    $cantidad_entrada=$rw1['cantidad'];
    mysql_free_result($rws1);

    $rws1 = $oKardex->inventario_tipo_por_producto_fecha_reg($cat_id,$alm_id,'2',$fecini,$fecfin,$emp_id);
    $rw1 = mysql_fetch_array($rws1);
    $cantidad_salida=$rw1['cantidad'];
    mysql_free_result($rws1);

    $stock_unidad=$cantidad_entrada-$cantidad_salida;

    return $stock_unidad;
}

function costo_ponderado($cat_id,$alm_id,$fecini,$fecfin,$stock_comparacion,$costo_soles,$costo_dolares,$emp_id)
{
	$oHistorial = new cHistorial();
	$oKardex = new cKardex();
	
	if($fecini=="")$fecini='2013-01-01';
	
	//SALDO INICIAL
	$dts1 = $oKardex->mostrar_kardex_por_producto($cat_id,$alm_id,$fecini,$fecfin);
	$num_rows_1 = mysql_num_rows($dts1);
	
	$dt1 = mysql_fetch_array($dts1);
	$notalmdet_can=$dt1['tb_notalmacendetalle_can'];
	$notalmdet_cos=$dt1['tb_notalmacendetalle_cos'];
	mysql_free_result($dts1);
	//__________
	
	//artificio para mostrar el tipo cambio eliminar luego de uso
	/*if($notalmdet_can)
	{
			$oNotalmacen = new cNotalmacen();
		$rws= $oNotalmacen->mostrar_catalogo($cat_id);
		$rw = mysql_fetch_array($rws);
			$tipo_cambio_artificio	=$rw['tb_catalogo_tipcam'];
			//$cat_uti	=$rw['tb_catalogo_uti'];
			//$cat_costo	=$rw['tb_catalogo_precos'];
			//$cat_precio	=$rw['tb_catalogo_preven'];
		mysql_free_result($rws);
		
		if($tipo_cambio_artificio>0)$notalmdet_cosdol=$notalmdet_cos/$tipo_cambio_artificio;
	}*/
	
	//consulta de compras por fecha desc
	$rws1 = $oHistorial->consultar_historial_compras_por_producto($cat_id,$alm_id,$fecini,$fecfin,'DESC',$emp_id);
	$filas_compra=mysql_num_rows($rws1);
	
	if($filas_compra>0 and $stock_comparacion!=0)
	{
		//recorriendo registros de compras
		while($rw1 = mysql_fetch_array($rws1))
		{							
			$comdet_can		=$rw1['tb_compradetalle_can'];
			$tipo_moneda	=$rw1['tb_compra_mon'];
			$com_tipcam		=$rw1['tb_compra_tipcam'];
			$comdet_cosuni	=$rw1['tb_compradetalle_cosuni'];//en soles
			
			//calculo del costo unitario_______
			if($tipo_moneda==2)
			{
				$costo_unitario_dol=$comdet_cosuni/$com_tipcam;
				//$i_dol++;	
			}
			
			//para el cálculo siempre utiliza el costo en soles
			$costo_unitario_sol=$comdet_cosuni;
			//$i_sol++;
			
			//$suma_costo_unitario_dol+=$costo_unitario_dol;
			//$suma_costo_unitario_sol+=$costo_unitario_sol;
			
			//__________________________________
			
	
			//$datos.=$stock_comparacion.$comdet_can.',';
			
			if($stock_comparacion>=$comdet_can)
			{
				$isuma_sol+=$comdet_can;
				$mul_suma_sol+=($comdet_can*$costo_unitario_sol);
				
				if($tipo_moneda==2)
				{
					$isuma_dol+=$comdet_can;
					$mul_suma_dol+=($comdet_can*$costo_unitario_dol);
				}
				
				$stock_comparacion=$stock_comparacion-$comdet_can;
				
				//si el stock es igual a la compra detalle cerrar el while
				if($stock_comparacion==0)break;
			}
			else
			{
				$isuma_sol+=$stock_comparacion;
				$mul_suma_sol+=($stock_comparacion*$costo_unitario_sol);
				
				if($tipo_moneda==2)
				{
					$isuma_dol+=$stock_comparacion;
					$mul_suma_dol+=($stock_comparacion*$costo_unitario_dol);
				}
				
				//stock compracion igual a cero para no incluir saldo inicial
				$stock_comparacion=0;
				
				break;
			}
			//$datos2.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';
		}
		mysql_free_result($rws1);
		
		//$datos3.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';
		
		//si el stock comparacion es mayor a cero seguir calculando con el saldo inicial
		if($stock_comparacion>0)
		{
			//soles			
			$isuma_sol+=$stock_comparacion;
			$mul_suma_sol+=($stock_comparacion*$notalmdet_cos);
			//dolares
			$isuma_dol+=$stock_comparacion;
			$mul_suma_dol+=($stock_comparacion*$notalmdet_cosdol);
		}
		
		//$datos4.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';
		
		//$resultado_costo_soles=$suma_costo_unitario_sol/$i_sol;
		if($isuma_sol>0)$resultado_costo_soles=$mul_suma_sol/$isuma_sol;
		
		if($isuma_dol==0)
		{
			$resultado_costo_dolares=$costo_dolares;
		}
		//if($i_dol>0)$resultado_costo_dolares=$suma_costo_unitario_dol/$i_dol;
		if($isuma_dol>0)$resultado_costo_dolares=$mul_suma_dol/$isuma_dol;
		
		
	}
	else
	{
		$resultado_costo_soles=$costo_soles;
		$resultado_costo_dolares=$costo_dolares;
	}
	
	//si no hay stock para la comparación
	/*if($stock_comparacion==0)
	{
		$resultado_costo_soles=$costo_soles;
		$resultado_costo_dolares=$costo_dolares;
	}*/
	
	$costo_ponderado['soles']=$resultado_costo_soles;
	$costo_ponderado['dolares']=$resultado_costo_dolares;
//	$costo_ponderado['datos']=$datos;
//	$costo_ponderado['datos2']=$datos2;
//	$costo_ponderado['datos3']=$datos3;
//	$costo_ponderado['datos4']=$datos4;
	
	return $costo_ponderado;
}

function costo_ponderado_empresa_fechas_reg($cat_id,$alm_id,$fecini,$fecfin,$stock_comparacion,$costo_soles,$costo_dolares,$emp_id)
{
    $oHistorial = new cHistorial();
    $oKardex = new cKardex();

    //datos para SALDO INICIAL
    $dts1 = $oKardex->mostrar_kardex_tipoperacion_por_producto_fechas_reg($cat_id,$alm_id,9,$fecini,$fecfin);
    $num_rows_1 = mysql_num_rows($dts1);

    $dt1 = mysql_fetch_array($dts1);
    $notalmdet_can=$dt1['tb_kardexdetalle_can'];
    $notalmdet_pre=$dt1['tb_kardexdetalle_pre'];
    mysql_free_result($dts1);

    //consulta de compras por fecha desc almacen=0 COMPRA GENERAL POR EMPRESA
    $rws1 = $oHistorial->consultar_historial_compras_por_producto_reg($cat_id,0,$fecini,$fecfin,'DESC',$emp_id);
    $filas_compra=mysql_num_rows($rws1);

    if($filas_compra>0 and $stock_comparacion!=0)
    {
        //recorriendo registros de compras
        while($rw1 = mysql_fetch_array($rws1))
        {
            $comdet_can		=$rw1['tb_compradetalle_can'];
            $tipo_moneda	=$rw1['tb_compra_mon'];
            $com_tipcam		=$rw1['tb_compra_tipcam'];
            $comdet_preuni	=$rw1['tb_compradetalle_preuni'];//en soles

            //calculo del costo unitario_______
            if($tipo_moneda==2)
            {
                $costo_unitario_dol=$comdet_preuni/$com_tipcam;
                //$i_dol++;
            }

            //para el cálculo siempre utiliza el costo en soles
            $costo_unitario_sol=$comdet_preuni;
            //$i_sol++;

            //$suma_costo_unitario_dol+=$costo_unitario_dol;
            //$suma_costo_unitario_sol+=$costo_unitario_sol;

            //__________________________________


            //$datos.=$stock_comparacion.$comdet_can.',';

            if($stock_comparacion>=$comdet_can)
            {
                $isuma_sol+=$comdet_can;
                $mul_suma_sol+=($comdet_can*$costo_unitario_sol);

                if($tipo_moneda==2)
                {
                    $isuma_dol+=$comdet_can;
                    $mul_suma_dol+=($comdet_can*$costo_unitario_dol);
                }

                $stock_comparacion=$stock_comparacion-$comdet_can;

                //si el stock es igual a la compra detalle cerrar el while
                if($stock_comparacion==0)break;
            }
            else
            {
                $isuma_sol+=$stock_comparacion;
                $mul_suma_sol+=($stock_comparacion*$costo_unitario_sol);

                if($tipo_moneda==2)
                {
                    $isuma_dol+=$stock_comparacion;
                    $mul_suma_dol+=($stock_comparacion*$costo_unitario_dol);
                }

                //stock compracion igual a cero para no incluir saldo inicial
                $stock_comparacion=0;

                break;
            }
            //$datos2.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';
        }
        mysql_free_result($rws1);

        //$datos3.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';


        //si el stock comparacion es mayor a cero seguir calculando con el saldo inicial
        if($stock_comparacion>0)
        {
            //soles
            $isuma_sol+=$stock_comparacion;
            $mul_suma_sol+=($stock_comparacion*$notalmdet_pre);
            //dolares
            $isuma_dol+=$stock_comparacion;
            $mul_suma_dol+=($stock_comparacion*$notalmdet_predol);
        }

        //$datos4.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';

        //$resultado_costo_soles=$suma_costo_unitario_sol/$i_sol;
        if($isuma_sol>0)$resultado_costo_soles=$mul_suma_sol/$isuma_sol;

        //dolares
        //if($i_dol>0)$resultado_costo_dolares=$suma_costo_unitario_dol/$i_dol;
        if($isuma_dol==0)
        {
            $resultado_costo_dolares=$costo_dolares;
        }
        if($isuma_dol>0)$resultado_costo_dolares=$mul_suma_dol/$isuma_dol;


    }
    else
    {
        $resultado_costo_soles=$costo_soles;
        $resultado_costo_dolares=$costo_dolares;
    }

    //si no hay stock para la comparación
    /*if($stock_comparacion==0)
    {
        $resultado_costo_soles=$costo_soles;
        $resultado_costo_dolares=$costo_dolares;
    }*/

    $costo_ponderado['soles']=$resultado_costo_soles;
    $costo_ponderado['dolares']=$resultado_costo_dolares;
//	$costo_ponderado['datos']=$datos;
//	$costo_ponderado['datos2']=$datos2;
//	$costo_ponderado['datos3']=$datos3;
//	$costo_ponderado['datos4']=$datos4;

    return $costo_ponderado;
}

function costo_ponderado_empresa($cat_id,$alm_id,$fecini,$fecfin,$stock_comparacion,$costo_soles,$costo_dolares,$emp_id)
{
	$oHistorial = new cHistorial();
	$oKardex = new cKardex();
	
	if($fecini=="")$fecini='2013-01-01';
	
	//datos para SALDO INICIAL
    $dts1 = $oKardex->mostrar_kardex_tipoperacion_por_producto_fechas_reg($cat_id,$alm_id,9,$fecini,$fecfin);
	$num_rows_1 = mysql_num_rows($dts1);
	
	$dt1 = mysql_fetch_array($dts1);
    $notalmdet_can=$dt1['tb_kardexdetalle_can'];
    $notalmdet_pre=$dt1['tb_kardexdetalle_pre'];
	mysql_free_result($dts1);
	//__________
	
	//artificio para mostrar el tipo cambio eliminar luego de uso
	/*if($notalmdet_can)
	{
			$oNotalmacen = new cNotalmacen();
		$rws= $oNotalmacen->mostrar_catalogo($cat_id);
		$rw = mysql_fetch_array($rws);
			$tipo_cambio_artificio	=$rw['tb_catalogo_tipcam'];
			//$cat_uti	=$rw['tb_catalogo_uti'];
			//$cat_costo	=$rw['tb_catalogo_precos'];
			//$cat_precio	=$rw['tb_catalogo_preven'];
		mysql_free_result($rws);
		
		if($tipo_cambio_artificio>0)$notalmdet_cosdol=$notalmdet_cos/$tipo_cambio_artificio;
	}*/
	
	//consulta de compras por fecha desc almacen=0 COMPRA GENERAL POR EMPRESA
	$rws1 = $oHistorial->consultar_historial_compras_por_producto($cat_id,0,$fecini,$fecfin,'DESC',$emp_id);
	$filas_compra=mysql_num_rows($rws1);
	
	if($filas_compra>0 and $stock_comparacion!=0)
	{
		//recorriendo registros de compras
		while($rw1 = mysql_fetch_array($rws1))
		{							
			$comdet_can		=$rw1['tb_compradetalle_can'];
			$tipo_moneda	=$rw1['tb_compra_mon'];
			$com_tipcam		=$rw1['tb_compra_tipcam'];
			$comdet_preuni	=$rw1['tb_compradetalle_preuni'];//en soles
			
			//calculo del costo unitario_______
			if($tipo_moneda==2)
			{
				$costo_unitario_dol=$comdet_preuni/$com_tipcam;
				//$i_dol++;	
			}
			
			//para el cálculo siempre utiliza el costo en soles
			$costo_unitario_sol=$comdet_preuni;
			//$i_sol++;
			
			//$suma_costo_unitario_dol+=$costo_unitario_dol;
			//$suma_costo_unitario_sol+=$costo_unitario_sol;
			
			//__________________________________
			
	
			//$datos.=$stock_comparacion.$comdet_can.',';
			
			if($stock_comparacion>=$comdet_can)
			{
				$isuma_sol+=$comdet_can;
				$mul_suma_sol+=($comdet_can*$costo_unitario_sol);
				
				if($tipo_moneda==2)
				{
					$isuma_dol+=$comdet_can;
					$mul_suma_dol+=($comdet_can*$costo_unitario_dol);
				}
				
				$stock_comparacion=$stock_comparacion-$comdet_can;
				
				//si el stock es igual a la compra detalle cerrar el while
				if($stock_comparacion==0)break;
			}
			else
			{
				$isuma_sol+=$stock_comparacion;
				$mul_suma_sol+=($stock_comparacion*$costo_unitario_sol);
				
				if($tipo_moneda==2)
				{
					$isuma_dol+=$stock_comparacion;
					$mul_suma_dol+=($stock_comparacion*$costo_unitario_dol);
				}
				
				//stock compracion igual a cero para no incluir saldo inicial
				$stock_comparacion=0;
				
				break;
			}
			//$datos2.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';
		}
		mysql_free_result($rws1);
		
		//$datos3.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';
		
		
		//si el stock comparacion es mayor a cero seguir calculando con el saldo inicial
		if($stock_comparacion>0)
		{
			//soles			
			$isuma_sol+=$stock_comparacion;
			$mul_suma_sol+=($stock_comparacion*$notalmdet_pre);
			//dolares
			$isuma_dol+=$stock_comparacion;
			$mul_suma_dol+=($stock_comparacion*$notalmdet_predol);
		}
		
		//$datos4.=$stock_comparacion.$comdet_can.':'.$isuma_sol.'+'.$mul_suma_sol.',';
		
		//$resultado_costo_soles=$suma_costo_unitario_sol/$i_sol;
		if($isuma_sol>0)$resultado_costo_soles=$mul_suma_sol/$isuma_sol;
		
		//dolares
		//if($i_dol>0)$resultado_costo_dolares=$suma_costo_unitario_dol/$i_dol;
		if($isuma_dol==0)
		{
			$resultado_costo_dolares=$costo_dolares;
		}
		if($isuma_dol>0)$resultado_costo_dolares=$mul_suma_dol/$isuma_dol;
		
		
	}
	else
	{
		$resultado_costo_soles=$costo_soles;
		$resultado_costo_dolares=$costo_dolares;
	}
	
	//si no hay stock para la comparación
	/*if($stock_comparacion==0)
	{
		$resultado_costo_soles=$costo_soles;
		$resultado_costo_dolares=$costo_dolares;
	}*/
	
	$costo_ponderado['soles']=$resultado_costo_soles;
	$costo_ponderado['dolares']=$resultado_costo_dolares;
//	$costo_ponderado['datos']=$datos;
//	$costo_ponderado['datos2']=$datos2;
//	$costo_ponderado['datos3']=$datos3;
//	$costo_ponderado['datos4']=$datos4;
	
	return $costo_ponderado;
}
?>