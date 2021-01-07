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

    function mostrarFechaHorario($salida_id,$llegada_id,$fecha){
        $sql="SELECT * 
	    FROM tb_viajehorario vh
	    INNER JOIN tb_vehiculo v ON v.tb_vehiculo_id=vh.tb_vehiculo_id
	    INNER JOIN tb_conductor c ON c.tb_conductor_id=vh.tb_conductor_id
	    WHERE vh.tb_viajehorario_salida='$salida_id' AND vh.tb_viajehorario_llegada='$llegada_id' AND vh.tb_viajehorario_fecha='$fecha'";
        $sql.=" ORDER BY tb_viajehorario_horario";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrarVehiculo($salida_id,$llegada_id,$fecha,$horario){
        $sql="SELECT * 
	    FROM tb_viajehorario vh
	    INNER JOIN tb_vehiculo v ON vh.tb_vehiculo_id = v.tb_vehiculo_id
	    WHERE vh.tb_viajehorario_salida='$salida_id' 
	      AND vh.tb_viajehorario_llegada='$llegada_id'
	      AND vh.tb_viajehorario_fecha='$fecha' 
	      AND vh.tb_viajehorario_horario='$horario'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


    function mostrarFechas($salida_id,$llegada_id){
        $fecha_actual = date('Y-m-d H:i:s');
        $fecha=date("Y-m-d H:i:s",strtotime($fecha_actual."- 8888 minute"));

        $nuevafecha = strtotime ( '+30 day' , strtotime ( $fecha ) ) ;
        $nuevafecha = date ( 'Y-m-d' , $nuevafecha );


        $sql="SELECT DISTINCT tb_viajehorario_fecha
	    FROM tb_viajehorario vh
	    INNER JOIN tb_vehiculo v ON vh.tb_vehiculo_id = v.tb_vehiculo_id  
	    WHERE vh.tb_viajehorario_salida=$salida_id AND vh.tb_viajehorario_llegada=$llegada_id AND tb_viajehorario_fecha BETWEEN '$fecha' AND '$nuevafecha'";

        $sql.=" ORDER BY tb_viajehorario_fecha";
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

    function insertarViajeHorario($salida_id,$llegada_id,$fech_salida,$hora,$vehiculo,$conductor,$copiloto,$ser,$num){
        $sql = "INSERT tb_viajehorario (
		`tb_viajehorario_salida`,
		`tb_viajehorario_llegada`,
		`tb_viajehorario_fecha`,
		`tb_viajehorario_horario`,
		`tb_vehiculo_id`,
		`tb_conductor_id`,
		`tb_copiloto_id`,
		`tb_viajehorario_ser`,
		`tb_viajehorario_num`
		)
		VALUES (
		 '$salida_id',
		 '$llegada_id',
		 '$fech_salida',
		 '$hora',
		 '$vehiculo',
		 '$conductor',
		 '$copiloto',
		 '$ser',
		 '$num'
		);";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function modificar_vh_vehiculo($vh_ho_id, $vehiculo_id,$conductor_id,$copiloto_id){
        $sql = "UPDATE tb_viajehorario SET  
	`tb_vehiculo_id` =  '$vehiculo_id',
	`tb_conductor_id` =  '$conductor_id',
	`tb_copiloto_id` =  '$copiloto_id'
	WHERE  tb_viajehorario_id =$vh_ho_id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>