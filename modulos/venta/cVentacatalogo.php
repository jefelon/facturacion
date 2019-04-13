<?php
class cVentacatalogo{

	function mostrar_catalogo($pro_nom,$alm_id,$limit){
		$sql="SELECT * 
		FROM tb_producto p
		INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
		INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
		INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
		LEFT JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id
		WHERE tb_producto_nom LIKE '%$pro_nom%' ";

		if($alm_id>0)$sql.=" AND s.tb_almacen_id = $alm_id ";

		$sql.=" GROUP BY tb_producto_nom ";

		if($limit>0)$sql.=" LIMIT 0,$limit ";

		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;		  
	}
	function precios_min_may($catalogo_id){
		$sql = "SELECT * FROM tb_preciodetalle where tb_catalogo_id =$catalogo_id limit 2";
		$oCado = new Cado();
		$rst = $oCado->ejecute_sql($sql);
		return $rst;
	}
}
/*

*/
?>