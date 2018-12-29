<?php
session_start();
class cTransferencia{
	function insertar($usureg,$usumod,$xac,$fec,$det,$imp,$est,$caj_id_ori,$caj_id_des,$mon_id,$emp_id){
	$sql = "INSERT INTO tb_transferencia(
	`tb_transferencia_fecreg` ,
	`tb_transferencia_fecmod` ,
	`tb_transferencia_usureg` ,
	`tb_transferencia_usumod` ,
	`tb_transferencia_xac` ,
	`tb_transferencia_fec` ,
	`tb_transferencia_det` ,
	`tb_transferencia_imp` ,
	`tb_transferencia_est` ,
	`tb_caja_id_ori` ,
	`tb_caja_id_des` ,
	`tb_moneda_id` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$usureg',  '$usumod',  '$xac',  '$fec',  '$det',  '$imp',  '$est',  '$caj_id_ori',  '$caj_id_des',  '$mon_id',  '$emp_id'
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
	function modificar($id,$fecemi,$feccon,$doc,$des,$mon,$est,$cue,$subcue,$entfin,$numope,$cli,$caj_id,$ref_id,$usu_id_mod){
	$sql = "UPDATE tb_transferencia SET
	`tb_transferencia_fecmod` = NOW( ) ,
	`tb_transferencia_fecemi` =  '$fecemi',
	`tb_transferencia_feccon` =  '$feccon',
	`tb_transferencia_doc` =  '$doc',
	`tb_transferencia_des` =  '$des',
	`tb_transferencia_mon` =  '$mon',
	`tb_transferencia_est` =  '$est',
	`tb_cuenta_id` =  '$cue',
	`tb_subcuenta_id` =  '$subcue',
	`tb_entfinanciera_id` =  '$entfin',
	`tb_transferencia_numope` =  '$numope',
	`tb_cliente_id` =  '$cli',
	`tb_caja_id` =  '$caj_id',
	`tb_referencia_id` =  '$ref_id',
	`tb_usuario_id_mod` =  '$usu_id_mod'
	 WHERE tb_transferencia_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_transferencia WHERE tb_empresa_id ='{$_SESSION['empresa_id']}' ORDER BY tb_empresa_id,tb_transferencia_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function codigo(){
	$sql="SELECT MAX(tb_transferencia_id) as maximo 
	FROM tb_transferencia WHERE tb_empresa_id ='{$_SESSION['empresa_id']}'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function complete_des($emp,$det){
	$sql="SELECT DISTINCT(tb_transferencia_det) FROM tb_transferencia
	WHERE tb_empresa_id=$emp
	AND tb_transferencia_det like '%$det%'
	ORDER BY tb_transferencia_det
	LIMIT 0 , 10";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro2($emp_id,$y,$m,$cue_id,$subcue_id,$doc,$cli_id,$entfin_id,$est,$caj_id,$ref_id){
	$sql="SELECT * 
	FROM tb_transferencia i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_referencia r ON i.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON i.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_empresa_id=$emp_id ";
	
	if($y!=0){
	$sql = $sql." AND YEAR( tb_transferencia_feccon ) =$y ";
	}
	if($m>0){
	$sql = $sql." AND MONTH( tb_transferencia_feccon ) =$m ";
	}
		/*if($m=="b")
		{
			//if($y!=0){
			$sql = $sql." AND tb_transferencia_feccon = '0000-00-00' ";
			//}
			//if($m>0){
			$sql = $sql." AND YEAR( tb_transferencia_fecemi) =$y ";
			//}
		}
		else
		{
			if($y!=0){
			$sql = $sql." AND YEAR( tb_transferencia_feccon ) =$y ";
			}
			if($m>0){
			$sql = $sql." AND MONTH( tb_transferencia_feccon ) =$m ";
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
		$sql = $sql." AND tb_transferencia_doc LIKE '%$doc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND i.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_transferencia_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY tb_transferencia_feccon ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($emp_id,$fec1,$fec2,$caj_id_ori,$caj_id_des){
	$sql="SELECT tb_transferencia_id, tb_transferencia_fecreg, tb_transferencia_fecmod, tb_transferencia_fec, tb_transferencia_det, tb_transferencia_imp, tb_transferencia_est, co.tb_caja_nom AS caja_ori, cd.tb_caja_nom AS caja_des, tb_caja_id_ori, tb_caja_id_des
	FROM tb_transferencia t
	INNER JOIN tb_caja co ON t.tb_caja_id_ori = co.tb_caja_id
	INNER JOIN tb_caja cd ON t.tb_caja_id_des = cd.tb_caja_id
	
	WHERE tb_transferencia_xac=1
	AND tb_empresa_id=$emp_id 
	AND tb_transferencia_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($caj_id_ori>0){
	$sql = $sql." AND t.tb_caja_id_ori = $caj_id_ori ";
	}
	if($caj_id_des>0){
	$sql = $sql." AND t.tb_caja_id_des = $caj_id_des ";
	}
	$sql = $sql." ORDER BY tb_transferencia_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_suma($emp_id,$fec1,$fec2,$cue_id,$subcue_id,$doc,$cli_id,$entfin_id,$est,$caj_id,$ref_id){
	$sql="SELECT SUM(tb_transferencia_mon) as total 
	FROM tb_transferencia i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_referencia r ON i.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON i.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_empresa_id=$emp_id 
	AND tb_transferencia_feccon BETWEEN '$fec1' AND '$fec2' ";
	
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
		$sql = $sql." AND tb_transferencia_doc LIKE '%$doc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND i.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_transferencia_est LIKE '$est' ";
		}
		
		//$sql = $sql." ORDER BY tb_transferencia_feccon ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_transferencia 
	WHERE tb_transferencia_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosTransferencia(){
	$sql="SELECT DISTINCT (
	YEAR( tb_transferencia_feccon )) AS anio
	FROM  `tb_transferencia` 
	ORDER BY tb_transferencia_feccon";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function transferencia_suma_mes($emp,$y,$m,$est){
	$sql="SELECT FORMAT(SUM( tb_transferencia_mon ),2) AS transferencia_suma_mes 
	FROM tb_transferencia
	WHERE tb_empresa_id =$emp
	AND YEAR(tb_transferencia_feccon)=$y
	";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_transferencia_feccon)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_transferencia_est IN ('$est') ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_campo($id,$usumod,$campo,$valor){
	$sql = "UPDATE tb_transferencia SET
	`tb_transferencia_fecmod` = NOW( ) ,
	`tb_transferencia_usumod` =  '$usumod',
	`tb_transferencia_$campo` =  '$valor' 
	WHERE tb_transferencia_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function eliminar($id){
	$sql="DELETE FROM tb_transferencia WHERE tb_transferencia_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>