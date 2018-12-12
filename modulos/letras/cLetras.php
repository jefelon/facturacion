<?php
class cLetras{
	function insertar($ven_id, $fec, $monto, $orden,  $numero){
	$sql = "INSERT tb_letras (
		`tb_venta_id`,
		`tb_letras_fecha`,
		`tb_letras_monto`,
		`tb_letras_orden`,
		`tb_letras_numero`
		)
		VALUES (
		 '$ven_id',
		 '$fec',
		 '$monto',
		 '$orden',
		 '$numero'
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
	function mostrarTodos(){
	$sql="SELECT * 
	FROM tb_letras
	ORDER BY tb_letras_orden";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_letras($ven_id){
        $sql="SELECT * 
	FROM tb_letras
	WHERE tb_venta_id=$ven_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_letra($ven_id,$letra_id){
        $sql="SELECT * 
	FROM tb_letras
	WHERE tb_venta_id=$ven_id AND tb_letras_id = $letra_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_letras
	WHERE tb_letras_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $monto){
	$sql = "UPDATE tb_lote SET  
	`tb_letras_monto` =  '$monto'
	WHERE  tb_letras_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_letras_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_letras_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_letras WHERE tb_letras_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function actual_numero_letra(){
        $sql="SELECT max(tb_letras_numero) as max_letras FROM tb_letras";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_filtro($fec1,$fec2,$doc_id,$cli_id,$est,$punven_id,$empresa_id){
        $sql="SELECT * 
        FROM tb_venta v
        LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
        INNER JOIN tb_letras l ON v.tb_venta_id=l.tb_venta_id 
        WHERE tb_puntoventa_id = $punven_id
        AND v.tb_empresa_id=$empresa_id AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";

        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";

        $sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>