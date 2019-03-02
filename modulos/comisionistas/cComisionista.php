<?php
class cComisionista{
	function insertar($id_cliente,$id_intermediario,$fec_consiguio,$opcion_com,$cobro,$comision,$mes1,$mes2,$mes3,
                      $monto_total){
	$sql = "INSERT tb_comisionista (
		`tb_cliente_id`,`tb_intermediario_id`,`tb_fecha_consiguio`,`tb_opcion_com`,`tb_cobro`,`tb_comision`,`tb_mes1`,
		`tb_mes2`,`tb_mes3`,`tb_monto_total`
		)
		VALUES (
		 '$id_cliente','$id_intermediario','$fec_consiguio','$opcion_com','$cobro','$comision','$mes1','$mes2','$mes3',
		 '$monto_total'
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
	$sql="SELECT co.tb_comisionista_id, i.tb_cliente_nom AS tb_intermediario_nom, ep.tb_cliente_nom AS tb_cliente_nom,
     co.tb_fecha_consiguio, co.tb_opcion_com,co.tb_cobro,co.tb_comision,co.tb_mes1,co.tb_mes2,co.tb_mes3,co.tb_monto_total
	FROM tb_comisionista co
	INNER JOIN tb_cliente ep ON ep.tb_cliente_id = co.tb_cliente_id
	INNER JOIN tb_cliente i ON i.tb_cliente_id = co.tb_intermediario_id
	ORDER BY tb_fecha_consiguio";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT co.tb_comisionista_id, co.tb_intermediario_id, i.tb_cliente_nom AS tb_intermediario_nom, co.tb_cliente_id, i.tb_cliente_doc AS tb_intermediario_doc, 
     ep.tb_cliente_nom AS tb_cliente_nom,ep.tb_cliente_nom AS tb_cliente_nom,ep.tb_cliente_doc AS tb_cliente_doc,
     co.tb_fecha_consiguio, co.tb_opcion_com,co.tb_cobro,co.tb_comision,co.tb_mes1,co.tb_mes2,co.tb_mes3,co.tb_monto_total
	FROM tb_comisionista co
	INNER JOIN tb_cliente ep ON ep.tb_cliente_id = co.tb_cliente_id
	INNER JOIN tb_cliente i ON i.tb_cliente_id = co.tb_intermediario_id
	WHERE tb_comisionista_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$id_cliente,$id_intermediario,$fec_consiguio,$opcion_com,$cobro,$comision,$mes1,$mes2,$mes3,
                       $monto_total){
	$sql = "UPDATE tb_comisionista SET  
	`tb_cliente_id` =  '$id_cliente',
	`tb_intermediario_id` =  '$id_intermediario',
	`tb_fecha_consiguio` =  '$fec_consiguio',
	`tb_opcion_com` =  '$opcion_com',
	`tb_cobro` =  '$cobro',
	`tb_comision` =  '$comision',
	`tb_mes1` =  '$mes1',
	`tb_mes2` =  '$mes2',
	`tb_mes3` =  '$mes3',
	`tb_monto_total` =  '$monto_total'
	WHERE  tb_comisionista_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_comisionista_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_comisionista_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_comisionista WHERE tb_comisionista_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>