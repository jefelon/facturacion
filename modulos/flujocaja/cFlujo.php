<?php
class cFlujo{

	function ingreso_suma_subcue($emp,$y,$m,$subcue,$est){
	$sql="SELECT FORMAT(SUM( tb_ingreso_mon ), 2) AS ingreso_suma_subcue 
FROM tb_ingreso
WHERE tb_empresa_id =$emp
AND tb_subcuenta_id=$subcue
AND YEAR(tb_ingreso_feccon)=$y
";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_ingreso_feccon)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_ingreso_est IN ($est) ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function ingreso_suma_cue($emp,$y,$m,$cue,$est){
	$sql="SELECT FORMAT(SUM( tb_ingreso_mon ),2) AS ingreso_suma_cue 
FROM tb_ingreso
WHERE tb_empresa_id =$emp
AND tb_cuenta_id=$cue
AND YEAR(tb_ingreso_feccon)=$y
";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_ingreso_feccon)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_ingreso_est IN ($est) ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function ingreso_suma_mes($emp,$y,$m,$est){
	$sql="SELECT FORMAT(SUM( tb_ingreso_mon ),2) AS ingreso_suma_mes 
FROM tb_ingreso
WHERE tb_empresa_id =$emp
AND YEAR(tb_ingreso_feccon)=$y
";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_ingreso_feccon)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_ingreso_est IN ($est) ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function gasto_suma_subcue($emp,$y,$m,$subcue,$est){
	$sql="SELECT FORMAT(SUM( tb_gasto_imp ),2) AS gasto_suma_subcue 
FROM tb_gasto
WHERE tb_empresa_id =$emp
AND tb_subcuenta_id=$subcue
AND YEAR(tb_gasto_fec)=$y
";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_gasto_fec)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_gasto_est IN ($est) ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function gasto_suma_cue($emp,$y,$m,$cue,$est){
	$sql="SELECT FORMAT(SUM( tb_gasto_imp ),2) AS gasto_suma_cue 
FROM tb_gasto
WHERE tb_empresa_id =$emp
AND tb_cuenta_id=$cue
AND YEAR(tb_gasto_fec)=$y
";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_gasto_fec)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_gasto_est IN ($est) ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function gasto_suma_mes($emp,$y,$m,$est){
	$sql="SELECT FORMAT(SUM( tb_gasto_imp ),2) AS gasto_suma_mes 
FROM tb_gasto
WHERE tb_empresa_id =$emp
AND YEAR(tb_gasto_fec)=$y
";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_gasto_fec)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_gasto_est IN ($est) ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
}
?>