<?php
class cVenta{
function mostrar_filtro_adm($y,$m,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id	
	WHERE v.tb_empresa_id = $emp_id 
	AND YEAR(v.tb_venta_fec)=$y ";

	if($m>0)$sql.=" AND MONTH(v.tb_venta_fec)=$m ";
	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	//$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function grafico_productos_ventas($y,$m,$cat_id,$catego_ids,$mar_id,$cli_id,$est,$usu_id,$punven_id,$emp_id){
	$sql="SELECT tb_venta_est, tb_ventadetalle_tipven, p.tb_producto_id, p.tb_producto_nom, m.tb_marca_nom, cg.tb_categoria_nom, pr.tb_presentacion_id, pr.tb_presentacion_nom, un.tb_unidad_id, un.tb_unidad_abr, ct.tb_catalogo_mul, SUM(tb_ventadetalle_can) AS can, SUM(tb_ventadetalle_preuni) AS preuni, SUM(tb_ventadetalle_valven) AS valven, SUM(tb_ventadetalle_igv) AS igv
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_ventadetalle vd ON v.tb_venta_id = vd.tb_venta_id
	
	INNER JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	WHERE v.tb_empresa_id = $emp_id 
	AND YEAR(v.tb_venta_fec)=$y ";
	if($m>0)$sql.=" AND MONTH(v.tb_venta_fec)=$m ";
	
	if($cat_id>0)$sql.=" AND ct.tb_catalogo_id = $cat_id ";
	if($catego_ids!="")$sql.=" AND p.tb_categoria_id IN ($catego_ids) ";
	if($mar_id>0)$sql.=" AND p.tb_marca_id = $mar_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" GROUP BY p.tb_producto_id, pr.tb_presentacion_id, un.tb_unidad_id ";
	
	//$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>