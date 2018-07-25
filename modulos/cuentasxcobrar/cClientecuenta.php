<?php
class cClientecuenta{
	function insertar($tipreg,$fec,$glo,$tip,$mon,$est,$ven_id,$forpag_id,$modpag_id,$cuecor_id,$tar_id,$numope,$numdia,$fecven,$cli_id,$ver,$emp_id){
	$sql = "INSERT INTO  tb_clientecuenta(
	`tb_clientecuenta_fecreg` ,
	`tb_clientecuenta_tipreg` ,
	`tb_clientecuenta_fec` ,
	`tb_clientecuenta_glo` ,
	`tb_clientecuenta_tip` ,
	`tb_clientecuenta_mon` ,
	`tb_clientecuenta_est` ,
	`tb_venta_id` ,
	`tb_formapago_id` ,
	`tb_modopago_id` ,
	`tb_cuentacorriente_id` ,
	`tb_tarjeta_id` ,
	`tb_clientecuenta_numope` ,
	`tb_clientecuenta_numdia` ,
	`tb_clientecuenta_fecven` ,
	`tb_cliente_id` ,
	`tb_clientecuenta_ver` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) ,'$tipreg',  '$fec',  '$glo',  '$tip',  '$mon',  '$est',  '$ven_id',  '$forpag_id',  '$modpag_id', '$cuecor_id', '$tar_id',  '$numope',  '$numdia',  '$fecven',  '$cli_id',  '$ver',  '$emp_id'
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
	FROM tb_clientecuenta
	ORDER BY tb_clientecuenta_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrar_cuenta_por_cliente($cli_id,$emp_id){
	$sql="SELECT *
	FROM tb_clientecuenta
	WHERE tb_empresa_id = $emp_id
	AND tb_cliente_id = $cli_id
	ORDER BY tb_clientecuenta_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT *
	FROM tb_clientecuenta cc
	INNER JOIN tb_cliente c ON cc.tb_cliente_id=c.tb_cliente_id
	WHERE tb_clientecuenta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $glo, $tip, $mon, $est){
	$sql = "UPDATE tb_clientecuenta SET
	`tb_clientecuenta_glo` =  '$glo',
	`tb_clientecuenta_tip` =  $tip,
	`tb_clientecuenta_mon` =  $mon,
	`tb_clientecuenta_est` =  '$est'
	WHERE tb_clientecuenta_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_clientecuenta_tabla($id,$tabla){
	$sql = "SELECT *
		FROM  $tabla
		WHERE tb_clientecuenta_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_clientecuenta WHERE tb_clientecuenta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_por_venta($ven_id){
	$sql="DELETE FROM tb_clientecuenta WHERE tb_venta_id=$ven_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function obtener_sumatoria_entradas_por_estado($cli_id,$emp_id){
	$sql="
	SELECT tb_clientecuenta_est AS estado, sum(tb_clientecuenta_mon) AS monto
	FROM tb_clientecuenta
	WHERE tb_empresa_id = $emp_id
	AND tb_clientecuenta_tip = 1
	AND tb_cliente_id = $cli_id
	GROUP BY tb_clientecuenta_est
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function obtener_sumatoria_salidas($cli_id,$emp_id){
	$sql="
	SELECT sum(tb_clientecuenta_mon) AS monto
	FROM tb_clientecuenta
	WHERE tb_empresa_id = $emp_id
	AND tb_clientecuenta_tip = 2
	AND tb_cliente_id = $cli_id
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function actualizar_estado_entradas($id, $est){
	$sql = "UPDATE tb_clientecuenta SET
	`tb_clientecuenta_est` = $est,
	`tb_clientecuenta_ver` = 1
	WHERE tb_clientecuenta_id = $id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function obtener_total_entradas_salidas($cli_id, $emp_id){
	$sql = "
	SELECT tb_clientecuenta_tip AS tipo, sum(tb_clientecuenta_mon) AS monto
	FROM tb_clientecuenta
	WHERE tb_empresa_id = $emp_id
	AND tb_cliente_id = $cli_id
	GROUP BY tb_clientecuenta_tip
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function caja_filtro_adm($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$forpag_id,$modpag_id,$cuecor_id,$tar_id,$clicue_tipreg,$clicue_tip){
	$sql="SELECT ct.tb_formapago_id, fp.tb_formapago_nom, ct.tb_modopago_id, mp.tb_modopago_nom, ct.tb_cuentacorriente_id, tb_cuentacorriente_nom, ct.tb_tarjeta_id, tb_tarjeta_nom, ef.tb_entfinanciera_id AS banco_cuecor_id, ef.tb_entfinanciera_nom AS banco_cuecor, e.tb_entfinanciera_id AS banco_tar_id, e.tb_entfinanciera_nom AS banco_tar, SUM(tb_clientecuenta_mon) AS total
	FROM tb_clientecuenta ct
	INNER JOIN tb_venta v ON ct.tb_venta_id=v.tb_venta_id
	INNER JOIN tb_cliente c ON ct.tb_cliente_id=c.tb_cliente_id

	INNER JOIN tb_formapago fp ON ct.tb_formapago_id=fp.tb_formapago_id
	INNER JOIN tb_modopago mp ON ct.tb_modopago_id=mp.tb_modopago_id
	LEFT JOIN tb_cuentacorriente cc ON ct.tb_cuentacorriente_id=cc.tb_cuentacorriente_id
	LEFT JOIN tb_tarjeta t ON ct.tb_tarjeta_id=t.tb_tarjeta_id

	LEFT JOIN tb_entfinanciera ef ON cc.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_entfinanciera e ON t.tb_entfinanciera_id=e.tb_entfinanciera_id

	WHERE ct.tb_empresa_id = $emp_id
	AND tb_clientecuenta_fec BETWEEN '$fec1' AND '$fec2' ";

	if($cli_id>0)$sql.=" AND ct.tb_cliente_id = $cli_id ";

	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";

	if($forpag_id>0)$sql.=" AND ct.tb_formapago_id = $forpag_id ";
	if($modpag_id>0)$sql.=" AND ct.tb_modopago_id = $modpag_id ";
	if($cuecor_id>0)$sql.=" AND ct.tb_cuentacorriente_id = $cuecor_id ";
	if($tar_id>0)$sql.=" AND ct.tb_tarjeta_id = $tar_id ";

	if($clicue_tipreg>0)$sql.=" AND ct.tb_clientecuenta_tipreg = $clicue_tipreg ";
	if($clicue_tip>0)$sql.=" AND ct.tb_clientecuenta_tip = $clicue_tip ";

	$sql.=" GROUP BY ct.tb_formapago_id,ct.tb_modopago_id,ct.tb_cuentacorriente_id,ct.tb_tarjeta_id ";
	//$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>