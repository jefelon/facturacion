<?php
class cForm{
	function insertar($ele,$cat,$des,$ord){
	$sql = "INSERT tb_form(
	`tb_form_ele` ,
	`tb_form_cat` ,	
	`tb_form_des` ,
	`tb_form_ord` 
	)
	VALUES (
	'$ele',  '$cat',  '$des',  '$ord'
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
	$sql="SELECT * FROM tb_form ORDER BY tb_form_cat";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_form 
	WHERE tb_form_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$ele,$cat,$des,$ord){
	$sql = "UPDATE tb_form SET  
	`tb_form_ele` =  '$ele',
	`tb_form_cat` =  '$cat',
	`tb_form_des` =  '$des',
	`tb_form_ord` =  '$ord'
	WHERE tb_form_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos_cat($ele){
	$sql="SELECT DISTINCT (
	tb_form_cat
	)
	FROM tb_form
	WHERE tb_form_ele LIKE  '$ele'
	ORDER BY tb_form_cat";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_des($ele,$cat){
	$sql="SELECT * FROM tb_form
	WHERE tb_form_ele LIKE '$ele' 
	AND tb_form_cat LIKE '$cat'
	ORDER BY tb_form_des";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_des_ord($ele,$cat,$ord){
	$sql="SELECT * FROM tb_form
	WHERE tb_form_ele LIKE '$ele' 
	AND tb_form_cat LIKE '$cat'
	ORDER BY tb_form_$ord";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_form_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_form_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_form WHERE tb_form_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>