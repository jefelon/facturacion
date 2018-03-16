<?php
class cCuadromi{
	function num_registros($tabla){
	$sql="SELECT COUNT(*) AS numero
	FROM  $tabla";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function num_reg_ope_fecha($tabla,$atributo,$dato,$emp_id){
	$sql="SELECT COUNT(*) AS numero FROM $tabla t 
	WHERE t.tb_empresa_id = $emp_id
	AND $atributo LIKE '$dato';";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function num_reg_ope_fecha_ven($tabla,$atributo,$dato,$usu_id,$punven_id){
	$sql="SELECT COUNT(*) AS numero FROM $tabla t
	WHERE t.tb_puntoventa_id = $punven_id
	AND $atributo LIKE '$dato'
	AND tb_usuario_id=$usu_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function producto_mas_ope($tabla_det,$tabla,$union,$atributo,$dato,$emp_id,$filas){
	$sql="SELECT p.tb_producto_id, p.tb_producto_nom, pr.tb_presentacion_id, pr.tb_presentacion_nom, u.tb_unidad_id, u.tb_unidad_abr, ct.tb_catalogo_mul,  COUNT(*) AS numero
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN $tabla_det dt ON ct.tb_catalogo_id = dt.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	INNER JOIN $tabla op ON $union
	WHERE op.tb_empresa_id = $emp_id 
	AND $atributo LIKE '$dato'
	GROUP BY p.tb_producto_id, pr.tb_presentacion_id, u.tb_unidad_id
	ORDER BY numero DESC, ct.tb_catalogo_mul DESC
	LIMIT 0,$filas ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function total_ope($campo_sumar,$tabla,$campo_fec,$fec,$campo_est,$est,$emp_id){
	$sql="SELECT SUM($campo_sumar) as total
	FROM $tabla t
	WHERE t.tb_empresa_id = $emp_id
	AND $campo_fec LIKE '$fec'
	AND $campo_est LIKE '$est' ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function total_ope_usu($campo_sumar,$tabla,$campo_fec,$fec,$campo_est,$est,$usu_id,$punven_id){
	$sql="SELECT SUM($campo_sumar) as total
	FROM $tabla t
	WHERE t.tb_puntoventa_id = $punven_id
	AND $campo_fec LIKE '$fec'
	AND $campo_est LIKE '$est'
	AND tb_usuario_id=$usu_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function producto_debajo_stock($alm_id){
	$sql="SELECT *
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id
	WHERE tb_presentacion_stomin>s.tb_stock_num
	AND s.tb_almacen_id=$alm_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>