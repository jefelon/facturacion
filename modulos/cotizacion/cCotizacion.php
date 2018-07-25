<?php
class cCotizacion{
    function insertar($fec,$doc_id,$numdoc,$ser,$num,$cli_id,$valven,$igv,$des,$tot,$est,$lab1,$lab2,$lab3,$may,$usu_id,$punven_id,$emp_id,
                      $tipdoc,$tipmon,$gra,$ina,$exp,$grat,$isc,$otrtri,$otrcar,$desglo,$tipope,$docrel){
        $sql = "INSERT INTO tb_cotizacion(
	`tb_cotizacion_reg` ,
	`tb_cotizacion_fec` ,
	`tb_documento_id` ,
	`tb_cotizacion_numdoc` ,
	`tb_cotizacion_ser` ,
	`tb_cotizacion_num` ,
	`tb_cliente_id` ,
	`tb_cotizacion_valven` ,
	`tb_cotizacion_igv` ,
	`tb_cotizacion_des` ,
	`tb_cotizacion_tot` ,
	`tb_cotizacion_est` ,
	`tb_cotizacion_lab1` ,
	`tb_cotizacion_lab2` ,
	`tb_cotizacion_lab3` ,
	`tb_cotizacion_may` ,
	`tb_usuario_id`,
	`tb_puntocotizacion_id`,
	`tb_empresa_id`,

	`cs_tipodocumento_id`,
	`cs_tipomoneda_id`,
	`tb_cotizacion_gra`,
	`tb_cotizacion_ina`,
	`tb_cotizacion_exo`,
	`tb_cotizacion_grat`,
	`tb_cotizacion_isc`,
	`tb_cotizacion_otrtri`,
	`tb_cotizacion_otrcar`,
	`tb_cotizacion_desglo`,
	`cs_tipooperacion_id`,
	`cs_documentosrelacionados_id`
	)
	VALUES (
	NOW( ) ,  '$fec',  '$doc_id',  '$numdoc', '$ser',  '$num',  '$cli_id',  '$valven',  '$igv', '$des',  '$tot',  '$est', '$lab1', '$lab2', '$lab3', '$may',  '$usu_id', '$punven_id', '$emp_id',
	'$tipdoc', '$tipmon', '$gra', '$ina', '$exp', '$grat', '$isc', '$otrtri', '$otrcar', '$desglo', '$tipope','$docrel'
	);";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    // function insertar_detalle($tipven,$cat_id,$ser_id,$nom,$preuni,$can,$tipdes,$des,$preunilin,$valven,$igv,$ven_id,$afeigv,$unimed,$calisc,$isc,$nro){
    // $sql = "INSERT INTO tb_cotizaciondetalle(
    // `tb_cotizaciondetalle_tipven` ,
    // `tb_catalogo_id` ,
    // `tb_servicio_id` ,
    // `tb_cotizaciondetalle_nom` ,
    // `tb_cotizaciondetalle_preuni` ,
    // `tb_cotizaciondetalle_can` ,
    // `tb_cotizaciondetalle_tipdes` ,
    // `tb_cotizaciondetalle_des` ,
    // `tb_cotizaciondetalle_preunilin` ,
    // `tb_cotizaciondetalle_valven` ,
    // `tb_cotizaciondetalle_igv` ,
    // `cs_tipoafectacionigv_id`,
    // `cs_tipounidadmedida_id`,
    // `cs_tiposistemacalculoisc_id`,
    // `tb_cotizaciondetalle_isc`,
    // `tb_cotizaciondetalle_nro`
    // )
    // VALUES (
    // '$tipven',  '$cat_id',  '$ser_id', '$nom', '$preuni',  '$can',  '$tipdes',  '$des',  '$preunilin',  '$valven',  '$igv',  '$ven_id', '$afeigv', '$unimed', '$calisc', '$isc', '$nro'
    // );";
    // $oCado = new Cado();
    // $rst=$oCado->ejecute_sql($sql);
    // return $rst;
    // }
    function insertar_detalle($tipven,$cat_id,$ser_id,$nom,$preuni,$can,$tipdes,$des,$preunilin,$valven,$igv,$ven_id,$afeigv,$unimed,$calisc,$isc,$nro){
        $sql = "INSERT INTO tb_cotizaciondetalle(
	`tb_cotizaciondetalle_tipven`, 
	`tb_catalogo_id`, 
	`tb_servicio_id`, 
	`tb_cotizaciondetalle_nom`, 
	`tb_cotizaciondetalle_preuni`, 
	`tb_cotizaciondetalle_can`, 
	`tb_cotizaciondetalle_tipdes`, 
	`tb_cotizaciondetalle_des`, 
	`tb_cotizaciondetalle_preunilin`, 
	`tb_cotizaciondetalle_valven`, 
	`tb_cotizaciondetalle_igv`, 
	`tb_cotizacion_id`, 
	`cs_tipoafectacionigv_id`, 
	`cs_tipounidadmedida_id`, 
	`cs_tiposistemacalculoisc_id`, 
	`tb_cotizaciondetalle_isc`, 
	`tb_cotizaciondetalle_nro`
	) VALUES ('$tipven', '$cat_id', '$ser_id', '$nom', '$preuni', '$can', '$tipdes', '$des', '$preunilin', '$valven', '$igv', '$ven_id', '$afeigv', '$unimed', '$calisc', '$isc', '$nro');";
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
	FROM tb_cotizacion v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	WHERE tb_usuario_id = $usu_id 
	AND tb_puntocotizacion_id = $punven_id
	AND tb_cotizacion_fec BETWEEN '$fec1' AND '$fec2' ";

        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($venmay>0)$sql.=" AND v.tb_cotizacion_may = $venmay ";
        if($est!="")$sql.=" AND tb_cotizacion_est LIKE '$est' ";

        $sql.=" ORDER BY tb_cotizacion_fec, tb_documento_nom, tb_cotizacion_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_filtro_detalle($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$venmay){
        $sql="SELECT * 
	FROM tb_cotizacion v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntocotizacion_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_cotizaciondetalle vd ON v.tb_cotizacion_id = vd.tb_cotizacion_id
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_usuario_id = $usu_id 
	AND v.tb_puntocotizacion_id = $punven_id
	AND tb_cotizacion_fec BETWEEN '$fec1' AND '$fec2' ";

        if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
        if($art=='s' and $cat_ids!="")$sql.=" AND s.tb_categoria_id IN ($cat_ids) ";
        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($venmay>0)$sql.=" AND v.tb_cotizacion_may = $venmay ";
        if($est!="")$sql.=" AND tb_cotizacion_est LIKE '$est' ";

        $sql.=" ORDER BY tb_cotizacion_fec, tb_documento_nom, tb_cotizacion_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_filtro_adm($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
        $sql="SELECT * 
	FROM tb_cotizacion v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntocotizacion_id=pv.tb_puntoventa_id	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_cotizacion_fec BETWEEN '$fec1' AND '$fec2' ";

        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
        if($punven_id>0)$sql.=" AND v.tb_puntocotizacion_id = $punven_id ";
        if($venmay>0)$sql.=" AND v.tb_cotizacion_may = $venmay ";
        if($est!="")$sql.=" AND tb_cotizacion_est LIKE '$est' ";

        $sql.=" ORDER BY tb_cotizacion_fec, tb_documento_nom, tb_cotizacion_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_filtro_detalle_adm($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$emp_id,$venmay){
        $sql="SELECT * 
	FROM tb_cotizacion v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntocotizacion_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_cotizaciondetalle vd ON v.tb_cotizacion_id = vd.tb_cotizacion_id
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_cotizacion_fec BETWEEN '$fec1' AND '$fec2' ";

        if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
        if($art=='s' and $cat_ids!="")$sql.=" AND s.tb_categoria_id IN ($cat_ids) ";
        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
        if($punven_id>0)$sql.=" AND v.tb_puntocotizacion_id = $punven_id ";
        if($venmay>0)$sql.=" AND v.tb_cotizacion_may = $venmay ";
        if($est!="")$sql.=" AND tb_cotizacion_est LIKE '$est' ";

        $sql.=" ORDER BY tb_cotizacion_fec, tb_documento_nom, tb_cotizacion_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_resumen_productos_adm($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$emp_id){
        $sql="SELECT tb_cotizacion_est, tb_cotizaciondetalle_tipven, p.tb_producto_id, p.tb_producto_nom, pr.tb_presentacion_id, pr.tb_presentacion_nom, un.tb_unidad_id, un.tb_unidad_abr, ct.tb_catalogo_mul, SUM(tb_cotizaciondetalle_can) AS can, SUM(tb_cotizaciondetalle_preuni) AS preuni, SUM(tb_cotizaciondetalle_valven) AS valven, SUM(tb_cotizaciondetalle_igv) AS igv
	FROM tb_cotizacion v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntocotizacion_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_cotizaciondetalle vd ON v.tb_cotizacion_id = vd.tb_cotizacion_id
	
	INNER JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_cotizacion_fec BETWEEN '$fec1' AND '$fec2' ";

        if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
        if($punven_id>0)$sql.=" AND v.tb_puntocotizacion_id = $punven_id ";
        if($est!="")$sql.=" AND tb_cotizacion_est LIKE '$est' ";

        $sql.=" GROUP BY p.tb_producto_id, pr.tb_presentacion_id, un.tb_unidad_id ";

        //$sql.=" ORDER BY tb_cotizacion_fec, tb_documento_nom, tb_cotizacion_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_resumen_servicios_adm($fec1,$fec2,$doc_id,$art,$cat_ids,$cli_id,$est,$usu_id,$punven_id,$emp_id){
        $sql="SELECT tb_cotizacion_est, tb_cotizaciondetalle_tipven, s.tb_servicio_nom, SUM(tb_cotizaciondetalle_can) AS can, SUM(tb_cotizaciondetalle_preuni) AS preuni, SUM(tb_cotizaciondetalle_valven) AS valven, SUM(tb_cotizaciondetalle_igv) AS igv
	FROM tb_cotizacion v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntocotizacion_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_cotizaciondetalle vd ON v.tb_cotizacion_id = vd.tb_cotizacion_id
	
	INNER JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_empresa_id = $emp_id 
	AND tb_cotizacion_fec BETWEEN '$fec1' AND '$fec2' ";

        if($art=='p' and $cat_ids!="")$sql.=" AND p.tb_categoria_id IN ($cat_ids) ";
        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
        if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
        if($punven_id>0)$sql.=" AND v.tb_puntocotizacion_id = $punven_id ";
        if($est!="")$sql.=" AND tb_cotizacion_est LIKE '$est' ";

        $sql.=" GROUP BY s.tb_servicio_id ";

        //$sql.=" ORDER BY tb_cotizacion_fec, tb_documento_nom, tb_cotizacion_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrarUno($id){
        $sql="SELECT * 
	FROM tb_cotizacion v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntocotizacion_id=pv.tb_puntoventa_id
	INNER JOIN tb_almacen a ON pv.tb_almacen_id=a.tb_almacen_id
	WHERE tb_cotizacion_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function convertir_hash($id){
        $key = 'RqvMXL87JGXZIfG9GCrR';
        $sql="SELECT * FROM tb_cotizacion
	WHERE MD5(concat('$key',tb_cotizacion_id)) = '$id'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_venta_detalle_ps($ven_id){
        $sql="SELECT * 
	FROM tb_cotizacion v
	INNER JOIN tb_cotizaciondetalle vd ON v.tb_cotizacion_id = vd.tb_cotizacion_id
	LEFT JOIN cs_tipoafectacionigv ai ON vd.cs_tipoafectacionigv_id=ai.cs_tipoafectacionigv_id
	LEFT JOIN cs_tipounidadmedida um ON vd.cs_tipounidadmedida_id=um.cs_tipounidadmedida_id 
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_cotizacion_id = $ven_id 
	ORDER BY tb_cotizaciondetalle_nro";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_venta_detalle_ps_copia($ven_id){
        $sql="SELECT * 
	FROM tb_cotizacion v
	INNER JOIN tb_cotizaciondetalle vd ON v.tb_cotizacion_id = vd.tb_cotizacion_id
	LEFT JOIN tb_catalogo ct ON vd.tb_catalogo_id = ct.tb_catalogo_id
	LEFT JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	LEFT JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	LEFT JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	LEFT JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	LEFT JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id 
	
	LEFT JOIN tb_servicio s ON vd.tb_servicio_id = s.tb_servicio_id
	
	WHERE v.tb_cotizacion_id = $ven_id ";
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
	INNER JOIN tb_cotizaciondetalle vd ON ct.tb_catalogo_id = vd.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE vd.tb_cotizacion_id=$ven_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_venta_detalle_servicio($ven_id){
        $sql="SELECT * 
	FROM tb_servicio s
	INNER JOIN tb_categoria c ON s.tb_categoria_id = c.tb_categoria_id		
	INNER JOIN tb_cotizaciondetalle vd ON vd.tb_servicio_id = s.tb_servicio_id
	WHERE vd.tb_cotizacion_id=$ven_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function modificar($id,$fec,$cli_id,$est,$lab1){
        $sql = "UPDATE tb_cotizacion SET  
	`tb_cotizacion_fec` =  '$fec',
	`tb_cliente_id` =  '$cli_id',
	`tb_cotizacion_est` =  '$est',
	`tb_cotizacion_lab1` =  '$lab1' 
	WHERE  tb_cotizacion_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function modificar_est($id, $est){
        $sql = "UPDATE tb_cotizacion SET
	`tb_cotizacion_est` =  '$est'
	WHERE  tb_cotizacion_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function modificar_adm($id,$may,$lab1){
        $sql = "UPDATE tb_cotizacion SET  
	`tb_cotizacion_may` =  '$may',
	`tb_cotizacion_lab1` =  '$lab1' 
	WHERE  tb_cotizacion_id =$id;";
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
        $sql="DELETE FROM tb_cotizacion WHERE tb_cotizacion_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function aniosVenta(){
        $sql="SELECT DISTINCT (
	YEAR( tb_cotizacion_fec )) AS anio
	FROM  `tb_cotizacion` 
	ORDER BY tb_cotizacion_fec";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_todos_por_empresa($emp_id, $alm_id){
        $sql="SELECT * 
	FROM tb_cotizacion v
	INNER JOIN tb_puntoventa pv ON pv.tb_punto_id = v.tb_puntocotizacion_id
	WHERE v.tb_empresa_id = $emp_id 
	AND pv.tb_almacen_id = $alm_id
	AND v.tb_cotizacion_est IN ('CANCELADA')
	ORDER BY v.tb_cotizacion_fec";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function modificar_campo($id,$campo,$valor){
        $sql = "UPDATE tb_cotizacion SET
	`tb_cotizacion_$campo` =  '$valor' 
	WHERE tb_cotizacion_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function actualizar_sunat($id,$faucod,$digval,$sigval,$val,$est){
        $sql = "UPDATE tb_cotizacion SET  
	`tb_cotizacion_faucod` =  '$faucod',
	`tb_cotizacion_digval` =  '$digval',
	`tb_cotizacion_sigval` =  '$sigval',
	`tb_cotizacion_val` =  '$val',
	`tb_cotizacion_fecenvsun` =  NOW(),
	`tb_cotizacion_estsun` =  '$est'
	WHERE  tb_cotizacion_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>