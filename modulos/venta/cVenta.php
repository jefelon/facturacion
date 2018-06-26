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
	// function insertar_detalle($tipven,$cat_id,$ser_id,$nom,$preuni,$can,$tipdes,$des,$preunilin,$valven,$igv,$ven_id,$afeigv,$unimed,$calisc,$isc,$nro){
	// $sql = "INSERT INTO tb_ventadetalle(
	// `tb_ventadetalle_tipven` ,
	// `tb_catalogo_id` ,
	// `tb_servicio_id` ,
	// `tb_ventadetalle_nom` ,
	// `tb_ventadetalle_preuni` ,
	// `tb_ventadetalle_can` ,
	// `tb_ventadetalle_tipdes` ,
	// `tb_ventadetalle_des` ,
	// `tb_ventadetalle_preunilin` ,
	// `tb_ventadetalle_valven` ,
	// `tb_ventadetalle_igv` ,
	// `cs_tipoafectacionigv_id`,
	// `cs_tipounidadmedida_id`,
	// `cs_tiposistemacalculoisc_id`,
	// `tb_ventadetalle_isc`,
	// `tb_ventadetalle_nro`
	// )
	// VALUES (
	// '$tipven',  '$cat_id',  '$ser_id', '$nom', '$preuni',  '$can',  '$tipdes',  '$des',  '$preunilin',  '$valven',  '$igv',  '$ven_id', '$afeigv', '$unimed', '$calisc', '$isc', '$nro'
	// );"; 
	// $oCado = new Cado();
	// $rst=$oCado->ejecute_sql($sql);
	// return $rst;	
	// }
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
	function mostrar_filtro($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$venmay){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	WHERE tb_usuario_id = $usu_id 
	AND tb_puntoventa_id = $punven_id
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
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
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id	
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


    function mostrar_filtro_por_mes_anio($mes_id,$anio_id,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
        $sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id	
	WHERE v.tb_empresa_id = $emp_id 
	AND MONTH(v.tb_venta_fec) =$mes_id AND YEAR(v.tb_venta_fec) = $anio_id";


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
}
?>