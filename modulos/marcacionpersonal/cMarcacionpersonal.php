<?php
class cMarcacionpersonal{
	function insertar($id_cliente,$fec_ingreso,$fec_salida, $tardanza,$falta,$permisos){
	$sql = "INSERT 	tb_marcacionpersonal (
		`tb_cliente_id`,`tb_fecha_ingreso`,`tb_fecha_salida`,`tb_tardanza`,`tb_falta`,`tb_permisos`
		)
		VALUES (
		 '$id_cliente','$fec_ingreso','$fec_salida','$tardanza','$falta','$permisos'
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
	$sql="SELECT mp.tb_marcacionpersonal_id, mp.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, mp.tb_fecha_ingreso, mp.tb_fecha_salida, mp.tb_tardanza, 
    mp.tb_permisos
	FROM tb_marcacionpersonal mp
	INNER JOIN tb_cliente cd ON mp.tb_cliente_id = cd.tb_cliente_id
	ORDER BY mp.tb_fecha_ingreso";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT mp.tb_marcacionpersonal_id, mp.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, mp.tb_fecha_ingreso, mp.tb_fecha_salida, mp.tb_tardanza, 
    mp.tb_permisos
	FROM tb_marcacionpersonal mp
	INNER JOIN tb_cliente cd ON mp.tb_cliente_id = cd.tb_cliente_id
	ORDER BY mp.tb_fecha_ingreso
	WHERE tb_marcacionpersonal_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$id_cliente,$fec_ingreso,$fec_salida, $tardanza,$falta,$permisos){
	$sql = "UPDATE tb_marcacionpersonal SET  
    `tb_cliente_id` =  '$id_cliente',
	`tb_fecha_ingreso` =  '$fec_ingreso',
	`tb_fecha_salida` =  '$fec_salida',
	`tb_tardanza` =  '$tardanza',
	`tb_falta` =  '$falta',
	`tb_permisos` =  '$permisos'
	WHERE  tb_marcacionpersonal_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_marcacionpersonal_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_producto_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_marcacionpersonal WHERE tb_marcacionpersonal_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>