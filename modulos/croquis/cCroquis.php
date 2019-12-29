<?php
class cCroquis{
	function insertar($veid,$est,$fon,$def){
	$sql = "INSERT tb_croquis (
		`tb_vehiculo_id`,
		`tb_croquis_estado`,
		`tb_croquis_fondo`,
		`tb_croquis_def`
		)
		VALUES (
		 '$veid',  '$est',  '$fon',  '$def'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
    function insertarCroquis($dis_lug,$dis_fil,$veh_id,$dis_pis,$cro_id){
        $sql = "INSERT tb_distribucionasiento (
		`tb_distribucionasiento_lugar`,
		`tb_distribucionasiento_fila`,
		`tb_vehiculo_id`,
		`tb_distribucionasiento_piso`,
		`tb_croquis_id`
		)
		VALUES (
		 '$dis_lug',  '$dis_fil',  '$veh_id',  '$dis_pis',  '$cro_id'
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
	FROM tb_croquis c
    INNER JOIN tb_vehiculo v ON v.tb_vehiculo_id=c.tb_vehiculo_id
	ORDER BY tb_croquis_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_croquis
	WHERE tb_croquis_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$veid,$est,$fon,$def){
	$sql = "UPDATE tb_croquis SET  
	`tb_vehiculo_id` =  '$veid',
	`tb_croquis_estado` =  '$est',
	`tb_croquis_fondo` = '$fon',
	`tb_croquis_def` = '$def'
	WHERE  tb_croquis_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}

    function actualizar_distribucionasiento($veh_id,$piso,$fila,$distrib){
	$sql = "UPDATE tb_distribucionasiento SET  
	`tb_distribucionasiento_lugar` =  '$distrib'
	WHERE tb_vehiculo_id =$veh_id AND tb_distribucionasiento_fila=$fila AND tb_distribucionasiento_piso=$piso
	";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function eliminar($id){
	$sql="DELETE FROM tb_croquis WHERE tb_croquis_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function eliminarCroquis($id){
        $sql="DELETE FROM tb_distribucionasiento WHERE tb_croquis_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


}
?>