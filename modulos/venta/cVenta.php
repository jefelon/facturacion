<?php
class cVenta{
	function insertar($fec,$doc_id,$numdoc,$ser,$num,$cli_id,$valven,$igv,$des,$tot,$est,$lab1,$lab2,$lab3,$may,$usu_id,$punven_id,$emp_id,
		$tipdoc,$tipmon,$gra,$ina,$exp,$grat,$isc,$otrtri,$otrcar,$desglo,$tipope,$docrel,$use_id){
	$sql = "INSERT INTO tb_venta(
	`tb_venta_reg` ,
	`tb_venta_fec` ,
	`tb_documento_id` ,
	`tb_venta_numdoc` ,
	`tb_venta_ser` ,
	`tb_venta_num` ,
	`tb_cliente_id` ,
	`tb_venta_valven` ,
	`tb_venta_igv` ,
	`tb_venta_des` ,
	`tb_venta_tot` ,
	`tb_venta_est` ,
	`tb_venta_lab1` ,
	`tb_venta_lab2` ,
	`tb_venta_lab3` ,
	`tb_venta_may` ,
	`tb_usuario_id`,
	`tb_puntoventa_id`,
	`tb_empresa_id`,

	`cs_tipodocumento_id`,
	`cs_tipomoneda_id`,
	`tb_venta_gra`,
	`tb_venta_ina`,
	`tb_venta_exo`,
	`tb_venta_grat`,
	`tb_venta_isc`,
	`tb_venta_otrtri`,
	`tb_venta_otrcar`,
	`tb_venta_desglo`,
	`cs_tipooperacion_id`,
	`cs_documentosrelacionados_id`,
	`tb_vendedor_id`
	)
	VALUES (
	NOW( ) ,  '$fec',  '$doc_id',  '$numdoc', '$ser',  '$num',  '$cli_id',  '$valven',  '$igv', '$des',  '$tot',  '$est', '$lab1', '$lab2', '$lab3', '$may',  '$usu_id', '$punven_id', '$emp_id',
	'$tipdoc', '$tipmon', '$gra', '$ina', '$exp', '$grat', '$isc', '$otrtri', '$otrcar', '$desglo', '$tipope','$docrel','$use_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
    function insertarViajeVenta($ven_id,$viajehora_id,$asinum,$asifec, $pasaj, $parada){
        $sql = "INSERT INTO tb_viajeventa(`tb_venta_id` ,`tb_viajehorario_id` ,`tb_asiento_nom` ,`tb_viajeventa_fecha`,`tb_cliente_id`,`tb_viajeventa_parada`
	)
	VALUES ('$ven_id',   '$viajehora_id',  '$asinum', '$asifec', '$pasaj','$parada' 
	);";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function insertarEncomiendaVenta($ven_id,$remitente_id,$destinatario_nom,$origen_id, $destino_id,$clave,$pagado){
        $sql = "INSERT INTO tb_encomiendaventa(`tb_venta_id` ,`tb_remitente_id` ,`tb_destinatario_nom` ,`tb_origen_id`,`tb_destino_id`,`tb_encomiendaventa_clave`,`tb_encomiendaventa_pagado`
	)
	VALUES ('$ven_id',   '$remitente_id',  '$destinatario_nom', '$origen_id', '$destino_id','$clave','$pagado'
	);";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function insertarAsientoEstado($asinum,$viajehora_id,$dest_par){
        $sql = "INSERT INTO tb_asientoestado(`tb_asiento_id`,`tb_viajehorario_id` , `tb_asientoestado_reserva`, `tb_destpar_id`
	)
	VALUES ('$asinum','$viajehora_id', 0 , '$dest_par'
	);";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function insertar_detalle($tipven,$cat_id,$ser_id,$nom,$preuni,$can,$tipdes,$des,$preunilin,$valven,$igv,$ven_id,$afeigv,$unimed,$calisc,$isc,$nro,$pro_ser){
	$sql = "INSERT INTO tb_ventadetalle(
	`tb_ventadetalle_tipven`, 
	`tb_catalogo_id`, 
	`tb_servicio_id`, 
	`tb_ventadetalle_nom`, 
	`tb_ventadetalle_preuni`, 
	`tb_ventadetalle_can`, 
	`tb_ventadetalle_tipdes`, 
	`tb_ventadetalle_des`, 
	`tb_ventadetalle_preunilin`, 
	`tb_ventadetalle_valven`, 
	`tb_ventadetalle_igv`, 
	`tb_venta_id`, 
	`cs_tipoafectacionigv_id`, 
	`cs_tipounidadmedida_id`, 
	`cs_tiposistemacalculoisc_id`, 
	`tb_ventadetalle_isc`, 
	`tb_ventadetalle_nro`,
	`tb_ventadetalle_serie`
	) VALUES ('$tipven', '$cat_id', '$ser_id', '$nom', '$preuni', '$can', '$tipdes', '$des', '$preunilin', '$valven', '$igv', '$ven_id', '$afeigv', '$unimed', '$calisc', '$isc', '$nro','$pro_ser');";
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
	function mostrar_filtro($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$venmay,$tip){
	$sql="SELECT ev.tb_encomiendaventa_id, ev.tb_destinatario_nom, cc.tb_cliente_nom AS tb_remitente_nom, v.tb_venta_id,
    v.tb_venta_est,v.tb_documento_id, v.tb_venta_tot,td.cs_tipodocumento_cod,v.tb_venta_ser,v.tb_venta_num,
    v.tb_venta_fec, c.tb_cliente_nom,c.tb_cliente_doc ,v.cs_tipomoneda_id, d.tb_documento_ele, v.tb_venta_estsun, 
    v.tb_venta_fecenvsun, td.cs_tipodocumento_cod, d.tb_documento_abr, v.tb_venta_numdoc, d.tb_documento_nom, 
    v.tb_venta_valven, v.tb_venta_igv
    FROM tb_venta v LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id 
    LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id 
    INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id 
    LEFT JOIN tb_viajeventa vv ON vv.tb_venta_id=v.tb_venta_id 
    LEFT JOIN tb_encomiendaventa ev ON ev.tb_venta_id=v.tb_venta_id
    LEFT JOIN tb_cliente cc ON ev.tb_remitente_id=cc.tb_cliente_id 
    
	WHERE tb_usuario_id = $usu_id 
	AND tb_puntoventa_id = $punven_id
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";

	if ($tip=='ENCOMIENDA'){
        $sql.=" AND ev.tb_encomiendaventa_id IS NOT NULL";
    }
    if ($tip=='PASAJE'){
        $sql.=" AND vv.tb_viajeventa_id IS NOT NULL";
    }

	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro_detalle($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$venmay){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_ventadetalle vd ON v.tb_venta_id = vd.tb_venta_id
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_usuario_id = $usu_id 
	AND v.tb_puntoventa_id = $punven_id
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
	if($art=='s' and $cat_ids!="")$sql.=" AND s.tb_categoria_id IN ($cat_ids) ";
	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_filtro_comp($doc_id,$numdoc){
        $sql="SELECT * 
              FROM tb_venta v
              LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
              INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
              WHERE v.tb_documento_id = '$doc_id'
              AND v.tb_venta_numdoc = '$numdoc'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_filtro_doc($cliete_doc){
        $sql="SELECT * 
              FROM tb_venta v
              LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
              INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
              WHERE c.tb_cliente_doc = '$cliete_doc'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrar_filtro_adm($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
	$sql="SELECT ev.tb_encomiendaventa_id, vv.tb_viajeventa_id, v.tb_venta_id,v.tb_venta_est,v.tb_venta_tot,td.cs_tipodocumento_cod,v.tb_venta_ser,v.tb_venta_num,
    v.tb_venta_fec, c.tb_cliente_nom,c.tb_cliente_doc ,v.cs_tipomoneda_id, d.tb_documento_ele, v.tb_venta_estsun, 
    v.tb_venta_fecenvsun, td.cs_tipodocumento_cod, d.tb_documento_abr, v.tb_venta_numdoc, d.tb_documento_nom, 
    v.tb_venta_valven, v.tb_venta_igv 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	LEFT JOIN tb_encomiendaventa ev ON v.tb_venta_id=ev.tb_venta_id
	LEFT JOIN tb_viajeventa vv ON vv.tb_venta_id=v.tb_venta_id	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
	 if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	 if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	 if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	 if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	 if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
	 if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function mostrar_filtro_cobro_destino($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
        $sql="SELECT ev.tb_encomiendaventa_id, vv.tb_viajeventa_id, v.tb_venta_id,v.tb_venta_est,v.tb_venta_tot,td.cs_tipodocumento_cod,v.tb_venta_ser,v.tb_venta_num,
    v.tb_venta_fec, c.tb_cliente_nom,c.tb_cliente_doc ,v.cs_tipomoneda_id, d.tb_documento_ele, v.tb_venta_estsun, 
    v.tb_venta_fecenvsun, td.cs_tipodocumento_cod, d.tb_documento_abr, v.tb_venta_numdoc, d.tb_documento_nom, 
    v.tb_venta_valven, v.tb_venta_igv 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	LEFT JOIN tb_encomiendaventa ev ON v.tb_venta_id=ev.tb_venta_id
	LEFT JOIN tb_viajeventa vv ON vv.tb_venta_id=v.tb_venta_id	
	WHERE  vv.tb_viajeventa_id IS NULL AND ev.tb_encomiendaventa_id IS NULL
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";

        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
        if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
        if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
        if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";

        $sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_filtro_por_mes_anio($mes_id,$anio_id,$doc_id_1,$doc_id_2,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
        $sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id	
	WHERE (v.tb_empresa_id = $emp_id";


        if($doc_id_1>0)$sql.=" AND v.tb_documento_id = $doc_id_1 ";
        if($doc_id_1>0  && $doc_id_2>0)$sql.=" OR v.tb_documento_id = $doc_id_2)";

        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
        if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
        if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
        if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
        if($mes_id!="")$sql.=" AND MONTH(tb_venta_fec) = '$mes_id' ";
        if($anio_id!="")$sql.=" AND YEAR(tb_venta_fec) = '$anio_id' ";
        $sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


	function mostrar_filtro_detalle_adm($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_ventadetalle vd ON v.tb_venta_id = vd.tb_venta_id
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
	if($art=='s' and $cat_ids!="")$sql.=" AND s.tb_categoria_id IN ($cat_ids) ";
	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	if($venmay>0)$sql.=" AND v.tb_venta_may = $venmay ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_resumen_productos_adm($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$emp_id){
	$sql="SELECT tb_venta_est, tb_ventadetalle_tipven, p.tb_producto_id, p.tb_producto_nom, pr.tb_presentacion_id, pr.tb_presentacion_nom, un.tb_unidad_id, un.tb_unidad_abr, ct.tb_catalogo_mul, SUM(tb_ventadetalle_can) AS can, SUM(tb_ventadetalle_preuni) AS preuni, SUM(tb_ventadetalle_valven) AS valven, SUM(tb_ventadetalle_igv) AS igv
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_ventadetalle vd ON v.tb_venta_id = vd.tb_venta_id
	
	INNER JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" GROUP BY p.tb_producto_id, pr.tb_presentacion_id, un.tb_unidad_id ";
	
	//$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_resumen_servicios_adm($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$emp_id){
	$sql="SELECT tb_venta_est, tb_ventadetalle_tipven, s.tb_servicio_nom, SUM(tb_ventadetalle_can) AS can, SUM(tb_ventadetalle_preuni) AS preuni, SUM(tb_ventadetalle_valven) AS valven, SUM(tb_ventadetalle_igv) AS igv
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_ventadetalle vd ON v.tb_venta_id = vd.tb_venta_id
	
	INNER JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND v.tb_puntoventa_id = $punven_id ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" GROUP BY s.tb_servicio_id ";
	
	//$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	INNER JOIN tb_almacen a ON pv.tb_almacen_id=a.tb_almacen_id
	WHERE v.tb_venta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrarValorBruto($id){
        $sql="SELECT cs_tipoafectacionigv_cod,tb_ventadetalle_can,tb_ventadetalle_preuni ,tb_ventadetalle_des
	FROM tb_ventadetalle vd
	LEFT JOIN cs_tipoafectacionigv ai ON vd.cs_tipoafectacionigv_id=ai.cs_tipoafectacionigv_id
	WHERE tb_venta_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function convertir_hash($id){
	$key = 'RqvMXL87JGXZIfG9GCrR';
	$sql="SELECT * FROM tb_venta
	WHERE MD5(concat('$key',tb_venta_id)) = '$id'";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_venta_detalle_ps($ven_id){
	$sql="SELECT * 
	FROM tb_venta v
	INNER JOIN tb_ventadetalle vd ON v.tb_venta_id = vd.tb_venta_id
	LEFT JOIN cs_tipoafectacionigv ai ON vd.cs_tipoafectacionigv_id=ai.cs_tipoafectacionigv_id
	LEFT JOIN cs_tipounidadmedida um ON vd.cs_tipounidadmedida_id=um.cs_tipounidadmedida_id 
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_venta_id = $ven_id 
	ORDER BY tb_ventadetalle_nro";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrar_venta_detalle_ps_copia($ven_id){
	$sql="SELECT * 
	FROM tb_venta v
	INNER JOIN tb_ventadetalle vd ON v.tb_venta_id = vd.tb_venta_id
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_venta_id = $ven_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrar_venta_detalle($ven_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_ventadetalle vd ON ct.tb_catalogo_id = vd.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE vd.tb_venta_id=$ven_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_venta_detalle_servicio($ven_id){
	$sql="SELECT * 
	FROM tb_servicio s
	INNER JOIN tb_categoria c ON s.tb_categoria_id = c.tb_categoria_id		
	INNER JOIN tb_ventadetalle vd ON vd.tb_servicio_id = s.tb_servicio_id
	WHERE vd.tb_venta_id=$ven_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$fec,$cli_id,$est,$lab1){
	$sql = "UPDATE tb_venta SET  
	`tb_venta_fec` =  '$fec',
	`tb_cliente_id` =  '$cli_id',
	`tb_venta_est` =  '$est',
	`tb_venta_lab1` =  '$lab1' 
	WHERE  tb_venta_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_adm($id,$may,$lab1){
	$sql = "UPDATE tb_venta SET  
	`tb_venta_may` =  '$may',
	`tb_venta_lab1` =  '$lab1' 
	WHERE  tb_venta_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_usosoftware` 
WHERE tb_software_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_venta WHERE tb_venta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosVenta(){
	$sql="SELECT DISTINCT (
	YEAR( tb_venta_fec )) AS anio
	FROM  `tb_venta` 
	ORDER BY tb_venta_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_todos_por_empresa($emp_id, $alm_id){
	$sql="SELECT * 
	FROM tb_venta v
	INNER JOIN tb_puntoventa pv ON pv.tb_puntoventa_id = v.tb_puntoventa_id
	WHERE v.tb_empresa_id = $emp_id 
	AND pv.tb_almacen_id = $alm_id
	AND v.tb_venta_est IN ('CANCELADA')
	ORDER BY v.tb_venta_fec";
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
	function actualizar_sunat($id,$faucod,$digval,$sigval,$val,$est){
	$sql = "UPDATE tb_venta SET  
	`tb_venta_faucod` =  '$faucod',
	`tb_venta_digval` =  '$digval',
	`tb_venta_sigval` =  '$sigval',
	`tb_venta_val` =  '$val',
	`tb_venta_fecenvsun` =  NOW(),
	`tb_venta_estsun` =  '$est'
	WHERE  tb_venta_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function actualizar_sunat_cdr($id,$faucod,$est){
        $sql = "UPDATE tb_venta SET  
	`tb_venta_faucod` =  '$faucod',
	`tb_venta_fecenvsun` =  NOW(),
	`tb_venta_estsun` =  '$est'
	WHERE  tb_venta_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_encomienda_viaje($ven_id){
        $sql="SELECT ev.tb_encomiendaventa_id, ev.tb_venta_id, o.tb_lugar_nom AS ltb_origen, 
        d.tb_lugar_nom AS ltb_destino, cr.tb_cliente_nom AS crtb_cliente, ev.tb_destinatario_nom AS cdtb_cliente 
        FROM tb_encomiendaventa ev 
        LEFT JOIN tb_lugar o ON ev.tb_origen_id=o.tb_lugar_id 
        LEFT JOIN tb_lugar d ON ev.tb_destino_id=d.tb_lugar_id 
        LEFT JOIN tb_cliente cr ON ev.tb_remitente_id=cr.tb_cliente_id 
                        WHERE ev.tb_venta_id=$ven_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function modificar_encomiendaviaje_pagado($ven_id){
        $sql="UPDATE tb_encomiendaventa SET
        `tb_encomiendaventa_pagado` =  1
        WHERE tb_venta_id=$ven_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function modificar_puntoventa($ven_id,$punven_id){
        $sql="UPDATE tb_venta SET
        `tb_puntoventa_id` =  $punven_id
        WHERE tb_venta_id=$ven_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_viajeventa($ven_id){
        $sql="SELECT * FROM tb_viajeventa vv
        LEFT JOIN tb_cliente c ON vv.tb_cliente_id=c.tb_cliente_id
        LEFT JOIN tb_lugar l ON vv.tb_viajeventa_parada=l.tb_lugar_id
                        WHERE vv.tb_venta_id=$ven_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_viajehorario($vh_id){
        $sql="SELECT tb_viajehorario_id,tb_viajehorario_horario, tb_viajehorario_fecha, o.tb_lugar_nom AS ltb_origen, 
        d.tb_lugar_nom AS ltb_destino, tb_conductor_id,tb_copiloto_id FROM tb_viajehorario vh
              LEFT JOIN tb_lugar o ON vh.tb_viajehorario_salida=o.tb_lugar_id 
              LEFT JOIN tb_lugar d ON vh.tb_viajehorario_llegada=d.tb_lugar_id 
                        WHERE tb_viajehorario_id=$vh_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_cabecera_manifiesto($vh_id)
    {
        $sql = "SELECT vh.tb_viajehorario_fecha,vh.tb_viajehorario_horario,vh.tb_viajehorario_ser,vh.tb_viajehorario_num, 
        o.tb_lugar_nom as Origen, d.tb_lugar_nom as Destino, v.tb_vehiculo_marca,v.tb_vehiculo_placa,v.tb_vehiculo_numasi, 
        c.tb_conductor_nom, co.tb_conductor_nom AS tb_copiloto_nom,co.tb_conductor_lic AS tb_copiloto_lic, c.tb_conductor_lic 
        FROM tb_viajehorario vh 
        INNER JOIN tb_lugar o ON vh.tb_viajehorario_salida=o.tb_lugar_id 
        INNER JOIN tb_lugar d ON vh.tb_viajehorario_llegada=d.tb_lugar_id 
        INNER JOIN tb_vehiculo v ON vh.tb_vehiculo_id=v.tb_vehiculo_id 
        LEFT JOIN tb_conductor c ON vh.tb_conductor_id=c.tb_conductor_id
        LEFT JOIN tb_conductor co ON vh.tb_copiloto_id=co.tb_conductor_id
        WHERE tb_viajehorario_id=$vh_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_manifiesto($vh_id)
    {
        $sql = "SELECT * FROM tb_viajeventa vv 
        INNER JOIN tb_cliente c ON vv.tb_cliente_id=c.tb_cliente_id 
        INNER JOIN tb_venta v ON vv.tb_venta_id=v.tb_venta_id 
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        WHERE tb_viajehorario_id=$vh_id AND v.tb_venta_est NOT IN ('ANULADA')
        ORDER  BY v.tb_venta_numdoc
        ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_filtro_cliente($des_nom, $punven_id){
        $sql="SELECT * 
	FROM tb_encomiendaventa ev
	INNER JOIN tb_venta v ON v.tb_venta_id=ev.tb_venta_id
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_puntoventa pv ON ev.tb_destino_id=pv.tb_lugar_id	
	WHERE ev.tb_destinatario_nom = '$des_nom' AND pv.tb_puntoventa_id = '$punven_id' AND v.tb_venta_est NOT IN ('ANULADA') ORDER BY v.tb_venta_fec DESC";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_estado_enc($id,$clave){
        $sql = "SELECT * FROM tb_encomiendaventa 
        WHERE  tb_encomiendaventa_id=$id AND tb_encomiendaventa_clave=$clave;";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function modificar_estado_enc($id,$clave){
        $sql = "UPDATE tb_encomiendaventa SET  
	`tb_estado` =  1
	WHERE  tb_encomiendaventa_id=$id AND tb_encomiendaventa_clave=$clave;";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_venta_asiento($venta){
        $sql = "SELECT * 
        FROM tb_viajeventa vv 
        INNER JOIN tb_asientoestado ae ON vv.tb_viajehorario_id=ae.tb_viajehorario_id 
        INNER JOIN tb_asiento a ON a.tb_asiento_id=ae.tb_asiento_id 
        WHERE a.tb_asiento_nom = vv.tb_asiento_nom AND tb_venta_id=$venta;";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


    function mostrar_venta_viaje($venta){
        $sql = "SELECT * 
        FROM tb_viajeventa vv 
        INNER JOIN tb_asientoestado ae ON vv.tb_viajehorario_id=ae.tb_viajehorario_id 
        INNER JOIN tb_asiento a ON a.tb_asiento_id=ae.tb_asiento_id 
        WHERE a.tb_asiento_nom = vv.tb_asiento_nom AND tb_venta_id=$venta;";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function eliminar_asiento_estado($id){
        $sql="DELETE FROM tb_asientoestado WHERE tb_asientoestado_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


    function mostrar_cli_nom($dato, $punven_id){
        $sql = "SELECT DISTINCT(tb_destinatario_nom) 
        FROM tb_encomiendaventa ev
        INNER JOIN tb_puntoventa pv ON ev.tb_destino_id=pv.tb_lugar_id
        WHERE ev.tb_destinatario_nom LIKE '%$dato%' AND pv.tb_puntoventa_id = '$punven_id';";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_venta_encomienda($venta){
        $sql = "SELECT * 
        FROM tb_encomiendaventa ev 
        INNER JOIN tb_venta v ON v.tb_venta_id=ev.tb_venta_id 
        WHERE v.tb_venta_id=$venta;";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_venta_viaje2($vh_id,$asiento_id){
        $sql = "SELECT * 
        FROM tb_viajeventa
        WHERE tb_viajehorario_id=$vh_id AND tb_asiento_nom=$asiento_id";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function modificar_venta_viaje($vh_id,$asiento_id, $n_vh_id){
        $sql="UPDATE tb_viajeventa SET
        `tb_viajehorario_id` =  $n_vh_id
        WHERE tb_viajehorario_id=$vh_id AND tb_asiento_nom=$asiento_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>