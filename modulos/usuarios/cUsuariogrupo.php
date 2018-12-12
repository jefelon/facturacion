<?php
class cUsuariogrupo{
	function insertar($nom,$des){
	$sql = "INSERT INTO tb_usuariogrupo(
	`tb_usuariogrupo_nom`,
	`tb_usuariogrupo_des`
	)
	VALUES (
	'$nom', '$des'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_usuariogrupo ORDER BY tb_usuariogrupo_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_usuariogrupo 
	WHERE tb_usuariogrupo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$des){
	$sql = "UPDATE  tb_usuariogrupo	SET
	`tb_usuariogrupo_nom` =  '$nom',
	`tb_usuariogrupo_des` =  '$des'
	WHERE tb_usuariogrupo_id =$id"; 
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
	$sql="DELETE FROM tb_usuariogrupo WHERE tb_usuariogrupo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>