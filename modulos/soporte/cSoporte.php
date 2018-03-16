<?php
class cSoporte{
	function insertar($use,$emp,$ema,$asu,$tem,$ubi,$men,$est,$vis){
	$sql = "INSERT INTO tb_soporte(
`tb_soporte_fecreg` ,
`tb_user_id` ,
`tb_empresa_id` ,
`tb_soporte_ema` ,
`tb_soporte_asu` ,
`tb_soporte_tem` ,
`tb_soporte_ubi` ,
`tb_soporte_men` ,
`tb_soporte_est` ,
`tb_soporte_vis`
)
VALUES (
NOW( ) ,  '$use',  '$emp', '$ema',  '$asu',  '$tem',  '$ubi',  '$men',  '$est',  '$vis'
);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_soporte ORDER BY tb_soporte_razsoc";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_soporte 
WHERE tb_soporte_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$ruc,$nomcom,$razsoc,$dir,$dir2,$tel,$ema,$fir){
	$sql = "UPDATE tb_soporte SET  
`tb_soporte_ruc` =  '$ruc',
`tb_soporte_nomcom` =  '$nomcom',
`tb_soporte_razsoc` =  '$razsoc',
`tb_soporte_dir` =  '$dir',
`tb_soporte_dir2` =  '$dir2',
`tb_soporte_tel` =  '$tel',
`tb_soporte_ema` =  '$ema',
`tb_soporte_fir` =  '$fir'
WHERE tb_soporte_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_user` 
WHERE tb_soporte_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_soporte WHERE tb_soporte_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>