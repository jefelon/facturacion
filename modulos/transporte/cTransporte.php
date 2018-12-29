<?php
session_start();
class cTransporte{
	function insertar($razsoc,$ruc,$dir,$tel,$ema){
	$sql = "INSERT tb_transporte(	
	`tb_transporte_razsoc` ,
	`tb_transporte_ruc` ,
	`tb_transporte_dir` ,	
	`tb_transporte_tel` ,
	`tb_transporte_ema`,
	`tb_empresa_id`
	)
	VALUES (
	'$razsoc',  '$ruc',  '$dir', '$tel', '$ema', '{$_SESSION['empresa_id']}'
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
	$sql="SELECT * FROM tb_transporte WHERE tb_empresa_id = '{$_SESSION['empresa_id']}' ORDER BY tb_transporte_razsoc";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_transporte 
	WHERE tb_transporte_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$razsoc,$ruc,$dir,$tel,$ema){
	$sql = "UPDATE tb_transporte SET  	
	`tb_transporte_razsoc` =  '$razsoc',
	`tb_transporte_ruc` =  '$ruc',
	`tb_transporte_dir` =  '$dir',
	`tb_transporte_tel` =  '$tel',
	`tb_transporte_ema` =  '$ema'
	WHERE tb_transporte_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_transporte_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_transporte_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_transporte WHERE tb_transporte_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function complete_razsoc($dato){
	$sql="SELECT *
		FROM tb_transporte
		WHERE tb_transporte_razsoc LIKE '%$dato%' OR tb_transporte_ruc LIKE '%$dato%' AND tb_empresa_id = '{$_SESSION['empresa_id']}'
		GROUP BY tb_transporte_razsoc
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
}
?>