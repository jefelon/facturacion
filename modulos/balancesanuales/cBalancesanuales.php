<?php
class cBalancesanuales{
	function insertar($id_cliente,$fecha_comienza,$fecha_culminacion,$fecha_declaracion,$fecha_vencimiento,
                      $bal_declarados,$bal_nodeclarados,$apagar,$pago_anual,$responsable_elaboracion,
                      $responsable_declaracion,$obs){
	$sql = "INSERT tb_balancesanuales (
		`tb_cliente_id`,`tb_fecha_comienza`,`tb_fecha_culminacion`,`tb_fecha_declaracion`,`tb_fecha_vencimiento`,
		`tb_balances_declarados`,`tb_balances_nodeclarados`,`tb_apagar`,`tb_pago_anual`,`tb_responsable_elaboracion_id`,
		`tb_responsable_declaracion_id`,`tb_observaciones`
		)
		VALUES (
		 '$id_cliente','$fecha_comienza','$fecha_culminacion','$fecha_declaracion','$fecha_vencimiento',
		 '$bal_declarados','$bal_nodeclarados','$apagar','$pago_anual','$responsable_elaboracion',
		 '$responsable_declaracion','$obs'
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
	$sql="SELECT ba.tb_balancesanuales_id, ba.tb_cliente_id,
    ep.tb_cliente_nom AS tb_cliente_nom, ba.tb_fecha_comienza,ba.tb_fecha_culminacion, ba.tb_fecha_declaracion,
    ba.tb_fecha_vencimiento, ba.tb_balances_declarados,ba.tb_balances_nodeclarados,ba.tb_apagar,ba.tb_pago_anual,
    ba.tb_responsable_elaboracion_id, 
    re.tb_cliente_nom AS tb_responsable_elaboracion_nom, ba.tb_responsable_declaracion_id, 
	rd.tb_cliente_nom AS tb_responsable_declaracion_nom, ba.tb_observaciones
	FROM tb_balancesanuales ba
	INNER JOIN tb_cliente ep ON ba.tb_cliente_id = ep.tb_cliente_id
	INNER JOIN tb_cliente re ON ba.tb_responsable_elaboracion_id = re.tb_cliente_id
	INNER JOIN tb_cliente rd ON ba.tb_responsable_declaracion_id = rd.tb_cliente_id
	ORDER BY tb_fecha_comienza";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT ba.tb_balancesanuales_id, ba.tb_cliente_id, ep.tb_cliente_doc AS tb_cliente_doc, 
    ep.tb_cliente_nom AS tb_cliente_nom, ba.tb_fecha_comienza,ba.tb_fecha_culminacion, ba.tb_fecha_declaracion,
    ba.tb_fecha_vencimiento, ba.tb_balances_declarados,ba.tb_balances_nodeclarados,ba.tb_apagar,ba.tb_pago_anual,
    ba.tb_responsable_elaboracion_id, 
    re.tb_cliente_doc AS tb_responsable_elaboracion_doc, re.tb_cliente_nom AS tb_responsable_elaboracion_nom,
	ba.tb_responsable_declaracion_id, rd.tb_cliente_doc AS tb_responsable_declaracion_doc, 
	rd.tb_cliente_nom AS tb_responsable_declaracion_nom, ba.tb_observaciones
	FROM tb_balancesanuales ba
	INNER JOIN tb_cliente ep ON ba.tb_cliente_id = ep.tb_cliente_id
	INNER JOIN tb_cliente re ON ba.tb_responsable_elaboracion_id = re.tb_cliente_id
	INNER JOIN tb_cliente rd ON ba.tb_responsable_declaracion_id = rd.tb_cliente_id
	WHERE tb_balancesanuales_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$id_cliente,$fecha_comienza,$fecha_culminacion,$fecha_declaracion,$fecha_vencimiento,
                       $bal_declarados,$bal_nodeclarados,$apagar,$pago_anual,$responsable_elaboracion,
                       $responsable_declaracion,$obs){
	$sql = "UPDATE tb_balancesanuales SET  
    `tb_cliente_id` =  '$id_cliente',
	`tb_fecha_comienza` =  '$fecha_comienza',
	`tb_fecha_culminacion` =  '$fecha_culminacion',
	`tb_fecha_declaracion` =  '$fecha_declaracion',
	`tb_fecha_vencimiento` =  '$fecha_vencimiento',
	`tb_balances_declarados` =  '$bal_declarados',
	`tb_balances_nodeclarados` =  '$bal_nodeclarados',
	`tb_apagar` =  '$apagar',
	`tb_pago_anual` =  '$pago_anual',
	`tb_responsable_elaboracion_id` =  '$responsable_elaboracion',
	`tb_responsable_declaracion_id` =  '$responsable_declaracion',
	`tb_observaciones` =  '$obs'
	WHERE  tb_balancesanuales_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_balancesanuales_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_balancesanuales_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_balancesanuales WHERE tb_balancesanuales_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>