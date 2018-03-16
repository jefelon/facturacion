<?php
class cSubcuenta{
	function insertar($d1,$d2,$ord,$id1){
	$sql = "INSERT INTO tb_subcuenta_r(
	`tb_subcuenta_cod` ,
	`tb_subcuenta_des` ,
	`tb_subcuenta_ord` ,
	`tb_cuenta_id`
	)
	VALUES (
	'$d1',  '$d2',  '$ord',  '$id1'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_subcuenta_r ORDER BY tb_subcuenta_des";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_cue_oby($id1,$oby){
	$sql="SELECT * FROM tb_subcuenta_r 
	WHERE tb_cuenta_id=$id1 
	ORDER BY tb_subcuenta_$oby";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_cue($id1){
	$sql="SELECT * FROM tb_subcuenta_r WHERE tb_cuenta_id=$id1";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_subcuenta_r 
WHERE tb_subcuenta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$d1,$d2,$ord,$id1){
	$sql = "UPDATE tb_subcuenta_r SET
	`tb_subcuenta_cod` =  '$d1',
`tb_subcuenta_des` =  '$d2',
`tb_subcuenta_ord` =  '$ord',
`tb_cuenta_id` =  '$id1' 
WHERE tb_subcuenta_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_ingreso` 
WHERE tb_subcuenta_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function verificaE2($id){
		$sql = "SELECT * 
FROM  `tb_gasto` 
WHERE tb_subcuenta_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_subcuenta_r WHERE tb_subcuenta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>