<?php
class cIngreso{
	function insertar($usureg,$usumod,$xac,$fec,$doc_id,$numdoc,$det,$imp,$est,$cue_id,$subcue_id,$cli_id,$caj_id,$mon_id,$mod_id,$modide,$emp_id){
	$sql = "INSERT INTO  tb_ingreso(
	`tb_ingreso_fecreg` ,
	`tb_ingreso_fecmod` ,
	`tb_ingreso_usureg` ,
	`tb_ingreso_usumod` ,
	`tb_ingreso_xac` ,
	`tb_ingreso_fec` ,
	`tb_documento_id` ,
	`tb_ingreso_numdoc` ,
	`tb_ingreso_det` ,
	`tb_ingreso_imp` ,
	`tb_ingreso_est` ,
	`tb_cuenta_id` ,
	`tb_subcuenta_id` ,
	`tb_cliente_id` ,
	`tb_caja_id` ,
	`tb_moneda_id` ,
	`tb_modulo_id` ,
	`tb_ingreso_modide` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$usureg',  '$usumod',  '$xac',  '$fec',  '$doc_id',  '$numdoc',  '$det',  '$imp',  '$est',  '$cue_id',  '$subcue_id',  '$cli_id',  '$caj_id',  '$mon_id',  '$mod_id',  '$modide',  '$emp_id'
	);"; 
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
	function modificar($id,$usumod,$fec,$det,$imp,$est,$cue_id,$subcue_id,$caj_id,$mon_id){
	$sql = "UPDATE tb_ingreso SET
	`tb_ingreso_fecmod` = NOW( ) ,
	`tb_ingreso_usumod` =  '$usumod',
	`tb_ingreso_fec` =  '$fec',
	`tb_ingreso_det` =  '$det',
	`tb_ingreso_imp` =  '$imp',
	`tb_ingreso_est` =  '$est',
	`tb_cuenta_id` =  '$cue_id',
	`tb_subcuenta_id` =  '$subcue_id',
	`tb_caja_id` =  '$caj_id',
	`tb_moneda_id` =  '$mon_id'
	WHERE tb_ingreso_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_ingreso ORDER BY tb_empresa_id,tb_ingreso_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_emp($emp){
	$sql="SELECT * FROM tb_ingreso
	WHERE tb_empresa_id=$emp
	ORDER BY tb_ingreso_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function complete_det($emp,$det){
	$sql="SELECT DISTINCT(tb_ingreso_det) FROM tb_ingreso
	WHERE tb_empresa_id=$emp
	AND tb_ingreso_det like '%$det%'
	ORDER BY tb_ingreso_det
	LIMIT 0 , 10";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro2($emp_id,$y,$m,$cue_id,$subcue_id,$doc,$cli_id,$entfin_id,$est,$caj_id,$ref_id){
	$sql="SELECT * 
	FROM tb_ingreso i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_referencia r ON i.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON i.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
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
	function mostrar_filtro($emp_id,$caj_id,$fec1,$fec2,$cue_id,$subcue_id,$doc_id,$numdoc,$cli_id,$est){
	$sql="SELECT * 
	FROM tb_ingreso i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	INNER JOIN tb_documento d ON i.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_ingreso_xac=1
	AND i.tb_empresa_id=$emp_id 
	AND i.tb_ingreso_fec BETWEEN '$fec1' AND '$fec2' ";
	
		if($caj_id>0){
		$sql = $sql." AND i.tb_caja_id = $caj_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND i.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND i.tb_subcuenta_id = $subcue_id ";
		}
		if($doc_id>0){
		$sql = $sql." AND i.tb_documento_id = $doc_id ";
		}
		if($numdoc!=""){
		$sql = $sql." AND tb_ingreso_numdoc LIKE '%$numdoc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_ingreso_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY i.tb_ingreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_por_modulo($mod_id,$modide,$est){
	$sql="SELECT * 
	FROM tb_ingreso i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	INNER JOIN tb_documento d ON i.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_ingreso_xac=1
	AND tb_modulo_id=$mod_id
	AND tb_ingreso_modide=$modide ";
	
	if($est!='')$sql = $sql." AND tb_ingreso_est IN ($est) ";
	$sql = $sql." ORDER BY tb_ingreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrar_por_transferencia($tra_id,$est){
	$sql="SELECT * 
	FROM tb_ingreso i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	INNER JOIN tb_documento d ON i.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_ingreso_xac=1
	AND i.tb_transferencia_id=$tra_id ";
	
	if($est!='')$sql = $sql." AND tb_ingreso_est IN ($est) ";

	$sql = $sql." ORDER BY tb_ingreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_suma($emp_id,$caj_id,$fec1,$fec2,$cue_id,$subcue_id,$numdoc,$cli_id,$est){
	$sql="SELECT SUM(tb_ingreso_imp) as total 
	FROM tb_ingreso i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	INNER JOIN tb_documento d ON i.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_ingreso_xac=1
	AND i.tb_empresa_id=$emp_id 
	AND tb_ingreso_fec BETWEEN '$fec1' AND '$fec2' ";
	
		if($caj_id>0){
		$sql = $sql." AND i.tb_caja_id = $caj_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND i.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND i.tb_subcuenta_id = $subcue_id ";
		}
		
		if($numdoc!=""){
		$sql = $sql." AND tb_ingreso_numdoc LIKE '%$numdoc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_ingreso_est LIKE '$est' ";
		}
		
		//$sql = $sql." ORDER BY tb_ingreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_ingreso i 
	INNER JOIN tb_cliente c ON i.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON i.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_caja cj ON i.tb_caja_id=cj.tb_caja_id
	WHERE tb_ingreso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosIngreso(){
	$sql="SELECT DISTINCT (
	YEAR( tb_ingreso_feccon )) AS anio
	FROM  `tb_ingreso` 
	ORDER BY tb_ingreso_feccon";
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
	$sql = $sql." AND tb_ingreso_est IN ('$est') ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_campo($id,$usumod,$campo,$valor){
	$sql = "UPDATE tb_ingreso SET
	`tb_ingreso_fecmod` = NOW( ) ,
	`tb_ingreso_usumod` =  '$usumod',
	`tb_ingreso_$campo` =  '$valor' 
	WHERE tb_ingreso_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function eliminar($id){
	$sql="DELETE FROM tb_ingreso WHERE tb_ingreso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>