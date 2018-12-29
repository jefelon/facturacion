<?php
session_start();
class cTipoCambio{
	function insertar($fec,$dolsun){
	$sql = "INSERT tb_tipocambio(
	`tb_tipocambio_reg` ,
	`tb_tipocambio_mod` ,
	`tb_tipocambio_fec` ,
	`tb_tipocambio_dolsun`
	`tb_empresa_id
	)
	VALUES (
	NOW( ), NOW( ), '$fec','$dolsun', '{$_SESSION['empresa_id']}'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function ultimoInsert(){
	$sql = "SELECT last_insert_id() WHERE tb_empresa_id='{$_SESSION['empresa_id']}'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_tipocambio
    WHERE tb_empresa_id = '{$_SESSION['empresa_id']}'
	ORDER BY tb_tipocambio_fec DESC";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_tipocambio 
	WHERE tb_tipocambio_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$fec,$dolsun,$dol){
	$sql = "UPDATE tb_tipocambio SET  	
	`tb_tipocambio_mod` =  NOW(),
	`tb_tipocambio_fec` =  '$fec',
	`tb_tipocambio_dolsun` =  '$dolsun'
	WHERE tb_tipocambio_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_tipocambio_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_tipocambio_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_tipocambio WHERE tb_tipocambio_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function consultar($fec){
	$sql="SELECT *
	FROM tb_tipocambio 
	WHERE tb_tipocambio_fec='$fec' AND tb_empresa_id = '{$_SESSION['empresa_id']}'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>