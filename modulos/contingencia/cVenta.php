<?php
class cVenta{
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_contingencia
	WHERE tb_contingencia_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro_adm($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' 
	AND tb_documento_ele=0
	";
	
	 if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	 if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	 if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	 if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	 if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
	 if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function ultimo_numero($fec){
		$sql="SELECT IFNULL (max(tb_contingencia_num),0) as ultimo_numero FROM `tb_contingencia`
		WHERE tb_contingencia_fec='$fec'; ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function listar_contingencia($fec){
	$sql="SELECT * 
	FROM tb_contingencia
	WHERE tb_contingencia_fecref = '$fec'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function guardar_contingencia($usu_id,$fec,$fecref,$cod,$num,$mot,$lin,$txt){
	$sql="INSERT INTO tb_contingencia 
	(
	tb_contingencia_reg,
	tb_contingencia_mod,
	tb_contingencia_usureg,
	tb_contingencia_usumod,
	tb_contingencia_fec,
	tb_contingencia_fecref,
	tb_contingencia_cod,
	tb_contingencia_num,
	tb_contingencia_mot,
	tb_contingencia_lin,
	tb_contingencia_txt
	)
	VALUES(
	NOW(),
	NOW(),
	'$usu_id',
	'$usu_id',
	'$fec',
	'$fecref',
	'$cod',
	'$num',
	'$mot',
	'$lin',
	'$txt'
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
	function guardar_contingencia_detalle($resbol_id,$num,$idcom,$ser,$ini,$fin,$tipmon,$opegra,$opeexo,$opeina,$otrcar,$isc,$igv,$imptot){
	$sql="INSERT INTO tb_contingenciadetalle (
		`tb_contingencia_id`, 
		`tb_contingenciadetalle_num`, 
		`cs_tipodocumento_id`, 
		`tb_contingenciadetalle_ser`, 
		`tb_contingenciadetalle_ini`, 
		`tb_contingenciadetalle_fin`, 
		`cs_tipomoneda_id`, 
		`tb_contingenciadetalle_opegra`, 
		`tb_contingenciadetalle_opeexo`, 
		`tb_contingenciadetalle_opeina`, 
		`tb_contingenciadetalle_otrcar`, 
		`tb_contingenciadetalle_isc`, 
		`tb_contingenciadetalle_igv`, 
		`tb_contingenciadetalle_imptot`
		) VALUES ('$resbol_id', '$num', '$idcom', '$ser', '$ini', '$fin', '$tipmon', '$opegra', '$opeexo', '$opeina', '$otrcar', '$isc', '$igv', '$imptot');";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function listar_contingencia_detalle($id){
	$sql="SELECT * 
	FROM tb_contingenciadetalle rbd
	LEFT JOIN cs_tipodocumento td ON rbd.cs_tipodocumento_id=td.cs_tipodocumento_id
	WHERE tb_contingencia_id = '$id'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function comparar_contingencia_detalle($id){
	$sql="SELECT tb_contingenciadetalle_id
	FROM tb_contingenciadetalle
	WHERE tb_venta_id = '$id'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verificar($fecref){
	$sql="SELECT * 
	FROM tb_contingencia
	WHERE tb_contingencia_fecref='$fecref'";
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
	$sql = "UPDATE tb_contingencia SET  
	`tb_contingencia_tic` =  '$tic',
	`tb_contingencia_faucod` =  '$faucod',
	`tb_contingencia_digval` =  '$digval',
	`tb_contingencia_sigval` =  '$sigval',
	`tb_contingencia_val` =  '$val',
	`tb_contingencia_fecenvsun` =  NOW(),
	`tb_contingencia_estsun` =  '$est'
	WHERE  tb_contingencia_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>