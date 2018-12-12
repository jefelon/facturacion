<?php
class cHistorial{	
	function consultar_historial_compras_por_producto($cat_id,$alm_id,$fecini,$fecfin,$ord_fec,$emp_id){		
	$sql="SELECT *
	FROM tb_catalogo ct
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id=pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id=p.tb_producto_id
	INNER JOIN tb_compradetalle cd ON ct.tb_catalogo_id = cd.tb_catalogo_id
	INNER JOIN tb_compra c ON c.tb_compra_id = cd.tb_compra_id
	INNER JOIN tb_documento d ON c.tb_documento_id = d.tb_documento_id
	WHERE ct.tb_catalogo_id = $cat_id 
	AND c.tb_compra_est IN ('CONTADO', 'CREDITO') ";
	
	if($emp_id>0)$sql.=" AND c.tb_empresa_id = $emp_id ";
	if($alm_id>0)$sql.=" AND c.tb_almacen_id = $alm_id ";
	if($fecini!="")$sql.=" AND tb_compra_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_compra_fec<='$fecfin' ";
	
	$sql.=" ORDER BY c.tb_compra_fec $ord_fec, c.tb_compra_reg $ord_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	
	function consultar_historial_ventas_por_producto($cat_id,$alm_id,$fecini,$fecfin){		
	$sql="SELECT *
	FROM tb_catalogo ct
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id=pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id=p.tb_producto_id
	INNER JOIN tb_ventadetalle vd ON ct.tb_catalogo_id = vd.tb_catalogo_id
	INNER JOIN tb_venta v ON vd.tb_venta_id = v.tb_venta_id 
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id = pv.tb_puntoventa_id
	INNER JOIN tb_documento d ON v.tb_documento_id = d.tb_documento_id
	WHERE ct.tb_catalogo_id = $cat_id 
	AND v.tb_venta_est IN ('CANCELADA')
	AND pv.tb_almacen_id = $alm_id ";
	
	if($fecini!="")$sql.=" AND tb_venta_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_venta_fec<='$fecfin' ";
	
	$sql.=" ORDER BY v.tb_venta_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	
	function consultar_historial_ventanotas_por_producto($cat_id,$alm_id,$fecini,$fecfin){		
	$sql="SELECT *
	FROM tb_catalogo ct
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id=pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id=p.tb_producto_id
	INNER JOIN tb_ventanotadetalle vd ON ct.tb_catalogo_id = vd.tb_catalogo_id
	INNER JOIN tb_ventanota v ON vd.tb_venta_id = v.tb_venta_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id = pv.tb_puntoventa_id
	INNER JOIN tb_documento d ON v.tb_documento_id = d.tb_documento_id
	WHERE ct.tb_catalogo_id = $cat_id 
	AND v.tb_venta_est IN ('CANCELADA')
	AND pv.tb_almacen_id = $alm_id ";
	
	if($fecini!="")$sql.=" AND tb_venta_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_venta_fec<='$fecfin' ";
	
	$sql.="	ORDER BY tb_venta_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	
	function consultar_historial_traspasos_entrada_por_producto($cat_id, $alm_id,$fecini,$fecfin){		
	$sql="
	SELECT t.tb_traspaso_id AS traspaso_id, t.tb_traspaso_fec AS fecha, ao.tb_almacen_nom AS origen, ad.tb_almacen_nom AS destino, td.tb_traspasodetalle_can AS cantidad
	FROM tb_catalogo ct
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id=pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id=p.tb_producto_id
	INNER JOIN tb_traspasodetalle td ON ct.tb_catalogo_id = td.tb_catalogo_id
	INNER JOIN tb_traspaso t ON td.tb_traspaso_id = t.tb_traspaso_id 
	INNER JOIN tb_almacen ao ON t.tb_almacen_id_ori = ao.tb_almacen_id
	INNER JOIN tb_almacen ad ON t.tb_almacen_id_des = ad.tb_almacen_id 
	WHERE ct.tb_catalogo_id = $cat_id 
	AND t.tb_traspaso_act IN ('1')
	AND ad.tb_almacen_id = $alm_id ";
	
	if($fecini!="")$sql.=" AND tb_traspaso_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_traspaso_fec<='$fecfin' ";
	
	$sql.=" ORDER BY tb_traspaso_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	
	function consultar_historial_traspasos_salida_por_producto($cat_id, $alm_id,$fecini,$fecfin){		
	$sql="SELECT t.tb_traspaso_id AS traspaso_id, t.tb_traspaso_fec AS fecha, ao.tb_almacen_nom AS origen, ad.tb_almacen_nom AS destino, td.tb_traspasodetalle_can AS cantidad
	FROM tb_catalogo ct
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id=pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id=p.tb_producto_id
	INNER JOIN tb_traspasodetalle td ON ct.tb_catalogo_id = td.tb_catalogo_id
	INNER JOIN tb_traspaso t ON td.tb_traspaso_id = t.tb_traspaso_id 
	INNER JOIN tb_almacen ao ON t.tb_almacen_id_ori = ao.tb_almacen_id
	INNER JOIN tb_almacen ad ON t.tb_almacen_id_des = ad.tb_almacen_id 
	WHERE ct.tb_catalogo_id = $cat_id 
	AND t.tb_traspaso_act IN ('1')
	AND ao.tb_almacen_id = $alm_id ";
	
	if($fecini!="")$sql.=" AND tb_traspaso_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_traspaso_fec<='$fecfin' ";
	
	$sql.=" ORDER BY tb_traspaso_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	function consultar_historial_notalmacen_entrada_por_producto($cat_id, $alm_id,$fecini,$fecfin){
	$sql="SELECT *
	FROM tb_notalmacen n
	INNER JOIN tb_notalmacendetalle nd ON n.tb_notalmacen_id = nd.tb_notalmacen_id
	INNER JOIN tb_almacen a ON n.tb_almacen_id = a.tb_almacen_id
	INNER JOIN tb_documento d ON n.tb_documento_id = d.tb_documento_id
	INNER JOIN tb_tipoperacion tp ON n.tb_tipoperacion_id = tp.tb_tipoperacion_id
	
	WHERE nd.tb_catalogo_id = $cat_id 
	AND n.tb_almacen_id = $alm_id 
	AND tb_notalmacen_tipreg = 2
	AND tb_notalmacen_tip = 1
	";
	
	if($fecini!="")$sql.=" AND tb_notalmacen_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_notalmacen_fec<='$fecfin' ";
	
	$sql.=" ORDER BY tb_notalmacen_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	function consultar_historial_notalmacen_salida_por_producto($cat_id, $alm_id,$fecini,$fecfin){
	$sql="SELECT *
	FROM tb_notalmacen n
	INNER JOIN tb_notalmacendetalle nd ON n.tb_notalmacen_id = nd.tb_notalmacen_id
	INNER JOIN tb_almacen a ON n.tb_almacen_id = a.tb_almacen_id
	INNER JOIN tb_documento d ON n.tb_documento_id = d.tb_documento_id
	INNER JOIN tb_tipoperacion tp ON n.tb_tipoperacion_id = tp.tb_tipoperacion_id
	
	WHERE nd.tb_catalogo_id = $cat_id 
	AND n.tb_almacen_id = $alm_id 
	AND tb_notalmacen_tipreg = 2
	AND tb_notalmacen_tip = 2
	";
	
	if($fecini!="")$sql.=" AND tb_notalmacen_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_notalmacen_fec<='$fecfin' ";
	
	$sql.=" ORDER BY tb_notalmacen_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
}
?>