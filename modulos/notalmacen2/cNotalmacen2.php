<?php
class cNotalmacen{
   ///////////////////////////////////////
   function mostrar_notalmacen_detalle2($notalm_id,$alm_id){
	$sql="SELECT * 
	FROM tb_notalmacen n 
	INNER JOIN tb_notalmacendetalle td ON n.tb_notalmacen_id = td.tb_notalmacen_id
	INNER JOIN tb_catalogo ct ON td.tb_catalogo_id = ct.tb_catalogo_id
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE ";
//	$sql.= "n.tb_notalmacen_id=$notalm_id 
//	AND";
	$sql.=" tb_notalmacen_tip=1
	AND tb_tipoperacion_id=1
	AND tb_almacen_id=$alm_id
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_catalogo($id){
	$sql="SELECT * 
	FROM tb_catalogo2
	WHERE tb_catalogo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_detalle_na($id, $cos, $pre){
	$sql = "UPDATE tb_notalmacendetalle SET  
	`tb_notalmacendetalle_cos` =  '$cos',
	`tb_notalmacendetalle_pre` =  '$pre' 
	WHERE  tb_notalmacendetalle_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
}
?>