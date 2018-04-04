<?php
session_start();
class cUnidad{
	function insertar($abr,$nom, $tip){
	$sql = "INSERT tb_unidad (
		`tb_unidad_abr`,
		`tb_unidad_nom`,
		`tb_unidad_tip`,
		`tb_empresa_id`
		)
		VALUES (
		 '$abr', '$nom', '$tip', '{$_SESSION['empresa_id']}'
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
	FROM tb_unidad
	WHERE tb_empresa_id={$_SESSION['empresa_id']}
	ORDER BY tb_unidad_tip, tb_unidad_abr";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_tipo(){
	$sql="SELECT * 
	FROM tb_unidad
	WHERE tb_empresa_id={$_SESSION['empresa_id']}
	GROUP BY tb_unidad_tip";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_tipo($tip){
	$sql="SELECT * 
	FROM tb_unidad
	WHERE tb_unidad_tip=$tip AND tb_empresa_id={$_SESSION['empresa_id']}
	ORDER BY tb_unidad_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_unidad
	WHERE tb_unidad_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$abr,$nom,$tip){ 
	$sql = "UPDATE tb_unidad SET  
	`tb_unidad_abr` =  '$abr',
	`tb_unidad_nom` =  '$nom',
	`tb_unidad_tip` =  '$tip'
	WHERE  tb_unidad_id =$id AND tb_empresa_id={$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_unidad_tabla($id,$tabla,$atributo){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE $atributo=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){

	$sql="DELETE FROM tb_unidad WHERE tb_unidad_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>