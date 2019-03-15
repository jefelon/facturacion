<?php
class cCajadetalle{
	function insertar($caja_id, $fec_apertura, $fec_cierre, $inicial, $estado,$usuario_id){
	$sql = "INSERT tb_cajadetalle (
		`tb_caja_id`,
		`tb_caja_apertura`,
		`tb_caja_cierre`,
		`tb_caja_inicial`,
		`tb_caja_estado`,
		`tb_usuario_id`
		)
		VALUES (
		 '$caja_id', '$fec_apertura', '$fec_cierre', '$inicial', '$estado', '$usuario_id'
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

    function ultimoInsertCaja($caja_id){
        $sql = "SELECT * 
        FROM tb_cajadetalle 
        WHERE tb_caja_id=$caja_id 
        ORDER BY tb_cajadetalle_id DESC LIMIT 1";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


	function mostrarTodos(){
	$sql="SELECT * 
	FROM tb_cajadetalle
	ORDER BY tb_caja_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrarTodosCaja($id,$usuario_id,$limit){
        $sql="SELECT * 
	FROM tb_cajadetalle
    WHERE tb_caja_id=$id AND tb_usuario_id=$usuario_id
    ORDER BY tb_cajadetalle_id DESC LIMIT 20";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_cajadetalle c
	INNER JOIN tb_puntoventa pv ON c.tb_caja_id=pv.tb_caja_id
	WHERE c.tb_cajadetalle_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom){ 
	$sql = "UPDATE tb_caja SET  
	`tb_caja_nom` =  '$nom'
	WHERE  tb_caja_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
    function modificar_fec_cierre($id,$est,$final){
        $sql = "UPDATE tb_cajadetalle SET  
	`tb_caja_cierre` =  NOW(),
	`tb_caja_estado` =  '$est',
	`tb_caja_final` =  '$final'
	WHERE  tb_cajadetalle_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function verifica_caja_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_caja_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_caja WHERE tb_caja_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>