<?php
class cKardex{
	function mostrar_kardex_por_producto($cat_id, $alm_id,$fecini,$fecfin){
	$sql="SELECT *
	FROM tb_notalmacen n
	INNER JOIN tb_notalmacendetalle nd ON n.tb_notalmacen_id = nd.tb_notalmacen_id
	INNER JOIN tb_almacen a ON n.tb_almacen_id = a.tb_almacen_id
	INNER JOIN tb_documento d ON n.tb_documento_id = d.tb_documento_id
	INNER JOIN tb_tipoperacion tp ON n.tb_tipoperacion_id = tp.tb_tipoperacion_id
	
	WHERE nd.tb_catalogo_id = $cat_id 
	AND n.tb_almacen_id = $alm_id ";
	
	if($fecini!="")$sql.=" AND tb_notalmacen_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_notalmacen_fec<='$fecfin' ";
	
	$sql.=" ORDER BY tb_notalmacen_fec, tb_notalmacen_cod";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	
	function mostrar_kardex_tipoperacion_por_producto($cat_id, $alm_id, $tipope_id){
	$sql="SELECT *
	FROM tb_notalmacen n
	INNER JOIN tb_notalmacendetalle nd ON n.tb_notalmacen_id = nd.tb_notalmacen_id
	INNER JOIN tb_almacen a ON n.tb_almacen_id = a.tb_almacen_id
	INNER JOIN tb_documento d ON n.tb_documento_id = d.tb_documento_id
	INNER JOIN tb_tipoperacion tp ON n.tb_tipoperacion_id = tp.tb_tipoperacion_id
	
	WHERE nd.tb_catalogo_id = $cat_id 
	AND n.tb_almacen_id = $alm_id
	AND n.tb_tipoperacion_id = $tipope_id
	ORDER BY n.tb_notalmacen_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	
	function inventario_tipo_por_producto($cat_id, $alm_id, $tip,$fecini,$fecfin,$emp_id){
	$sql="SELECT SUM( tb_notalmacendetalle_can ) AS cantidad
	FROM tb_notalmacen n
	INNER JOIN tb_notalmacendetalle nd ON n.tb_notalmacen_id = nd.tb_notalmacen_id

	WHERE n.tb_empresa_id = $emp_id
	AND nd.tb_catalogo_id = $cat_id 
	AND n.tb_notalmacen_tip = $tip ";
	
	if($alm_id>0)$sql.=" AND n.tb_almacen_id = $alm_id ";
	if($fecini!="")$sql.=" AND n.tb_notalmacen_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND n.tb_notalmacen_fec<='$fecfin' ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
	
	function mostrar_datos_producto($id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id = s.tb_presentacion_id
	INNER JOIN tb_almacen a ON a.tb_almacen_id = s.tb_almacen_id
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	LEFT JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	WHERE ct.tb_catalogo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>