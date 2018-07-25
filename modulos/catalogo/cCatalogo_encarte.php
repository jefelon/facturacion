<?php
class cCatalogo{
	function catalogo_encarte_filtro($nom,$cod,$cat,$mar,$est,$limit){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE ct.tb_catalogo_vercom=1
	AND tb_producto_est LIKE '%$est%' ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	$sql.=" ORDER BY tb_producto_nom ";
	
	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>