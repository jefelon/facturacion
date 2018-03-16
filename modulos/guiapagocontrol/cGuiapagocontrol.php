<?php
class cGuiapagocontrol{
	function listar_cliente($cro_id,$ultdig){
		$sql="SELECT * 
		FROM tb_probalancecliente cc
		INNER JOIN tb_cliente c ON cc.tb_cliente_id=c.tb_cliente_id
		WHERE tb_cliente_xac=1 
		AND tb_probalancecliente_xac=1
		";	
		if($cro_id>0)$sql.=" AND tb_probalance_id = $cro_id ";
		if($ultdig>=0)$sql.=" AND tb_cliente_ultdig = $ultdig ";
		$sql.=" ORDER BY tb_cliente_ultdig ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function probalance_control($cli_id,$probalite_id,$per_id,$eje_id){
		$sql="SELECT *
		FROM tb_probalancecontrol 
		WHERE tb_cliente_id=$cli_id
		AND tb_probalanceitem_id=$probalite_id
		AND tb_periodo_id=$per_id
		AND tb_ejercicio_id=$eje_id ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function listar_cliente_control($crofec_id){
		$sql="SELECT *
		FROM tb_probalancecontrol 
		WHERE tb_probalancecontrol_xac=1
		AND tb_probalancefecha_id=$crofec_id ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function insertar_control($xac,$usureg,$usumod,$cli_id,$probalite_id,$per_id,$eje_id){
		$sql="INSERT INTO tb_probalancecontrol(
	`tb_probalancecontrol_xac` ,
	`tb_probalancecontrol_fecreg` ,
	`tb_probalancecontrol_fecmod` ,
	`tb_probalancecontrol_usureg` ,
	`tb_probalancecontrol_usumod` ,
	`tb_cliente_id` ,
	`tb_probalanceitem_id` ,
	`tb_periodo_id` ,
	`tb_ejercicio_id`
	)
	VALUES (
	'$xac', NOW( ) , NOW( ) , '$usureg', '$usumod',  '$cli_id',  '$probalite_id',  '$per_id',  '$eje_id'
	);";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function editar_control($probalcon_id,$xac,$usumod){
	$sql="UPDATE tb_probalancecontrol SET  
	`tb_probalancecontrol_xac` =  '$xac',
	`tb_probalancecontrol_fecmod` = NOW( ),
	`tb_probalancecontrol_usumod` =  '$usumod'
	WHERE tb_probalancecontrol_id =$probalcon_id;";
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

}
?>