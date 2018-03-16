<?php
class cIngreso{
	function insertar($fecemi,$feccon,$doc,$des,$mon,$est,$cue,$subcue,$entfin,$numope,$cli,$caj_id,$mon_id,$ref_id,$tra_id,$emp_id,$usu_id_reg,$usu_id_mod){
	$sql = "INSERT INTO tb_ingreso_r(
	`tb_ingreso_fecreg` ,
	`tb_ingreso_fecmod` ,
	`tb_ingreso_fecemi` ,
	`tb_ingreso_feccon` ,
	`tb_ingreso_doc` ,
	`tb_ingreso_des` ,
	`tb_ingreso_mon` ,
	`tb_ingreso_est` ,
	`tb_cuenta_id` ,
	`tb_subcuenta_id` ,
	`tb_entfinanciera_id` ,
	`tb_ingreso_numope` ,
	`tb_cliente_id` ,
	`tb_caja_id` ,
	`tb_moneda_id` ,
	`tb_referencia_id` ,
	`tb_transferencia_id` ,
	`tb_empresa_id` ,
	`tb_usuario_id_reg`,
	`tb_usuario_id_mod`
	)
	VALUES (
	NOW( ) ,NOW( ) ,  '$fecemi',  '$feccon',  '$doc',  '$des',  '$mon',  '$est',  '$cue',  '$subcue',  '$entfin', '$numope',  '$cli',  '$caj_id', '$mon_id',  '$ref_id', '$tra_id',  '$emp_id',  '$usu_id_reg', '$usu_id_mod'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar($id,$fecemi,$feccon,$doc,$des,$mon,$est,$cue,$subcue,$entfin,$numope,$cli,$caj_id,$mon_id,$ref_id,$usu_id_mod){
	$sql = "UPDATE tb_ingreso_r SET
	`tb_ingreso_fecmod` = NOW( ) ,
	`tb_ingreso_fecemi` =  '$fecemi',
	`tb_ingreso_feccon` =  '$feccon',
	`tb_ingreso_doc` =  '$doc',
	`tb_ingreso_des` =  '$des',
	`tb_ingreso_mon` =  '$mon',
	`tb_ingreso_est` =  '$est',
	`tb_cuenta_id` =  '$cue',
	`tb_subcuenta_id` =  '$subcue',
	`tb_entfinanciera_id` =  '$entfin',
	`tb_ingreso_numope` =  '$numope',
	`tb_cliente_id` =  '$cli',
	`tb_caja_id` =  '$caj_id',
	`tb_moneda_id` =  '$mon_id',
	`tb_referencia_id` =  '$ref_id',
	`tb_usuario_id_mod` =  '$usu_id_mod'
	 WHERE tb_ingreso_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_ingreso_r ORDER BY tb_empresa_id,tb_ingreso_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_emp($emp){
	$sql="SELECT * FROM tb_ingreso_r
	WHERE tb_empresa_id=$emp
	ORDER BY tb_ingreso_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function complete_des($emp,$des){
	$sql="SELECT DISTINCT(tb_ingreso_des) FROM tb_ingreso_r
	WHERE tb_empresa_id=$emp
	AND tb_ingreso_des like '%$des%'
	ORDER BY tb_ingreso_des
	LIMIT 0 , 10";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($emp_id,$y,$m,$cue_id,$subcue_id,$doc,$cli_id,$entfin_id,$est,$caj_id,$ref_id){
	$sql="SELECT * 
	FROM tb_ingreso_r i
	INNER JOIN tb_cuenta_r c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja_r cj ON i.tb_caja_id = cj.tb_caja_id
	LEFT JOIN tb_referencia r ON i.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON i.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	LEFT JOIN tb_subcuenta_r sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_empresa_id=$emp_id ";
	
	if($y!=0){
	$sql = $sql." AND YEAR( tb_ingreso_feccon ) =$y ";
	}
	if($m>0){
	$sql = $sql." AND MONTH( tb_ingreso_feccon ) =$m ";
	}
		/*if($m=="b")
		{
			//if($y!=0){
			$sql = $sql." AND tb_ingreso_feccon = '0000-00-00' ";
			//}
			//if($m>0){
			$sql = $sql." AND YEAR( tb_ingreso_fecemi) =$y ";
			//}
		}
		else
		{
			if($y!=0){
			$sql = $sql." AND YEAR( tb_ingreso_feccon ) =$y ";
			}
			if($m>0){
			$sql = $sql." AND MONTH( tb_ingreso_feccon ) =$m ";
			}
		}*/
	
		if($caj_id>0){
		$sql = $sql." AND i.tb_caja_id = $caj_id ";
		}
		if($ref_id>0){
		$sql = $sql." AND i.tb_referencia_id = $ref_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND i.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND i.tb_subcuenta_id = $subcue_id ";
		}
		
		if($doc!=""){
		$sql = $sql." AND tb_ingreso_doc LIKE '%$doc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND i.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_ingreso_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY tb_ingreso_feccon ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro_fec($emp_id,$fec1,$fec2,$cue_id,$subcue_id,$doc,$cli_id,$entfin_id,$est,$caj_id,$mon_id,$ref_id){
	$sql="SELECT * 
	FROM tb_ingreso_r i
	INNER JOIN tb_cuenta_r c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja_r cj ON i.tb_caja_id = cj.tb_caja_id
	LEFT JOIN tb_referencia r ON i.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON i.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	LEFT JOIN tb_subcuenta_r sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_empresa_id=$emp_id 
	AND tb_ingreso_feccon BETWEEN '$fec1' AND '$fec2' ";
	
		if($caj_id>0){
		$sql = $sql." AND i.tb_caja_id = $caj_id ";
		}
		if($mon_id>0){
		$sql = $sql." AND i.tb_moneda_id = $mon_id ";
		}
		if($ref_id>0){
		$sql = $sql." AND i.tb_referencia_id = $ref_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND i.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND i.tb_subcuenta_id = $subcue_id ";
		}
		
		if($doc!=""){
		$sql = $sql." AND tb_ingreso_doc LIKE '%$doc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND i.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_ingreso_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY tb_ingreso_feccon ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_suma($emp_id,$fec1,$fec2,$cue_id,$subcue_id,$doc,$cli_id,$entfin_id,$est,$caj_id,$ref_id){
	$sql="SELECT SUM(tb_ingreso_mon) as total 
	FROM tb_ingreso_r i
	INNER JOIN tb_cuenta_r c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja_r cj ON i.tb_caja_id = cj.tb_caja_id
	LEFT JOIN tb_referencia r ON i.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON i.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	LEFT JOIN tb_subcuenta_r sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_empresa_id=$emp_id 
	AND tb_ingreso_feccon BETWEEN '$fec1' AND '$fec2' ";
	
		if($caj_id>0){
		$sql = $sql." AND i.tb_caja_id = $caj_id ";
		}
		if($ref_id>0){
		$sql = $sql." AND i.tb_referencia_id = $ref_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND i.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND i.tb_subcuenta_id = $subcue_id ";
		}
		
		if($doc!=""){
		$sql = $sql." AND tb_ingreso_doc LIKE '%$doc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND i.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_ingreso_est LIKE '$est' ";
		}
		
		//$sql = $sql." ORDER BY tb_ingreso_feccon ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_ingreso_r 
	WHERE tb_ingreso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosIngreso(){
	$sql="SELECT DISTINCT (
	YEAR( tb_ingreso_feccon )) AS anio
	FROM  `tb_ingreso_r` 
	ORDER BY tb_ingreso_feccon";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function ingreso_suma_mes($emp,$y,$m,$est){
	$sql="SELECT FORMAT(SUM( tb_ingreso_mon ),2) AS ingreso_suma_mes 
	FROM tb_ingreso_r
	WHERE tb_empresa_id =$emp
	AND YEAR(tb_ingreso_feccon)=$y
	";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_ingreso_feccon)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_ingreso_est IN ('$est') ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_ingreso_r WHERE tb_ingreso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>