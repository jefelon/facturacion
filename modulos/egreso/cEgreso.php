<?php
class cEgreso{
	function insertar($usureg,$usumod,$xac,$fec,$doc_id,$numdoc,$det,$imp,$est,$cue_id,$subcue_id,$pro_id,$caj_id,$mon_id,$mod_id,$modide,$emp_id){
	$sql = "INSERT INTO  tb_egreso(
	`tb_egreso_fecreg` ,
	`tb_egreso_fecmod` ,
	`tb_egreso_usureg` ,
	`tb_egreso_usumod` ,
	`tb_egreso_xac` ,
	`tb_egreso_fec` ,
	`tb_documento_id` ,
	`tb_egreso_numdoc` ,
	`tb_egreso_det` ,
	`tb_egreso_imp` ,
	`tb_egreso_est` ,
	`tb_cuenta_id` ,
	`tb_subcuenta_id` ,
	`tb_proveedor_id` ,
	`tb_caja_id` ,
	`tb_moneda_id` ,
	`tb_modulo_id` ,
	`tb_egreso_modide` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$usureg',  '$usumod',  '$xac',  '$fec',  '$doc_id',  '$numdoc',  '$det',  '$imp',  '$est',  '$cue_id',  '$subcue_id',  '$pro_id',  '$caj_id',  '$mon_id', '$mod_id', '$modide',  '$emp_id'
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
	$sql = "UPDATE tb_egreso SET
	`tb_egreso_fecmod` = NOW( ) ,
	`tb_egreso_usumod` =  '$usumod',
	`tb_egreso_fec` =  '$fec',
	`tb_egreso_det` =  '$det',
	`tb_egreso_imp` =  '$imp',
	`tb_egreso_est` =  '$est',
	`tb_cuenta_id` =  '$cue_id',
	`tb_subcuenta_id` =  '$subcue_id',
	`tb_caja_id` =  '$caj_id',
	`tb_moneda_id` =  '$mon_id'
	WHERE tb_egreso_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarTodos(){
	$sql="SELECT * FROM tb_egreso ORDER BY tb_empresa_id,tb_egreso_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarTodos_emp($emp){
	$sql="SELECT * FROM tb_egreso
	WHERE tb_empresa_id=$emp
	ORDER BY tb_egreso_fecemi";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function complete_det($emp,$det){
	$sql="SELECT DISTINCT(tb_egreso_det) FROM tb_egreso
	WHERE tb_empresa_id=$emp
	AND tb_egreso_det like '%$det%'
	ORDER BY tb_egreso_det
	LIMIT 0 , 10";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro2($emp_id,$y,$m,$cue_id,$subcue_id,$doc,$cli_id,$entfin_id,$est,$caj_id,$ref_id){
	$sql="SELECT * 
	FROM tb_egreso i
	INNER JOIN tb_cuenta c ON i.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON i.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_referencia r ON i.tb_referencia_id = r.tb_referencia_id
	LEFT JOIN tb_entfinanciera ef ON i.tb_entfinanciera_id=ef.tb_entfinanciera_id
	LEFT JOIN tb_cliente cl ON i.tb_cliente_id = cl.tb_cliente_id
	LEFT JOIN tb_subcuenta sc ON i.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE i.tb_empresa_id=$emp_id ";
	
	if($y!=0){
	$sql = $sql." AND YEAR( tb_egreso_feccon ) =$y ";
	}
	if($m>0){
	$sql = $sql." AND MONTH( tb_egreso_feccon ) =$m ";
	}
		/*if($m=="b")
		{
			//if($y!=0){
			$sql = $sql." AND tb_egreso_feccon = '0000-00-00' ";
			//}
			//if($m>0){
			$sql = $sql." AND YEAR( tb_egreso_fecemi) =$y ";
			//}
		}
		else
		{
			if($y!=0){
			$sql = $sql." AND YEAR( tb_egreso_feccon ) =$y ";
			}
			if($m>0){
			$sql = $sql." AND MONTH( tb_egreso_feccon ) =$m ";
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
		$sql = $sql." AND tb_egreso_doc LIKE '%$doc%' ";
		}
		
		if($cli_id>0){
		$sql = $sql." AND i.tb_cliente_id = $cli_id ";
		}
		if($entfin_id>0){
		$sql = $sql." AND i.tb_entfinanciera_id = $entfin_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_egreso_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY tb_egreso_feccon ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($emp_id,$caj_id,$fec1,$fec2,$cue_id,$subcue_id,$doc_id,$numdoc,$pro_id,$est){
	$sql="SELECT * 
	FROM tb_egreso e
	INNER JOIN tb_cuenta c ON e.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON e.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_proveedor p ON e.tb_proveedor_id = p.tb_proveedor_id
	INNER JOIN tb_documento d ON e.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON e.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_egreso_xac=1
	AND e.tb_empresa_id=$emp_id 
	AND tb_egreso_fec BETWEEN '$fec1' AND '$fec2' ";
	
		if($caj_id>0){
		$sql = $sql." AND e.tb_caja_id = $caj_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND e.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND e.tb_subcuenta_id = $subcue_id ";
		}
		if($doc_id>0){
		$sql = $sql." AND e.tb_documento_id = $doc_id ";
		}
		if($numdoc!=""){
		$sql = $sql." AND tb_egreso_numdoc LIKE '%$numdoc%' ";
		}
		
		if($pro_id>0){
		$sql = $sql." AND e.tb_proveedor_id = $pro_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_egreso_est LIKE '$est' ";
		}
		
		$sql = $sql." ORDER BY tb_egreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_filtro_fechahora($emp_id,$caj_id,$fec1,$fec2,$cue_id,$subcue_id,$doc_id,$numdoc,$pro_id,$est){
        $sql="SELECT * 
	FROM tb_egreso e
	INNER JOIN tb_cuenta c ON e.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON e.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_proveedor p ON e.tb_proveedor_id = p.tb_proveedor_id
	INNER JOIN tb_documento d ON e.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON e.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_egreso_xac=1
	AND e.tb_empresa_id=$emp_id 
	AND tb_egreso_fecreg BETWEEN '$fec1' AND '$fec2' ";

        if($caj_id>0){
            $sql = $sql." AND e.tb_caja_id = $caj_id ";
        }
        if($cue_id>0){
            $sql = $sql." AND e.tb_cuenta_id = $cue_id ";
        }
        if($subcue_id>0){
            $sql = $sql." AND e.tb_subcuenta_id = $subcue_id ";
        }
        if($doc_id>0){
            $sql = $sql." AND e.tb_documento_id = $doc_id ";
        }
        if($numdoc!=""){
            $sql = $sql." AND tb_egreso_numdoc LIKE '%$numdoc%' ";
        }

        if($pro_id>0){
            $sql = $sql." AND e.tb_proveedor_id = $pro_id ";
        }
        if($est!=''){
            $sql = $sql." AND tb_egreso_est LIKE '$est' ";
        }

        $sql = $sql." ORDER BY tb_egreso_fec ";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrar_suma($emp_id,$caj_id,$fec1,$fec2,$cue_id,$subcue_id,$numdoc,$pro_id,$est){
	$sql="SELECT SUM(tb_egreso_imp) as total 
	FROM tb_egreso e
	INNER JOIN tb_cuenta c ON e.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON e.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_proveedor p ON e.tb_proveedor_id = p.tb_proveedor_id
	INNER JOIN tb_documento d ON e.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON e.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_egreso_xac=1
	AND e.tb_empresa_id=$emp_id 
	AND tb_egreso_fec BETWEEN '$fec1' AND '$fec2' ";
	
		if($caj_id>0){
		$sql = $sql." AND e.tb_caja_id = $caj_id ";
		}
		if($cue_id>0){
		$sql = $sql." AND e.tb_cuenta_id = $cue_id ";
		}
		if($subcue_id>0){
		$sql = $sql." AND e.tb_subcuenta_id = $subcue_id ";
		}
		
		if($numdoc!=""){
		$sql = $sql." AND tb_egreso_numdoc LIKE '%$numdoc%' ";
		}
		
		if($pro_id>0){
		$sql = $sql." AND e.tb_proveedor_id = $pro_id ";
		}
		if($est!=''){
		$sql = $sql." AND tb_egreso_est LIKE '$est' ";
		}
		
		//$sql = $sql." ORDER BY tb_egreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_gasto($gas_id,$est){
	$sql="SELECT * 
	FROM tb_egreso e
	INNER JOIN tb_cuenta c ON e.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON e.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_proveedor p ON e.tb_proveedor_id = p.tb_proveedor_id
	INNER JOIN tb_documento d ON e.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON e.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_egreso_xac=1
	AND e.tb_gasto_id=$gas_id ";
	
	if($est!='')$sql = $sql." AND tb_egreso_est IN ($est) ";
	$sql = $sql." ORDER BY tb_egreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_transferencia($tra_id,$est){
	$sql="
SELECT * 
	FROM tb_egreso e
	INNER JOIN tb_cuenta c ON e.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON e.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_proveedor p ON e.tb_proveedor_id = p.tb_proveedor_id
	INNER JOIN tb_documento d ON e.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON e.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_egreso_xac=1
	AND e.tb_transferencia_id=$tra_id  ";
	
	if($est!='')$sql = $sql." AND tb_egreso_est IN ($est) ";

	$sql = $sql." ORDER BY tb_egreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrar_por_modulo($mod_id,$modide,$est){
	$sql="SELECT * 
	FROM tb_egreso e
	INNER JOIN tb_cuenta c ON e.tb_cuenta_id = c.tb_cuenta_id
	INNER JOIN tb_caja cj ON e.tb_caja_id = cj.tb_caja_id
	INNER JOIN tb_proveedor p ON e.tb_proveedor_id = p.tb_proveedor_id
	INNER JOIN tb_documento d ON e.tb_documento_id=d.tb_documento_id
	LEFT JOIN tb_subcuenta sc ON e.tb_subcuenta_id = sc.tb_subcuenta_id
	WHERE tb_egreso_xac=1
	AND tb_modulo_id=$mod_id
	AND tb_egreso_modide=$modide ";
	
	if($est!='')$sql = $sql." AND tb_egreso_est IN ($est) ";
	$sql = $sql." ORDER BY tb_egreso_fec ";
		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_egreso e
	INNER JOIN tb_proveedor p ON e.tb_proveedor_id=p.tb_proveedor_id
	INNER JOIN tb_documento d ON e.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_caja c ON e.tb_caja_id=c.tb_caja_id
	WHERE tb_egreso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosIngreso(){
	$sql="SELECT DISTINCT (
	YEAR( tb_egreso_feccon )) AS anio
	FROM  `tb_egreso` 
	ORDER BY tb_egreso_feccon";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function egreso_suma_mes($emp,$y,$m,$est){
	$sql="SELECT FORMAT(SUM( tb_egreso_mon ),2) AS egreso_suma_mes 
	FROM tb_egreso
	WHERE tb_empresa_id =$emp
	AND YEAR(tb_egreso_feccon)=$y
	";
	if($m!=0){
	$sql = $sql." AND MONTH(tb_egreso_feccon)=$m ";
		}
	if($est!=""){
	$sql = $sql." AND tb_egreso_est IN ('$est') ;";
		}
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_campo($id,$usumod,$campo,$valor){
	$sql = "UPDATE tb_egreso SET
	`tb_egreso_fecmod` = NOW( ) ,
	`tb_egreso_usumod` =  '$usumod',
	`tb_egreso_$campo` =  '$valor' 
	WHERE tb_egreso_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function eliminar($id){
	$sql="DELETE FROM tb_egreso WHERE tb_egreso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>