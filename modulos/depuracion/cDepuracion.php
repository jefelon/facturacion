<?php
class cDepuracion{
	function mostrarTodos(){
	$sql="SELECT * 
	FROM tb_almacen
	ORDER BY tb_almacen_nom";
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