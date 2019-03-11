<?php
class cVentapago{
	function insertar($forpag_id,$modpag_id,$fec,$mon,$cuecor_id,$tar_id,$numope,$numdia,$fecven,$ven_id,$emp_id){
	$sql = "INSERT INTO  tb_ventapago(
	`tb_ventapago_fecreg` ,
	`tb_formapago_id` ,
	`tb_modopago_id` ,
	`tb_ventapago_fec` ,
	`tb_ventapago_mon` ,
	`tb_cuentacorriente_id` ,
	`tb_tarjeta_id` ,
	`tb_ventapago_numope` ,
	`tb_ventapago_numdia` ,
	`tb_ventapago_fecven` ,
	`tb_venta_id`,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) ,  '$forpag_id',  '$modpag_id',  '$fec',  '$mon', '$cuecor_id',  '$tar_id',  '$numope',  '$numdia',  '$fecven',  '$ven_id', '$emp_id'
	);";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_pagos($ven_id){
	$sql = "SELECT *
	FROM tb_ventapago vp
	LEFT JOIN tb_cuentacorriente cc ON vp.tb_cuentacorriente_id=cc.tb_cuentacorriente_id
	LEFT JOIN tb_tarjeta t ON vp.tb_tarjeta_id = t.tb_tarjeta_id 
	WHERE tb_venta_id = $ven_id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function caja_filtro_adm($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$forpag_id,$modpag_id,$cuecor_id,$tar_id){
	$sql="SELECT vp.tb_formapago_id, fp.tb_formapago_nom, vp.tb_modopago_id, mp.tb_modopago_nom, vp.tb_cuentacorriente_id, tb_cuentacorriente_nom, vp.tb_tarjeta_id, tb_tarjeta_nom, ef.tb_entfinanciera_id AS banco_cuecor_id, ef.tb_entfinanciera_nom AS banco_cuecor, e.tb_entfinanciera_id AS banco_tar_id, e.tb_entfinanciera_nom AS banco_tar, SUM(tb_ventapago_mon) AS total 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_ventapago vp ON v.tb_venta_id=vp.tb_venta_id
	INNER JOIN tb_formapago fp ON vp.tb_formapago_id=fp.tb_formapago_id
	INNER JOIN tb_modopago mp ON vp.tb_modopago_id=mp.tb_modopago_id
	LEFT JOIN tb_cuentacorriente cc ON vp.tb_cuentacorriente_id=cc.tb_cuentacorriente_id
	LEFT JOIN tb_tarjeta t ON vp.tb_tarjeta_id=t.tb_tarjeta_id
	
	LEFT JOIN tb_entfinanciera ef ON cc.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_entfinanciera e ON t.tb_entfinanciera_id=e.tb_entfinanciera_id
	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	if($forpag_id>0)$sql.=" AND vp.tb_formapago_id = $forpag_id ";
	if($modpag_id>0)$sql.=" AND vp.tb_modopago_id = $modpag_id ";
	if($cuecor_id>0)$sql.=" AND vp.tb_cuentacorriente_id = $cuecor_id ";
	if($tar_id>0)$sql.=" AND vp.tb_tarjeta_id = $tar_id ";
	
	$sql.=" GROUP BY vp.tb_formapago_id,vp.tb_modopago_id,vp.tb_cuentacorriente_id,vp.tb_tarjeta_id ";
	//$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_formapago(){
	$sql = "SELECT *
	FROM tb_formapago
	ORDER BY tb_formapago_id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_modopago(){
	$sql = "SELECT *
	FROM tb_modopago
	ORDER BY tb_modopago_id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
}
?>