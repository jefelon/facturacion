<?php
class cDireccion{
	function insertar($dir,$ubigeo, $usu){
	$sql = "INSERT INTO tb_direccion(
	`tb_direccion_dir`,
	`tb_ubigeo_cod`,
	`tb_usuario_id`
	)
	VALUES (
	'$dir', '$ubigeo', '$usu'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_direccion ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_usuario($id){
	$sql="SELECT * 
	FROM  tb_usuario u
	INNER JOIN tb_direccion d ON u.tb_usuario_id=d.tb_usuario_id
	WHERE u.tb_usuario_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_direccion 
	WHERE tb_direccion_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$dir,$ubigeo){
	$sql = "UPDATE  tb_direccion	SET
	`tb_direccion_dir` =  '$dir',
	`tb_ubigeo_cod` =  '$ubigeo'
	WHERE tb_direccion_id =$id"; 
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
	$sql="DELETE FROM tb_direccion WHERE tb_direccion_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_por_usuario($id){
	$sql="DELETE FROM tb_direccion WHERE tb_usuario_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>