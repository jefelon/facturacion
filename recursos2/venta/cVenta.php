<?php
session_start();
class cVenta{
    function mostrar_filtro($fec1,$doc_id,$ser,$cor,$mon){
        $sql="SELECT ev.tb_encomiendaventa_id, vv.tb_viajeventa_id, v.tb_venta_id,v.tb_venta_est,v.tb_venta_tot,td.cs_tipodocumento_cod,v.tb_venta_ser,v.tb_venta_num,
    v.tb_venta_fec, c.tb_cliente_nom,c.tb_cliente_doc ,v.cs_tipomoneda_id, d.tb_documento_ele, v.tb_venta_estsun, 
    v.tb_venta_fecenvsun, td.cs_tipodocumento_cod, d.tb_documento_abr, v.tb_venta_numdoc, d.tb_documento_nom, 
    v.tb_venta_valven, v.tb_venta_igv,v.tb_documento_id,v.tb_venta_tipo,v.tb_venta_tipodes
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	LEFT JOIN tb_encomiendaventa ev ON v.tb_venta_id=ev.tb_venta_id
	LEFT JOIN tb_viajeventa vv ON vv.tb_venta_id=v.tb_venta_id	
	WHERE v.tb_venta_fec = '$fec1'
	AND v.tb_documento_id = '$doc_id'
	AND v.tb_venta_ser = '$ser'
	AND v.tb_venta_num  = '$cor' 
	AND v.tb_venta_tot = '$mon'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_filtro_cui($cui, $fec1, $fec2,$doc_id,$est,$cli_id){
        $sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	WHERE tb_venta_fec BETWEEN '$fec1' AND '$fec2' AND c.tb_cliente_cui = '$cui' AND c.tb_cliente_id = $cli_id
	";
        if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
        if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";

        $sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_venta v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	INNER JOIN tb_almacen a ON pv.tb_almacen_id=a.tb_almacen_id
	WHERE v.tb_venta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_venta_detalle_ps($ven_id){
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
}
?>