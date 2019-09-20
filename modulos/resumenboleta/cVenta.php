<?php
class cVenta{
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_resumenboleta
	WHERE tb_resumenboleta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_filtro($emp_id,$fec1){
		$sql="SELECT * 
		FROM tb_venta v
		LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
		INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
		LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
		WHERE v.tb_empresa_id = $emp_id 
		AND tb_venta_fec = '$fec1' ";
		
		$sql.=" AND td.cs_tipodocumento_cod = 3 ";
		
		$sql.=" ORDER BY tb_venta_fec, tb_venta_ser, tb_venta_num ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
    function mostrar_filtro_pendiente($emp_id){
        $sql="SELECT tb_venta_fec,rb.tb_venta_id,tb_venta_est
		FROM tb_venta v
		LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        
        LEFT JOIN tb_resumenboletadetalle rb ON v.tb_venta_id=rb.tb_venta_id
        
		WHERE v.tb_empresa_id = $emp_id AND rb.tb_venta_id IS NULL
        AND td.cs_tipodocumento_cod = 3 
        GROUP BY tb_venta_fec
        ORDER BY tb_venta_fec ASC";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_filtro_nc($emp_id,$fec1){
        $sql="SELECT * 
        FROM tb_notacredito v
        LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        LEFT JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
        WHERE v.tb_empresa_id = $emp_id 
        AND v.tb_venta_fec = '$fec1'
        AND v.tb_venta_ventipdoc=3
        
        UNION ALL 
        
        SELECT * 
        FROM tb_notadebito v
        LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        LEFT JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
        WHERE v.tb_empresa_id = $emp_id 
        AND v.tb_venta_fec = '$fec1'
        AND v.tb_venta_ventipdoc=3
        
        ";

        $sql.=" ORDER BY tb_venta_fec, tb_venta_ser, tb_venta_num ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_filtro_nc_pendiente($emp_id){
        $sql="SELECT * 
        FROM tb_notacredito v
        LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        LEFT JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
        WHERE v.tb_empresa_id = $emp_id 
        AND v.tb_venta_ventipdoc=3
        
        UNION ALL 
        
        SELECT * 
        FROM tb_notadebito v
        LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        LEFT JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
        WHERE v.tb_empresa_id = $emp_id 
        AND v.tb_venta_ventipdoc=3
        
        ";

        $sql.=" ORDER BY tb_venta_fec, tb_venta_ser, tb_venta_num ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function ultimo_numero($fec){
		$sql="SELECT IFNULL (max(tb_resumenboleta_num),0) as ultimo_numero FROM `tb_resumenboleta`
		WHERE tb_resumenboleta_fec='$fec'; ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}

	function listar_resumenboleta($fec){
	$sql="SELECT * 
	FROM tb_resumenboleta
	WHERE tb_resumenboleta_fecref = '$fec'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function guardar_resumenboleta($usu_id,$fec,$fecref,$cod,$num){
	$sql="INSERT INTO tb_resumenboleta 
	(
	tb_resumenboleta_reg,
	tb_resumenboleta_mod,
	tb_resumenboleta_usureg,
	tb_resumenboleta_usumod,
	tb_resumenboleta_fec,
	tb_resumenboleta_fecref,
	tb_resumenboleta_cod,
	tb_resumenboleta_num
	)
	VALUES(
	NOW(),
	NOW(),
	'$usu_id',
	'$usu_id',
	'$fec',
	'$fecref',
	'$cod',
	'$num'
	)";
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
	function guardar_resumenboleta_detalle($resbol_id,$num,$tipdoc_id,$ser,$cor,$cli_id,$tipdocrel,$docrelser,$docrelcor,$tipmon_id,$opegra,$opeexo,$opeina,$otrcar,$isc,$igv,$imptot,$ven_id,$est){
		$sql="INSERT INTO tb_resumenboletadetalle (
			`tb_resumenboleta_id`, 
			`tb_resumenboletadetalle_num`, 
			`cs_tipodocumento_id`, 
			`tb_resumenboletadetalle_ser`, 
			`tb_resumenboletadetalle_cor`,
			`tb_cliente_id`, 
			`tb_resumenboletadetalle_tipdocrel`,
			`tb_resumenboletadetalle_docrelser`,
			`tb_resumenboletadetalle_docrelcor`,  
			`cs_tipomoneda_id`, 
			`tb_resumenboletadetalle_opegra`, 
			`tb_resumenboletadetalle_opeexo`, 
			`tb_resumenboletadetalle_opeina`, 
			`tb_resumenboletadetalle_otrcar`, 
			`tb_resumenboletadetalle_isc`, 
			`tb_resumenboletadetalle_igv`, 
			`tb_resumenboletadetalle_imptot`,
			`tb_venta_id`,
			`tb_resumenboletadetalle_est`
		) VALUES ('$resbol_id', '$num', '$tipdoc_id', '$ser', '$cor', '$cli_id', '$tipdocrel', '$docrelser', '$docrelcor','$tipmon_id', '$opegra', '$opeexo', '$opeina', '$otrcar', '$isc', '$igv', '$imptot', '$ven_id', '$est');";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function listar_resumenboleta_detalle($id){
        $sql="SELECT * 
        FROM tb_resumenboletadetalle rbd
        LEFT JOIN cs_tipodocumento td ON rbd.cs_tipodocumento_id=td.cs_tipodocumento_id
        LEFT JOIN tb_cliente c ON rbd.tb_cliente_id=c.tb_cliente_id
        WHERE tb_resumenboleta_id = '$id'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
	}

	function comparar_resumenboleta_detalle($ven_id,$tipodoc){
        $sql="SELECT tb_resumenboletadetalle_id
        FROM tb_resumenboletadetalle
        WHERE tb_venta_id = '$ven_id' AND cs_tipodocumento_id='$tipodoc'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
	}
    function comparar_resumenboleta_detalle_pendiente($ven_id,$tipodoc){
        $sql="SELECT tb_resumenboletadetalle_id
        FROM tb_resumenboletadetalle
        WHERE tb_venta_id = '$ven_id' AND cs_tipodocumento_id='$tipodoc'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function comparar_resumenboleta_detalle_notas($ven_id,$tipodoc){
        $sql="SELECT tb_resumenboletadetalle_id
        FROM tb_resumenboletadetalle
        WHERE tb_venta_id = '$ven_id' AND cs_tipodocumento_id='$tipodoc'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function verificar($fecref){
        $sql="SELECT * 
        FROM tb_resumenboleta
        WHERE tb_resumenboleta_fecref='$fecref'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
	}
	
	function modificar_campo($id,$campo,$valor){
	$sql = "UPDATE tb_venta SET
	`tb_venta_$campo` =  '$valor'
	WHERE tb_venta_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function actualizar_sunat($id,$tic,$faucod,$digval,$sigval,$val,$est){
	$sql = "UPDATE tb_resumenboleta SET  
	`tb_resumenboleta_tic` =  '$tic',
	`tb_resumenboleta_faucod` =  '$faucod',
	`tb_resumenboleta_digval` =  '$digval',
	`tb_resumenboleta_sigval` =  '$sigval',
	`tb_resumenboleta_val` =  '$val',
	`tb_resumenboleta_fecenvsun` =  NOW(),
	`tb_resumenboleta_estsun` =  '$est'
	WHERE  tb_resumenboleta_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function actualizar_sunat2($id,$faucod2,$est2){
        $sql = "UPDATE tb_resumenboleta SET
		`tb_resumenboleta_faucod2` =  '$faucod2',
		`tb_resumenboleta_fecenvsun2` =  NOW(),
		`tb_resumenboleta_estsun2` =  '$est2'
		WHERE tb_resumenboleta_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

}
?>