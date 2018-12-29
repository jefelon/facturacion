<?php
class cEmpresa{
	function insertar($ruc,$nomcom,$razsoc,$dir,$dir2,$tel,$ema,$rep,$fir,$logo,$regimen){
	$sql = "INSERT tb_empresa(
	`tb_empresa_ruc` ,
	`tb_empresa_nomcom` ,
	`tb_empresa_razsoc` ,
	`tb_empresa_dir` ,
	`tb_empresa_dir2` ,
	`tb_empresa_tel` ,
	`tb_empresa_ema` ,
	`tb_empresa_rep` ,
	`tb_empresa_fir` ,
	`tb_empresa_logo`,
	`tb_empresa_regimen`
	)
	VALUES (
	'$ruc',  '$nomcom',  '$razsoc',  '$dir',  '$dir2',  '$tel', '$ema','$rep', '$fir', '$logo','$regimen'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_empresa
	ORDER BY tb_empresa_razsoc
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_empresa 
	WHERE tb_empresa_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$ruc,$nomcom,$razsoc,$dir,$dir2,$tel,$ema,$rep,$fir,$logo,$regimen){
	$sql = "UPDATE tb_empresa SET  
	`tb_empresa_ruc` =  '$ruc',
	`tb_empresa_nomcom` =  '$nomcom',
	`tb_empresa_razsoc` =  '$razsoc',
	`tb_empresa_dir` =  '$dir',
	`tb_empresa_dir2` =  '$dir2',
	`tb_empresa_tel` =  '$tel',
	`tb_empresa_ema` =  '$ema',
	`tb_empresa_rep` =  '$rep',
	`tb_empresa_fir` =  '$fir',
	`tb_empresa_logo` =  '$logo',
	`tb_empresa_regimen` =  $regimen
	WHERE tb_empresa_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_user` 
WHERE tb_empresa_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_empresa WHERE tb_empresa_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>