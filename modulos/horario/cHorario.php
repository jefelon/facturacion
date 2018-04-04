<?php
session_start();
class cHorario{
	function insertar($nom,$fecini,$fecfin,$lun,$mar,$mie,$jue,$vie,$sab,$dom,$horini1,$horfin1,$horini2,$horfin2,$est){
	$sql = "INSERT INTO tb_horario(
	`tb_horario_reg` ,
	`tb_horario_mod` ,
	`tb_horario_nom` ,
	`tb_horario_fecini` ,
	`tb_horario_fecfin` ,
	`tb_horario_lun` ,
	`tb_horario_mar` ,
	`tb_horario_mie` ,
	`tb_horario_jue` ,
	`tb_horario_vie` ,
	`tb_horario_sab` ,
	`tb_horario_dom` ,
	`tb_horario_horini1` ,
	`tb_horario_horfin1` ,
	`tb_horario_horini2` ,
	`tb_horario_horfin2` ,
	`tb_horario_est`,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) , '$nom',  '$fecini',  '$fecfin',  '$lun',  '$mar',  '$mie',  '$jue',  '$vie',  '$sab',  '$dom', ";
	
	if($horini1=='NULL'){
		$sql.=" $horini1, ";
	}else{
		$sql.=" '$horini1', ";
	}
	
	if($horfin1=='NULL'){
		$sql.=" $horfin1, ";
	}else{
		$sql.=" '$horfin1', ";
	}
	
	if($horini2=='NULL'){
		$sql.=" $horini2, ";
	}else{
		$sql.=" '$horini2', ";
	}
	
	if($horfin2=='NULL'){
		$sql.=" $horfin2, ";
	}else{
		$sql.=" '$horfin2', ";
	}
	$sql.="  
	    '$est','{$_SESSION['empresa_id']}'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_horario 
	WHERE tb_horario_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_todos(){
	$sql="SELECT * 
	FROM tb_horario
	WHERE tb_empresa_id={$_SESSION['empresa_id']}
	ORDER BY tb_horario_nom
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom,$fecini,$fecfin,$lun,$mar,$mie,$jue,$vie,$sab,$dom,$horini1,$horfin1,$horini2,$horfin2,$est){
	$sql = "UPDATE tb_horario SET  
	`tb_horario_mod` = NOW( ) ,
	`tb_horario_nom` =  '$nom',
	`tb_horario_fecini` =  '$fecini',
	`tb_horario_fecfin` =  '$fecfin',
	`tb_horario_lun` =  '$lun',
	`tb_horario_mar` =  '$mar',
	`tb_horario_mie` =  '$mie',
	`tb_horario_jue` =  '$jue',
	`tb_horario_vie` =  '$vie',
	`tb_horario_sab` =  '$sab',
	`tb_horario_dom` =  '$dom', ";
	
	if($horini1=='NULL'){
		$sql.=" `tb_horario_horini1` =  $horini1, ";
	}else{
		$sql.=" `tb_horario_horini1` =  '$horini1', ";
	}
	
	if($horfin1=='NULL'){
		$sql.=" `tb_horario_horfin1` =  $horfin1, ";
	}else{
		$sql.=" `tb_horario_horfin1` =  '$horfin1', ";
	}
	
	if($horini2=='NULL'){
		$sql.=" `tb_horario_horini2` =  $horini2, ";
	}else{
		$sql.=" `tb_horario_horini2` =  '$horini2', ";
	}
	
	if($horfin2=='NULL'){
		$sql.=" `tb_horario_horfin2` =  $horfin2, ";
	}else{
		$sql.=" `tb_horario_horfin2` =  '$horfin2', ";
	}
	$sql.="
	`tb_horario_est` =  '$est' 
	WHERE tb_horario_id =$id AND tb_empresa_id={$_SESSION['empresa_id']};";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_horario_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_horario_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_horario WHERE tb_horario_id=$id AND tb_empresa_id={$_SESSION['empresa_id']}";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>