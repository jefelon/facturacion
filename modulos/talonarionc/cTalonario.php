<?php
session_start();
class cTalonario{
	function insertar($ser, $ini, $fin, $num,$punven_id,$doc_id,$est,$emp_id){
	$sql = "INSERT INTO tb_talonarionc(
	`tb_talonario_reg` ,
	`tb_talonario_mod` ,
	`tb_talonario_ser` ,
	`tb_talonario_ini` ,
	`tb_talonario_fin` ,
	`tb_talonario_num` ,
	`tb_puntoventa_id` ,
	`tb_documento_id` ,
	`tb_talonario_est`,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$ser',  '$ini',  '$fin',  '$num', '$punven_id',  '$doc_id',  '$est', '$emp_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_filtro($emp_id,$punven_id,$doc_id){
	$sql="SELECT * 
	FROM tb_talonarionc t
	INNER JOIN tb_puntoventa p ON t.tb_puntoventa_id=p.tb_puntoventa_id
	INNER JOIN tb_documento d ON t.tb_documento_id=d.tb_documento_id
	WHERE t.tb_empresa_id = $emp_id
	";
	if($punven_id>0)$sql.=" AND t.tb_puntoventa_id=$punven_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_tipo(){
	$sql="SELECT * 
	FROM tb_talonarionc
	WHERE tb_empresa_id = {$_SESSION['empresa_id']}
	GROUP BY tb_talonario_tip";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_tipo($tip){
	$sql="SELECT * 
	FROM tb_talonarionc
	WHERE tb_talonario_tip=$tip AND tb_empresa_id = {$_SESSION['empresa_id']}
	ORDER BY tb_talonario_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_talonarionc
	WHERE tb_talonario_id=$id AND tb_empresa_id = {$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function correlativo($punven_id,$doc_id){
	$sql="SELECT * 
	FROM tb_talonarionc
	WHERE tb_puntoventa_id=$punven_id
	AND tb_documento_id=$doc_id
	AND tb_talonario_est ='ACTIVO' 
	AND tb_talonario_num<=tb_talonario_fin AND tb_empresa_id = {$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function actualizar_correlativo($id,$num,$est){ 
	$sql = "UPDATE tb_talonarionc SET  
	`tb_talonario_mod` = NOW( ) ,
	`tb_talonario_num` =  '$num',
	`tb_talonario_est` =  '$est' 
	WHERE tb_talonario_id =$id AND tb_empresa_id = {$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar($id,$ser, $ini, $fin, $num,$punven_id,$doc_id,$est){ 
	$sql = "UPDATE tb_talonarionc SET  
	`tb_talonario_mod` = NOW( ) ,
	`tb_talonario_ser` =  '$ser',
	`tb_talonario_ini` =  '$ini',
	`tb_talonario_fin` =  '$fin',
	`tb_talonario_num` =  '$num',
	`tb_puntoventa_id` =  '$punven_id',
	`tb_documento_id` =  '$doc_id',
	`tb_talonario_est` =  '$est' 
	WHERE tb_talonario_id =$id AND tb_empresa_id = {$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_talonario($tal_id,$punven_id,$doc_id,$est){
	$sql = "SELECT * 
		FROM  tb_talonarionc 
		WHERE tb_puntoventa_id=$punven_id
		AND tb_documento_id=$doc_id
		AND tb_talonario_est='$est' AND tb_empresa_id = {$_SESSION['empresa_id']}";
		
	if($tal_id>0)$sql.=" AND tb_talonario_id <> $tal_id ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_talonario_venta($punven_id,$doc_id,$ven_est,$numdoc){
	$sql = "SELECT * 
		FROM  tb_venta v
		INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
		WHERE tb_puntoventa_id=$punven_id
		AND v.tb_documento_id=$doc_id
		AND tb_venta_est='$ven_est'
		AND tb_venta_numdoc='$numdoc' AND tb_empresa_id = {$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_talonario_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_talonario_id =$id
		AND tb_talonario_est NOT LIKE 'INACTIVO' AND tb_empresa_id = {$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_talonarionc WHERE tb_talonario_id=$id AND tb_empresa_id = {$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>