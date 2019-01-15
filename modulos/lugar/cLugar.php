<?php
class cLugar{
	function insertar($lug){
	$sql = "INSERT tb_lugar (
		`tb_lugar_nom`
		)
		VALUES (
		 '$lug'
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
	FROM tb_lugar
	ORDER BY tb_lugar_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_lugar
	WHERE tb_lugar_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom){ 
	$sql = "UPDATE tb_lugar SET  
	`tb_lugar_nom` =  '$nom'
	WHERE  tb_lugar_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_lugar_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_lugar_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_lugar WHERE tb_lugar_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrarLugarHorario($salida_id,$llegada_id,$horario){
        $sql="SELECT * 
	    FROM tb_viajehorario vh
	    INNER JOIN tb_vehiculo v ON vh.tb_vehiculo_id = v.tb_vehiculo_id
	    WHERE vh.tb_viajehorario_salida=$salida_id AND vh.tb_viajehorario_llegada=$llegada_id";
        if($horario>0)$sql.=" AND vh.tb_viajehorario_horario = '$horario'";
	    $sql.=" ORDER BY tb_viajehorario_horario";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrarViajeHorario($id){
        $sql="SELECT * 
	    FROM tb_viajehorario vh
	    INNER JOIN tb_vehiculo v ON vh.tb_vehiculo_id = v.tb_vehiculo_id
	    WHERE vh.tb_viajehorario_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function insertarViajeHorario($salida_id,$llegada_id,$fech_salida,$hora,$vehiculo){
        $sql = "INSERT tb_viajehorario (
		`tb_viajehorario_salida`,
		`tb_viajehorario_llegada`,
		`tb_viajehorario_fecha`,
		`tb_viajehorario_horario`,
		`tb_vehiculo_id`
		)
		VALUES (
		 '$salida_id',
		 '$llegada_id',
		 '$fech_salida',
		 '$hora',
		 '$vehiculo'
		);";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>