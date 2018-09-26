<?php
class cLetras{
	function insertar($ven_id, $fec, $monto, $orden,  $numero){
	$sql = "INSERT tb_letras (
		`tb_venta_id`,
		`tb_letras_fecha`,
		`tb_letras_monto`,
		`tb_letras_orden`,
		`tb_letras_numero`
		)
		VALUES (
		 '$ven_id',
		 '$fec',
		 '$monto',
		 '$orden',
		 '$numero'
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
	FROM tb_letras
	ORDER BY tb_letras_orden";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_letras($ven_id){
        $sql="SELECT * 
	FROM tb_letras
	WHERE tb_venta_id=$ven_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_letras
	WHERE tb_letras_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $monto){
	$sql = "UPDATE tb_lote SET  
	`tb_letras_monto` =  '$monto'
	WHERE  tb_letras_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_letras_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_letras_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_letras WHERE tb_letras_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function actual_numero_letra(){
        $sql="SELECT max(tb_letras_numero) as max_letras FROM tb_letras";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>