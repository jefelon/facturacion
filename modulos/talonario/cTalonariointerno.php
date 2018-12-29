<?php
session_start();
class cTalonariointerno{
	function insertar($ser, $ini, $fin, $num,$doc_id,$est,$alm_id,$punven_id,$emp_id){
	$sql = "INSERT INTO tb_talonariointerno(
	`tb_talonario_reg` ,
	`tb_talonario_mod` ,
	`tb_talonario_ser` ,
	`tb_talonario_ini` ,
	`tb_talonario_fin` ,
	`tb_talonario_num` ,
	`tb_documento_id` ,
	`tb_talonario_est`,
	`tb_almacen_id`,
	`tb_puntoventa_id`,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$ser',  '$ini',  '$fin',  '$num',  '$doc_id',  '$est', '$alm_id','$punven_id','$emp_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_filtro($emp_id){
	$sql="SELECT * 
	FROM tb_talonariointerno t
	LEFT JOIN tb_puntoventa p ON t.tb_puntoventa_id = p.tb_puntoventa_id
	LEFT JOIN tb_almacen a ON t.tb_almacen_id=a.tb_almacen_id
	WHERE t.tb_empresa_id = $emp_id	AND a.tb_empresa_id = $emp_id AND p.tb_empresa_id = $emp_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_tipo(){
	$sql="SELECT * 
	FROM tb_talonariointerno
	WHERE tb_empresa_id={$_SESSION['empresa_id']}
	GROUP BY tb_talonario_tip";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_tipo($tip){
	$sql="SELECT * 
	FROM tb_talonariointerno
	WHERE tb_talonario_tip=$tip AND tb_empresa_id={$_SESSION['empresa_id']}
	ORDER BY tb_talonario_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_talonariointerno
	WHERE tb_talonario_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function correlativo($emp_id,$doc_id){
	$sql="SELECT * 
	FROM tb_talonariointerno
	WHERE tb_empresa_id=$emp_id
	AND tb_documento_id=$doc_id
	AND tb_talonario_est ='ACTIVO' 
	AND tb_talonario_num<=tb_talonario_fin";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function correlativo_tra($alm_id,$doc_id){
	$sql="SELECT * 
	FROM tb_talonariointerno
	WHERE tb_almacen_id=$alm_id
	AND tb_documento_id=$doc_id
	AND tb_talonario_est ='ACTIVO' 
	AND tb_talonario_num<=tb_talonario_fin AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function correlativo_notven($punven_id,$doc_id){
	$sql="SELECT * 
	FROM tb_talonariointerno
	WHERE tb_puntoventa_id=$punven_id
	AND tb_documento_id=$doc_id
	AND tb_talonario_est ='ACTIVO' 
	AND tb_talonario_num<=tb_talonario_fin AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function actualizar_correlativo($id,$num,$est){ 
	$sql = "UPDATE tb_talonariointerno SET  
	`tb_talonario_mod` = NOW( ) ,
	`tb_talonario_num` =  '$num',
	`tb_talonario_est` =  '$est' 
	WHERE tb_talonario_id =$id AND tb_empresa_id={$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar($id,$ser, $ini, $fin, $num,$doc_id,$est,$alm_id,$punven_id){ 
	$sql = "UPDATE tb_talonariointerno SET  
	`tb_talonario_mod` = NOW( ) ,
	`tb_talonario_ser` =  '$ser',
	`tb_talonario_ini` =  '$ini',
	`tb_talonario_fin` =  '$fin',
	`tb_talonario_num` =  '$num',
	`tb_documento_id` =  '$doc_id',
	`tb_talonario_est` =  '$est',
	`tb_almacen_id` =  '$alm_id',
	`tb_puntoventa_id` =  '$punven_id' 
	WHERE tb_talonario_id =$id AND tb_empresa_id={$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_talonario($tal_id,$doc_id,$est,$emp_id){
	$sql = "SELECT * 
		FROM  tb_talonariointerno 
		WHERE tb_empresa_id = $emp_id
		AND tb_documento_id=$doc_id
		AND tb_talonario_est='$est' ";
		
	if($tal_id>0)$sql.=" AND tb_talonario_id <> $tal_id ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_talonario_tra($tal_id,$doc_id,$est,$alm_id,$emp_id){
	$sql = "SELECT * 
		FROM  tb_talonariointerno 
		WHERE tb_empresa_id = $emp_id
		AND tb_documento_id=$doc_id
		AND tb_talonario_est='$est' ";
		
	if($alm_id>0)$sql.=" AND tb_almacen_id = $alm_id ";
	if($tal_id>0)$sql.=" AND tb_talonario_id <> $tal_id ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_talonario_notven($tal_id,$doc_id,$est,$punven_id,$emp_id){
	$sql = "SELECT * 
		FROM  tb_talonariointerno 
		WHERE tb_empresa_id = $emp_id
		AND tb_documento_id=$doc_id
		AND tb_talonario_est='$est' ";
		
	if($punven_id>0)$sql.=" AND tb_puntoventa_id = $punven_id ";
	if($tal_id>0)$sql.=" AND tb_talonario_id <> $tal_id ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_talonario_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_talonario_id =$id
		AND tb_talonario_est NOT LIKE 'INACTIVO' AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_talonariointerno WHERE tb_talonario_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>