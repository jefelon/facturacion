<?php
class cGasto{
	function insertar($fec,$doc,$des,$imp,$modpag,$numope,$est,$cue,$subcue,$pro,$entfin,$caj_id,$mon_id,$ref_id,$tra_id,$emp,$usu_id_reg,$usu_id_mod){
	$sql = "INSERT INTO tb_gasto(
	`tb_gasto_fecreg` ,
	`tb_gasto_fecmod` ,
	`tb_gasto_fec` ,
	`tb_gasto_doc` ,
	`tb_gasto_des` ,
	`tb_gasto_imp` ,
	`tb_gasto_modpag` ,
	`tb_gasto_numope` ,
	`tb_gasto_est` ,
	`tb_cuenta_id` ,
	`tb_subcuenta_id` ,
	`tb_proveedor_id` ,
	`tb_entfinanciera_id` ,
	`tb_caja_id` ,
	`tb_moneda_id` ,
	`tb_referencia_id` ,
	`tb_transferencia_id` ,
	`tb_empresa_id` ,
	`tb_usuario_id_reg`,
	`tb_usuario_id_mod`
	)
	VALUES (
	NOW( ) ,NOW( ) ,  '$fec',  '$doc',  '$des',  '$imp',  '$modpag',  '$numope',  '$est',  '$cue',  '$subcue',  '$pro',  '$entfin',  '$caj_id', '$mon_id', '$ref_id', '$tra_id','$emp',  '$usu_id_reg', '$usu_id_mod'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function insertar_terceros($fec,$doc,$des,$imp,$modpag,$numope,$est,$cue,$subcue,$pro,$entfin,$caj_id,$ref_id,$tra_id_ter,$emp,$usu_id_reg,$usu_id_mod){
	$sql = "INSERT INTO tb_gasto(
	`tb_gasto_fecreg` ,
	`tb_gasto_fecmod` ,
	`tb_gasto_fec` ,
	`tb_gasto_doc` ,
	`tb_gasto_des` ,
	`tb_gasto_imp` ,
	`tb_gasto_modpag` ,
	`tb_gasto_numope` ,
	`tb_gasto_est` ,
	`tb_cuenta_id` ,
	`tb_subcuenta_id` ,
	`tb_proveedor_id` ,
	`tb_entfinanciera_id` ,
	`tb_caja_id` ,
	`tb_referencia_id` ,
	`tb_transferencia_id_ter` ,
	`tb_empresa_id` ,
	`tb_usuario_id_reg`,
	`tb_usuario_id_mod`
	)
	VALUES (
	NOW( ) ,NOW( ) ,  '$fec',  '$doc',  '$des',  '$imp',  '$modpag',  '$numope',  '$est',  '$cue',  '$subcue',  '$pro',  '$entfin',  '$caj_id', '$ref_id', '$tra_id_ter','$emp',  '$usu_id_reg', '$usu_id_mod'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar($id,$fec,$doc,$des,$imp,$modpag,$numope,$est,$cue,$subcue,$pro,$entfin,$caj_id,$mon_id,$ref_id,$usu_id_mod){
	$sql = "UPDATE tb_gasto SET
	`tb_gasto_fecmod` = NOW( ) ,
	`tb_gasto_fec` =  '$fec',
	`tb_gasto_doc` =  '$doc',
	`tb_gasto_des` =  '$des',
	`tb_gasto_imp` =  '$imp',
	`tb_gasto_modpag` =  '$modpag',
	`tb_gasto_numope` =  '$numope',
	`tb_gasto_est` =  '$est',
	`tb_cuenta_id` =  '$cue',
	`tb_subcuenta_id` =  '$subcue',
	`tb_proveedor_id` =  '$pro',
	`tb_entfinanciera_id` =  '$entfin',
	`tb_caja_id` =  '$caj_id',
	`tb_moneda_id` =  '$mon_id',
	`tb_referencia_id` =  '$ref_id',
	`tb_usuario_id_mod` =  '$usu_id_mod'
	WHERE tb_gasto_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_gasto ORDER BY tb_empresa_id,tb_gasto_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_emp($emp){
	$sql="SELECT * FROM tb_gasto
	WHERE tb_empresa_id=$emp 
	ORDER BY tb_gasto_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function busqDes($emp,$des){
	$sql="SELECT DISTINCT(tb_gasto_des) FROM tb_gasto
	WHERE tb_empresa_id=$emp
	AND tb_gasto_des like '%$des%'
	ORDER BY tb_gasto_des
	LIMIT 0 , 10";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * FROM tb_gasto 
WHERE tb_gasto_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($emp_id,$y,$m,$cue_id,$subcue_id,$pro_id,$entfin_id,$est,$caj_id){
	$sql="SELECT * 
	FROM tb_gasto g
	INNER JOIN tb_cuenta c ON g.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON g.tb_caja_id = cj.tb_caja_id
	LEFT JOIN tb_entfinanciera ef ON g.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_proveedor p ON g.tb_proveedor_id = p.tb_proveedor_id
	LEFT JOIN tb_subcuenta sc ON g.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE g.tb_empresa_id=$emp_id ";
	
	if($y!=0){
	$sql = $sql." AND YEAR( tb_gasto_fec ) =$y ";
	}
	if($m>0){
	$sql = $sql." AND MONTH( tb_gasto_fec ) =$m ";
	}
		if($caj_id>0){
		$sql = $sql." AND g.tb_caja_id = $caj_id ";
		}
		
		if($cue_id>0){
		$sql = $sql." AND g.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND g.tb_subcuenta_id = $subcue_id ";
		}
		if($pro_id>0){
		$sql = $sql." AND g.tb_proveedor_id = $pro_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND g.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_gasto_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY tb_gasto_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro_fec($emp_id,$fec1,$fec2,$cue_id,$subcue_id,$pro_id,$entfin_id,$est,$caj_id,$mon_id,$ref_id){
	$sql="SELECT * 
	FROM tb_gasto g
	INNER JOIN tb_cuenta c ON g.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON g.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_referencia r ON g.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON g.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_proveedor p ON g.tb_proveedor_id = p.tb_proveedor_id
	LEFT JOIN tb_subcuenta sc ON g.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE g.tb_empresa_id=$emp_id 
	AND tb_gasto_fec BETWEEN '$fec1' AND '$fec2' ";

		if($caj_id>0){
		$sql = $sql." AND g.tb_caja_id = $caj_id ";
		}
		if($mon_id>0){
		$sql = $sql." AND g.tb_moneda_id = $mon_id ";
		}
		if($ref_id>0){
		$sql = $sql." AND g.tb_referencia_id = $ref_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND g.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND g.tb_subcuenta_id = $subcue_id ";
		}
		if($pro_id>0){
		$sql = $sql." AND g.tb_proveedor_id = $pro_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND g.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_gasto_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY tb_gasto_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_suma($emp_id,$fec1,$fec2,$cue_id,$subcue_id,$pro_id,$entfin_id,$est,$caj_id,$mon_id,$ref_id){
	$sql="SELECT SUM(tb_gasto_imp) as total 
	FROM tb_gasto g
	INNER JOIN tb_cuenta c ON g.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON g.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_referencia r ON g.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON g.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_proveedor p ON g.tb_proveedor_id = p.tb_proveedor_id
	LEFT JOIN tb_subcuenta sc ON g.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_empresa_id=$emp_id 
	AND tb_gasto_fec BETWEEN '$fec1' AND '$fec2' ";

		if($caj_id>0){
		$sql = $sql." AND g.tb_caja_id = $caj_id ";
		}
		if($mon_id>0){
		$sql = $sql." AND g.tb_moneda_id = $mon_id ";
		}
		if($ref_id>0){
		$sql = $sql." AND g.tb_referencia_id = $ref_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND g.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND g.tb_subcuenta_id = $subcue_id ";
		}
		if($pro_id>0){
		$sql = $sql." AND g.tb_proveedor_id = $pro_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND g.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_gasto_est LIKE '$est' ";
		}
		
		//$sql = $sql." ORDER BY tb_gasto_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarFiltro_alert($emp,$y,$m,$cue,$subcue,$entfin,$est){
	$sql="SELECT * FROM tb_gasto
	WHERE tb_empresa_id=$emp 
	AND YEAR( tb_gasto_fec ) NOT LIKE '$y' ";
		if($m!=0){
		$sql = $sql." AND MONTH( tb_gasto_fec ) =$m ";
		}
		if($cue!='0'){
		$sql = $sql." AND tb_cuenta_id = $cue ";
		}
		if($subcue!='0'){
		$sql = $sql." AND tb_subcuenta_id = $subcue ";
		}
		if($est!='0'){
		$sql = $sql." AND tb_gasto_est LIKE '$est' ";
		}
		if($entfin!='0'){
		$sql = $sql." AND tb_entfinanciera_id = $entfin ";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosGasto(){
	$sql="SELECT DISTINCT (
	YEAR( tb_gasto_fec )) AS anio
	FROM  `tb_gasto` 
	ORDER BY tb_gasto_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_gasto WHERE tb_gasto_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>