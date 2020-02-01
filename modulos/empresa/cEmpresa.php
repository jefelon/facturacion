<?php
class cEmpresa{
	function insertar($ruc,$nomcom,$razsoc,$dir,$dir2,$tel,$ema,$rep,$logo,$regimen,$cel,$cer,$clacer,$ususun,$clasun,$iddis,$sub,$dep,$pro,$dis,$webser,$teximp){
	$sql = "INSERT tb_empresa(
	`tb_empresa_ruc` ,
	`tb_empresa_nomcom` ,
	`tb_empresa_razsoc` ,
	`tb_empresa_dir` ,
	`tb_empresa_dir2` ,
	`tb_empresa_tel` ,
	`tb_empresa_ema` ,
	`tb_empresa_rep` ,
	`tb_empresa_logo`,
	`tb_empresa_regimen`,
	`tb_empresa_cel`,
	`tb_empresa_certificado`,
	`tb_empresa_clave_certificado`,
	`tb_empresa_usuario_sunat`,
	`tb_empresa_clave_sunat`,
	`tb_empresa_iddistrito`,
	`tb_empresa_subdivision`,
	`tb_empresa_departamento`,
	`tb_empresa_provincia`,
	`tb_empresa_distrito`,
	`tb_empresa_webser`,
	`tb_empresa_teximp`
	)
	VALUES (
	'$ruc',  '$nomcom',  '$razsoc',  '$dir',  '$dir2',  '$tel', '$ema','$rep', '$logo','$regimen','$cel','$cer','$clacer','$ususun','$clasun','$iddis','$sub','$dep','$pro','$dis','$webser','$teximp'
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
	function modificar($id,$ruc,$nomcom,$razsoc,$dir,$dir2,$tel,$ema,$rep,$logo,$regimen,$cel,$cer,$clacer,$ususun,$clasun,$iddis,$sub,$dep,$pro,$dis,$webser,$teximp){
	$sql = "UPDATE tb_empresa SET  
	`tb_empresa_ruc` =  '$ruc',
	`tb_empresa_nomcom` =  '$nomcom',
	`tb_empresa_razsoc` =  '$razsoc',
	`tb_empresa_dir` =  '$dir',
	`tb_empresa_dir2` =  '$dir2',
	`tb_empresa_tel` =  '$tel',
	`tb_empresa_ema` =  '$ema',
	`tb_empresa_rep` =  '$rep',
	`tb_empresa_logo` =  '$logo',
	`tb_empresa_regimen` =  '$regimen',
	`tb_empresa_cel`=  '$cel',
	`tb_empresa_certificado`=  '$cer',
	`tb_empresa_clave_certificado`=  '$clacer',
	`tb_empresa_usuario_sunat`=  '$ususun',
	`tb_empresa_clave_sunat`=  '$clasun',
	`tb_empresa_iddistrito`=  '$iddis',
	`tb_empresa_subdivision`=  '$sub',
	`tb_empresa_departamento`=  '$dep',
	`tb_empresa_provincia`=  '$pro',
	`tb_empresa_distrito`=  '$dis',
	`tb_empresa_webser`=  '$webser',
	`tb_empresa_teximp`=  '$teximp'
	WHERE tb_empresa_id ='$id' ";
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