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
	WHERE tb_asiento_nom between '$desde' AND '$hasta'
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

    function mostrarUnovh($id){
        $sql="SELECT * 
	FROM tb_viajehorario
	WHERE tb_viajehorario_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrarNombre($nom,$vehiculo){
        $sql="SELECT * 
        FROM tb_asiento
        WHERE tb_asiento_nom='$nom' AND tb_vehiculo_id='$vehiculo'" ;
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrarNombreEstado($nom,$vehiculo,$fecha,$horario){
        $sql="SELECT * 
        FROM tb_asientoestado ae 
        INNER JOIN tb_viajehorario vh ON vh.tb_viajehorario_id=ae.tb_viajehorario_id
        INNER JOIN tb_lugar l ON l.tb_lugar_id = ae.tb_destpar_id
        WHERE ae.tb_asiento_id='$nom' AND vh.tb_vehiculo_id='$vehiculo' AND vh.tb_viajehorario_fecha='$fecha' AND vh.tb_viajehorario_horario='$horario'" ;
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
    function mostrar_distribucionasiento($fila, $piso, $vehiculo){
        $sql = "SELECT * FROM tb_distribucionasiento 
	WHERE tb_distribucionasiento_fila ='$fila' AND tb_distribucionasiento_piso ='$piso' AND tb_vehiculo_id='$vehiculo';";
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