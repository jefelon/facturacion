<?php
class cAsiento{
	function insertar($nom,$emp_id){
	$sql = "INSERT tb_asiento (
		`tb_asiento_nom`,
		`tb_empresa_id`
		)
		VALUES (
		 '$nom', '$emp_id'
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
	FROM tb_asiento
	ORDER BY tb_asiento_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function mostrarFiltroFila($desde,$hasta){
        $sql="SELECT * 
	FROM tb_asiento
	WHERE tb_asiento_nom between '$desde' AND'$hasta'
	ORDER BY tb_asiento_nom ASC ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_asiento
	WHERE tb_asiento_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom){ 
	$sql = "UPDATE tb_asiento SET  
	`tb_asiento_nom` =  '$nom'
	WHERE  tb_asiento_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_asiento_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_asiento_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_asiento WHERE tb_asiento_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>