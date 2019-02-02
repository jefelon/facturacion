<?php
class cAsientoestado{
	function insertar($asiento_id,$vh_id,$cli_id,$destpar,$precio){
	$sql = "INSERT tb_asientoestado (
		`tb_asiento_id`,
		`tb_viajehorario_id`,
		`tb_asientoestado_reserva`,
		`tb_clientereserva_id`,
		`tb_destpar_id`,
		`tb_asientoestado_precio`
		)
		VALUES (
		 '$asiento_id', '$vh_id', '1' ,$cli_id ,'$destpar', '$precio'
		);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}

    function mostrar_asiento_estado($vh_id,$asi_id){
        $sql = "SELECT * 
        FROM tb_asientoestado ae 
        WHERE ae.tb_viajehorario_id=$vh_id AND ae.tb_asiento_id=$asi_id;";
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

	function eliminar($vh_id, $asiento_id){
	    $sql="DELETE FROM tb_asientoestado WHERE tb_viajehorario_id=$vh_id AND tb_asiento_id=$asiento_id";
	    $oCado = new Cado();
	    $rst=$oCado->ejecute_sql($sql);
	    return $rst;
	}
}
?>