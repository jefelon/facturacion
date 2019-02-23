<?php
class cTramitependiente{
	function insertar($id_cliente,$fec_acuerdo,$fec_finalizado,$tramite_ejecutar,$fec_conteo,$fecha_plazo,$persdecl_id,
                      $obs){
	$sql = "INSERT tb_tramitependiente (
		`tb_cliente_id`,`tb_fecha_acuerdo`,`tb_fecha_finalizado`,`tb_tramite_ejecutar`,`tb_fecha_conteo`,
		`tb_fecha_plazo`,`tb_persdecl_id`,`tb_observaciones`
		)
		VALUES (
		 '$id_cliente','$fec_acuerdo','$fec_finalizado','$tramite_ejecutar','$fec_conteo','$fecha_plazo','$persdecl_id',
		 '$obs'
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
	$sql="SELECT tp.tb_tramitependiente_id, tp.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, tp.tb_fecha_acuerdo, tp.tb_fecha_finalizado, tp.tb_tramite_ejecutar,
    tp.tb_fecha_conteo,tp.tb_fecha_plazo, tp.tb_persdecl_id, pr.tb_cliente_nom AS tb_persdecl_nom, 
    pr.tb_cliente_doc AS tb_persdecl_doc, tp.tb_observaciones
	FROM tb_tramitependiente tp
	INNER JOIN tb_cliente cd ON tp.tb_cliente_id = cd.tb_cliente_id
	INNER JOIN tb_cliente pr ON tp.tb_persdecl_id = pr.tb_cliente_id
	ORDER BY tp.tb_fecha_acuerdo";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT tp.tb_tramitependiente_id, tp.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, tp.tb_fecha_acuerdo, tp.tb_fecha_finalizado, tp.tb_tramite_ejecutar,
    tp.tb_fecha_conteo,tp.tb_fecha_plazo, tp.tb_persdecl_id, pr.tb_cliente_nom AS tb_persdecl_nom, 
    pr.tb_cliente_doc AS tb_persdecl_doc, tp.tb_observaciones
	FROM tb_tramitependiente tp
	INNER JOIN tb_cliente cd ON tp.tb_cliente_id = cd.tb_cliente_id
	INNER JOIN tb_cliente pr ON tp.tb_persdecl_id = pr.tb_cliente_id
	WHERE tb_tramitependiente_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$id_cliente,$fec_acuerdo,$fec_finalizado,$tramite_ejecutar,$fec_conteo,$fecha_plazo,$persdecl_id,
                       $obs){
	$sql = "UPDATE tb_tramitependiente SET  
	`tb_cliente_id` =  '$id_cliente',
	`tb_fecha_acuerdo` =  '$fec_acuerdo',
	`tb_fecha_finalizado` =  '$fec_finalizado',
	`tb_tramite_ejecutar` =  '$tramite_ejecutar',
	`tb_fecha_conteo` =  '$fec_conteo',
	`tb_fecha_plazo` =  '$fecha_plazo',
	`tb_persdecl_id` =  '$persdecl_id',
	`tb_observaciones` =  '$obs'
	WHERE  tb_tramitependiente_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_tramitependiente_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_tramitependiente_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_tramitependiente WHERE tb_tramitependiente_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>