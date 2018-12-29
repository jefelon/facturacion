<?php
session_start();
class cTipoperacion{
	function insertar($nom,$tip,$man){
	$sql = "INSERT tb_tipoperacion (
		`tb_tipoperacion_nom`,
		`tb_tipoperacion_tip`,
		`tb_tipoperacion_man`,
		`tb_empresa_id`	
		)
		VALUES (
		 '$nom','$tip','$man', '{$_SESSION['empresa_id']}'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * 
	FROM tb_tipoperacion
	WHERE tb_tipoperacion_man=1 AND tb_empresa_id = '{$_SESSION['empresa_id']}'
	ORDER BY tb_tipoperacion_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_tipo($tip_id,$man){
	$sql="SELECT * 
	FROM tb_tipoperacion
	WHERE tb_tipoperacion_tip = '$tip_id' AND tb_empresa_id = '{$_SESSION['empresa_id']}'";
	
	if($man!="")$sql.="	AND tb_tipoperacion_man = $man ";
	
	$sql.=" ORDER BY tb_tipoperacion_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_tipoperacion
	WHERE tb_tipoperacion_id=$id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$tip){ 
	$sql = "UPDATE tb_tipoperacion SET  
	`tb_tipoperacion_nom` =  '$nom',
	`tb_tipoperacion_tip` =  '$tip'
	WHERE  tb_tipoperacion_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_tipoperacion_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_tipoperacion_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_tipoperacion WHERE tb_tipoperacion_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>