<?php
class cNotacreditocorreo{
	function insertar($xac,$usureg,$cli_id,$ven_id,$tip,$coremi,$cor,$corcop,$asu,$men,$adj){
	$sql = "INSERT INTO  tb_notacreditocorreo(
	`tb_ventacorreo_xac`,
	`tb_ventacorreo_fecreg`,
	`tb_ventacorreo_usureg`,
	`tb_cliente_id`,
	`tb_venta_id`,
	`tb_ventacorreo_tip`,
	`tb_ventacorreo_coremi`,
	`tb_ventacorreo_cor`,
	`tb_ventacorreo_corcop`,
	`tb_ventacorreo_asu`,
	`tb_ventacorreo_men`,
	`tb_ventacorreo_adj`
	)
	VALUES (
	'$xac' , NOW() , '$usureg','$cli_id',  '$ven_id',  '$tip',  '$coremi', '$cor',  '$corcop',  '$asu',  '$men',  '$adj'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function listar($ven_id){
	$sql = "SELECT *
	FROM tb_notacreditocorreo
	WHERE tb_venta_id = $ven_id
	ORDER BY tb_ventacorreo_fecreg DESC "; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function contar($ven_id){
	$sql = "SELECT *
	FROM tb_notacreditocorreo
	WHERE tb_venta_id = $ven_id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	$rst = mysql_num_rows($rst);
	return $rst;
	}
}
?>