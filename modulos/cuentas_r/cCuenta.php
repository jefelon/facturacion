<?php
class cCuenta{
	function insertar($cod,$des,$ord,$ele){
	$sql = "INSERT INTO tb_cuenta_r(
`tb_cuenta_cod` ,
`tb_cuenta_des` ,
`tb_cuenta_ord` ,
`tb_elemento_id`
)
VALUES (
'$cod',  '$des',  '$ord',  '$ele'
);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_cuenta_r ORDER BY tb_cuenta_des";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_oby($ele,$oby){
	$sql="SELECT * FROM tb_cuenta_r
	WHERE tb_elemento_id=$ele
	 ORDER BY tb_cuenta_$oby";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_cuenta_r 
WHERE tb_cuenta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$cod,$des,$ord,$ele){
	$sql = "UPDATE tb_cuenta_r SET
`tb_cuenta_cod` =  '$cod',
`tb_cuenta_des` =  '$des',
`tb_cuenta_ord` =  '$ord',
`tb_elemento_id` =  '$ele'
WHERE tb_cuenta_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_subcuenta` 
WHERE tb_cuenta_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function verificaE2($id){
		$sql = "SELECT * 
FROM  `tb_ingreso` 
WHERE tb_cuenta_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function verificaE3($id){
		$sql = "SELECT * 
FROM  `tb_gasto` 
WHERE tb_cuenta_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_cuenta_r WHERE tb_cuenta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>