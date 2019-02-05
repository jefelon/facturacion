<?php
class cRecepcionDocumentos{
	function insertar($fec,$id_cliente,$perspentrega_id,$persrecepcion_id,$persrecoge_id,$pendiente,$obs){
	$sql = "INSERT tb_recepciondocumentos (
		`tb_recepciondocumentos_fecha`,`tb_cliente_id`,`tb_perspentrega_id`,`tb_persrecepcion_id`,`tb_persrecoge_id`,`tb_recepciondocumentos_pendientes`
		,`tb_recepciondocumentos_observacion`
		)
		VALUES (
		 '$fec','$id_cliente','$perspentrega_id','$persrecepcion_id','$persrecoge_id','$pendiente','$obs'
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
	$sql="SELECT * 
	FROM tb_recepciondocumentos
	ORDER BY tb_recepciondocumentos_fecha";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_recepciondocumentos
	WHERE tb_recepciondocumentos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom){ 
	$sql = "UPDATE tb_recepciondocumentos SET  
	`tb_recepciondocumentos_nom` =  '$nom'
	WHERE  tb_recepciondocumentos_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_recepciondocumentos_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_recepciondocumentos_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_recepciondocumentos WHERE tb_recepciondocumentos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>