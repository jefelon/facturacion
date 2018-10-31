<?php
class cConductor{
	function insertar($tip,$nom,$doc,$dir,$tel,$ema, $lic, $cat, $tra_id){
	$sql = "INSERT tb_conductor(
	`tb_conductor_tip` ,
	`tb_conductor_nom` ,
	`tb_conductor_doc` ,
	`tb_conductor_dir` ,	
	`tb_conductor_tel` ,	
	`tb_conductor_ema` ,
	`tb_conductor_lic` ,
	`tb_conductor_cat` ,
	`tb_transporte_id`
	)
	VALUES (
	'$tip',  '$nom',  '$doc',  '$dir', '$tel', '$ema', '$lic', '$cat', '$tra_id'
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
	FROM tb_conductor c
	INNER JOIN tb_transporte t ON c.tb_transporte_id = t.tb_transporte_id
	ORDER BY tb_conductor_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_conductor c
	INNER JOIN tb_transporte t ON c.tb_transporte_id = t.tb_transporte_id
	
	WHERE tb_conductor_id=$id";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$tip,$nom,$doc,$dir,$tel,$ema, $lic, $cat, $tra_id){
	$sql = "UPDATE tb_conductor SET  
	`tb_conductor_tip` =  '$tip',
	`tb_conductor_nom` =  '$nom',
	`tb_conductor_doc` =  '$doc',
	`tb_conductor_dir` =  '$dir',	
	`tb_conductor_tel` =  '$tel',
	`tb_conductor_ema` =  '$ema',
	`tb_conductor_lic` =  '$lic',
	`tb_conductor_cat` =  '$cat',
	`tb_transporte_id` =  '$tra_id'
	WHERE tb_conductor_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_conductor_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_conductor_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_conductor WHERE tb_conductor_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function complete_nom($dato){
	$sql="SELECT *
		FROM tb_conductor
		WHERE tb_conductor_nom LIKE '%$dato%' OR tb_conductor_doc LIKE '%$dato%'
		GROUP BY tb_conductor_nom
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	
	function complete_nom_por_transporte($dato, $tra_id){
	$sql="SELECT *
		FROM tb_conductor c
		INNER JOIN tb_transporte t ON c.tb_transporte_id = t.tb_transporte_id
		WHERE (tb_conductor_nom LIKE '%$dato%' OR tb_conductor_doc LIKE '%$dato%') AND c.tb_transporte_id = $tra_id
		GROUP BY tb_conductor_nom
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
}
?>