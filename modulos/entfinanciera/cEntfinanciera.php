<?php
class cEntfinanciera{
	function insertar($d1){
	$sql = "INSERT tb_entfinanciera(
`tb_entfinanciera_nom`
)
VALUES (
'$d1'
);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_entfinanciera ORDER BY tb_entfinanciera_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_entfinanciera 
WHERE tb_entfinanciera_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$d1){
	$sql = "UPDATE tb_entfinanciera SET  
`tb_entfinanciera_nom` =  '$d1'
WHERE tb_entfinanciera_id =$id"; 
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
	$sql="DELETE FROM tb_entfinanciera WHERE tb_entfinanciera_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>