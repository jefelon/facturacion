<?php
class cCajaobs{
	function insertar($usureg,$usumod,$xac,$fec,$det,$est,$caj_id,$emp_id){
	$sql = "INSERT INTO  tb_cajaobs(
	`tb_cajaobs_fecreg` ,
	`tb_cajaobs_fecmod` ,
	`tb_cajaobs_usureg` ,
	`tb_cajaobs_usumod` ,
	`tb_cajaobs_xac` ,
	`tb_cajaobs_fec` ,
	`tb_cajaobs_det` ,
	`tb_cajaobs_est` ,
	`tb_caja_id` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$usureg',  '$usumod',  '$xac', '$fec',  '$det',  '$est',  '$caj_id',  '$emp_id'
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
	function modificar($id,$usumod,$fec,$det,$est,$caj_id){
	$sql = "UPDATE  tb_cajaobs SET  
	`tb_cajaobs_fecmod` = NOW( ) ,
	`tb_cajaobs_usumod` =  '$usumod',
	`tb_cajaobs_fec` =  '$fec',
	`tb_cajaobs_det` =  '$det',
	`tb_cajaobs_est` =  '$est',
	`tb_caja_id` =  '$caj_id' 
	WHERE  tb_cajaobs_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_cajaobs ORDER BY tb_empresa_id,tb_cajaobs_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_emp($emp){
	$sql="SELECT * FROM tb_cajaobs
	WHERE tb_empresa_id=$emp
	ORDER BY tb_cajaobs_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function complete_det($emp,$det){
	$sql="SELECT DISTINCT(tb_cajaobs_det) FROM tb_cajaobs
	WHERE tb_empresa_id=$emp
	AND tb_cajaobs_det like '%$det%'
	ORDER BY tb_cajaobs_det
	LIMIT 0 , 10";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($emp_id,$caj_id,$est){
	$sql="SELECT * 
	FROM tb_cajaobs co
	INNER JOIN tb_caja c ON co.tb_caja_id = c.tb_caja_id
	WHERE tb_cajaobs_xac=1
	AND tb_empresa_id=$emp_id ";
	
		if($caj_id>0)$sql = $sql." AND co.tb_caja_id = $caj_id ";

		if($est!='')$sql = $sql." AND tb_cajaobs_est LIKE '$est' ";
		
		$sql = $sql." ORDER BY tb_cajaobs_fecreg ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verificar_cierre_caja($emp_id,$caj_id,$fec){
	$sql="SELECT * 
	FROM tb_cajaobs co
	INNER JOIN tb_caja c ON co.tb_caja_id = c.tb_caja_id
	WHERE tb_cajaobs_xac=1
	AND co.tb_empresa_id=$emp_id 
	AND co.tb_caja_id = $caj_id
	AND tb_cajaobs_fec LIKE '$fec' ";
		
	$sql = $sql." ORDER BY tb_cajaobs_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_cajaobs co
	INNER JOIN tb_caja c ON co.tb_caja_id = c.tb_caja_id
	WHERE tb_cajaobs_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_campo($id,$usumod,$campo,$valor){
	$sql = "UPDATE tb_cajaobs SET
	`tb_cajaobs_fecmod` = NOW( ) ,
	`tb_cajaobs_usumod` =  '$usumod',
	`tb_cajaobs_$campo` =  '$valor' 
	WHERE tb_cajaobs_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function eliminar($id){
	$sql="DELETE FROM tb_cajaobs WHERE tb_cajaobs_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>