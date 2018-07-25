<?php
class cAlmacen{
	function insertar($nom,$ven,$emp_id){
	$sql = "INSERT tb_almacen (
		`tb_almacen_nom`,
		`tb_almacen_ven`,
		`tb_empresa_id`		
		)
		VALUES (
		 '$nom','$ven', '$emp_id'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos($emp_id){
	$sql="SELECT * 
	FROM tb_almacen
	WHERE tb_empresa_id = '$emp_id'
	ORDER BY tb_almacen_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_empresa($emp_id){
	$sql="SELECT * 
	FROM tb_almacen
	WHERE tb_empresa_id = '$emp_id'
	ORDER BY tb_almacen_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_para_venta($emp_id){
	$sql="SELECT * 
	FROM tb_almacen
	WHERE tb_almacen_ven=1 AND tb_empresa_id = '$emp_id'
	ORDER BY tb_almacen_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_almacen
	WHERE tb_almacen_id=$id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$ven){ 
	$sql = "UPDATE tb_almacen SET  
	`tb_almacen_nom` =  '$nom',
	`tb_almacen_ven` =  '$ven'
	WHERE  tb_almacen_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_almacen_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_almacen_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_almacen WHERE tb_almacen_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>