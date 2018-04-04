<?php
session_start();
class cTarjeta{
	function insertar($nom,$caj_id){
	$sql = "INSERT tb_tarjeta (
		`tb_tarjeta_nom`,
		`tb_caja_id`,
		`tb_empresa_id`
		)
		VALUES (
		 '$nom', '$caj_id', '{$_SESSION['empresa_id']}'
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
	FROM tb_tarjeta t
	LEFT JOIN tb_caja c ON t.tb_caja_id=c.tb_caja_id
	WHERE tb_empresa_id={$_SESSION['empresa_id']}
	ORDER BY tb_tarjeta_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_tarjeta
	WHERE tb_tarjeta_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$caj_id){ 
	$sql = "UPDATE tb_tarjeta SET  
	`tb_tarjeta_nom` =  '$nom',
	`tb_caja_id` =  '$caj_id'
	WHERE  tb_tarjeta_id =$id AND tb_empresa_id={$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_tarjeta_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_tarjeta_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_tarjeta WHERE tb_tarjeta_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>