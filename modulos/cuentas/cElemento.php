<?php
class cElemento{
	function insertar($cod,$des,$ord){
	$sql = "INSERT INTO tb_elemento(
`tb_elemento_cod` ,
`tb_elemento_des` ,
`tb_elemento_ord`
)
VALUES (
'$cod',  '$des',  '$ord'
);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_elemento ORDER BY tb_elemento_des";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_oby($oby){
	$sql="SELECT * FROM tb_elemento ORDER BY tb_elemento_$oby";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_elemento 
WHERE tb_elemento_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$cod,$des,$ord){
	$sql = "UPDATE tb_elemento SET
`tb_elemento_cod` =  '$cod',
`tb_elemento_des` =  '$des',
`tb_elemento_ord` =  '$ord'
WHERE tb_elemento_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_usosoftware` 
WHERE tb_software_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_elemento WHERE tb_elemento_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>