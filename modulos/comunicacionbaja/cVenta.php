<?php
class cVenta{
	function mostrar_filtro($emp_id,$fec1,$est){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	WHERE v.tb_empresa_id = $emp_id AND c.tb_empresa_id = $emp_id
	AND tb_venta_fec = '$fec1' ";
	//AND tb_venta_estsun = 1
	$sql.=" AND d.tb_documento_ele = 1 ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_venta_fec, tb_venta_ser, tb_venta_num ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function ultimo_numero($fec){
		$sql="SELECT IFNULL (max(tb_combaja_num),0) as ultimo_numero FROM `tb_combaja`
		WHERE tb_combaja_fec='$fec'; ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function listar_combaja($fec){
	$sql="SELECT * 
	FROM tb_combaja
	WHERE tb_combaja_fecref = '$fec'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function guardar_combaja($usu_id,$fec,$fecref,$cod,$num){
	$sql="INSERT INTO tb_combaja 
	(
	tb_combaja_reg,
	tb_combaja_mod,
	tb_combaja_usureg,
	tb_combaja_usumod,
	tb_combaja_fec,
	tb_combaja_fecref,
	tb_combaja_cod,
	tb_combaja_num
	)
	VALUES(
	NOW(),
	NOW(),
	'$usu_id',
	'$usu_id',
	'$fec',
	'$fecref',
	'$cod',
	'$num'
	)";
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
	function guardar_combaja_detalle($baja_id,$num,$idcom,$ser,$numdoc,$mot,$ven_id){
	$sql="INSERT INTO tb_combajadetalle 
	(
	tb_combaja_id,
	tb_combajadetalle_num,
	cs_tipodocumento_id,
	tb_combajadetalle_ser,
	tb_combajadetalle_numdoc,
	tb_combajadetalle_mot,
	tb_venta_id
	)
	VALUES(
	'$baja_id',
	'$num',
	'$idcom',
	'$ser',
	'$numdoc',
	'$mot',
	'$ven_id'
	)";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function comparar_combaja_detalle($id){
	$sql="SELECT tb_combajadetalle_id
	FROM tb_combajadetalle
	WHERE tb_venta_id = '$id'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function listar_combaja_detalle($id){
	$sql="SELECT * 
	FROM tb_combajadetalle cbd
	LEFT JOIN cs_tipodocumento td ON cbd.cs_tipodocumento_id=td.cs_tipodocumento_id
	WHERE tb_combaja_id = $id
	ORDER BY tb_combajadetalle_num";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_combaja cb
	WHERE tb_combaja_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_campo($id,$campo,$valor){
	$sql = "UPDATE tb_venta SET
	`tb_venta_$campo` =  '$valor'
	WHERE tb_venta_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function actualizar_sunat($id,$tic,$faucod,$digval,$sigval,$val,$est){
	$sql = "UPDATE tb_combaja SET  
	`tb_combaja_tic` =  '$tic',
	`tb_combaja_faucod` =  '$faucod',
	`tb_combaja_digval` =  '$digval',
	`tb_combaja_sigval` =  '$sigval',
	`tb_combaja_val` =  '$val',
	`tb_combaja_fecenvsun` =  NOW(),
	`tb_combaja_estsun` =  '$est'
	WHERE  tb_combaja_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>