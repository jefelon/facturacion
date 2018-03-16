<?php
class cFormula{
	function insertar($ele,$ide,$dat,$des){
	$sql = "INSERT tb_formula(
	`tb_formula_ele` ,
	`tb_formula_ide` ,
	`tb_formula_dat` ,
	`tb_formula_des` 
	)
	VALUES (
	'$ele',  '$ide',  '$dat',  '$des'
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
	$sql="SELECT * FROM tb_formula ORDER BY tb_formula_ide";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_formula 
	WHERE tb_formula_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$ele,$ide,$dat,$des){
	$sql = "UPDATE tb_formula SET  
	`tb_formula_ele` =  '$ele',
	`tb_formula_ide` =  '$ide',
	`tb_formula_dat` =  '$dat',
	`tb_formula_des` =  '$des'
	WHERE tb_formula_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_formula_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_formula_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_formula WHERE tb_formula_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function consultar_dato_formula($ide){
	//Cuando se comparan cadenas colocar las comillas simples
	$sql="SELECT * 
	FROM tb_formula 
	WHERE tb_formula_ide = '$ide';";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
}
?>