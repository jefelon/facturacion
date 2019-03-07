<?php
class cRecursoshumanos{
	function insertar($id_cliente,$cargo,$fec_ingreso,$hor_ingreso,$fec_salida,$hor_salida, $tardanza,$falta,$permisos){
	$sql = "INSERT 	tb_recursoshumanos (
		`tb_cliente_id`,`tb_cargo`,`tb_fecha_ingreso`,`tb_hora_ingreso`,`tb_fecha_salida`,`tb_hora_salida`,
		`tb_tardanza`,`tb_falta`,`tb_permisos`
		)
		VALUES (
		 '$id_cliente','$cargo','$fec_ingreso','$hor_ingreso','$fec_salida','$hor_salida','$tardanza','$falta','$permisos'
		);";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function ultimoInsert(){
	$sql = "SELECT last_insert_id()"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT mp.tb_recursoshumanos_id, mp.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, mp.tb_fecha_ingreso, mp.tb_hora_ingreso, 
    mp.tb_fecha_salida,mp.tb_hora_salida, mp.tb_tardanza, mp.tb_falta, mp.tb_cargo,
    mp.tb_permisos
	FROM tb_recursoshumanos mp
	INNER JOIN tb_cliente cd ON mp.tb_cliente_id = cd.tb_cliente_id
	ORDER BY mp.tb_fecha_ingreso";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT mp.tb_recursoshumanos_id, mp.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, mp.tb_fecha_ingreso, mp.tb_hora_ingreso, 
    mp.tb_fecha_salida, mp.tb_hora_salida, mp.tb_tardanza, mp.tb_falta, mp.tb_cargo,
    mp.tb_permisos
	FROM tb_recursoshumanos mp
	INNER JOIN tb_cliente cd ON mp.tb_cliente_id = cd.tb_cliente_id
	WHERE tb_recursoshumanos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$id_cliente,$cargo,$fec_ingreso,$hor_ingreso,$fec_salida,$hor_salida,$tardanza,$falta,$permisos){
	$sql = "UPDATE tb_recursoshumanos SET  
    `tb_cliente_id` =  '$id_cliente',
    `tb_cargo` =  '$cargo',
	`tb_fecha_ingreso` =  '$fec_ingreso',
	`tb_hora_ingreso` =  '$hor_ingreso',
	`tb_fecha_salida` =  '$fec_salida',
	`tb_hora_salida` =  '$hor_salida',
	`tb_tardanza` =  '$tardanza',
	`tb_falta` =  '$falta',
	`tb_permisos` =  '$permisos'
	WHERE  tb_recursoshumanos_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_recursoshumanos_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_producto_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_recursoshumanos WHERE tb_recursoshumanos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>