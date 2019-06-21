<?php
require_once ("../formatos/formato.php");

class cKardex{
	function insertar($xac,$tipreg,$cod,$fec,$tip,$doc_id,$numdoc,$tipope_id,$des,$ope_id,$alm_id,$usu_id,$emp_id){
	$sql = "INSERT INTO tb_kardex(
	`tb_kardex_xac` ,
	`tb_kardex_reg` ,
	`tb_kardex_tipreg` ,
	`tb_kardex_cod` ,
	`tb_kardex_fec` ,
	`tb_kardex_tip` ,
	`tb_documento_id` ,
	`tb_kardex_numdoc` ,
	`tb_tipoperacion_id` ,
	`tb_kardex_des` ,
	`tb_operacion_id` ,
	`tb_almacen_id` ,
	`tb_usuario_id` ,
	`tb_empresa_id`
	)
	VALUES (
	'$xac', NOW( ) ,  '$tipreg',  '$cod',  '$fec',  '$tip',  '$doc_id',  '$numdoc',  '$tipope_id',  '$des', '$ope_id',  '$alm_id',  '$usu_id',  '$emp_id'
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
	function insertar_detalle($cat_id,$can,$cos,$pre,$notalm_id){
	$sql = "INSERT INTO tb_kardexdetalle(
	`tb_catalogo_id` ,
	`tb_kardexdetalle_can` ,
	`tb_kardexdetalle_cos` ,
	`tb_kardexdetalle_pre` ,
	`tb_kardex_id`
	)
	VALUES (
	'$cat_id',  '$can',  '$cos',  '$pre',  '$notalm_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_campo($id,$campo,$valor){
	$sql = "UPDATE tb_kardex SET
	`tb_kardex_$campo` =  '$valor' 
	WHERE tb_kardex_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_filtro($fec1,$fec2,$alm_id,$tip,$tipope,$man,$emp_id){
	$sql="SELECT *
	FROM tb_kardex na
	INNER JOIN tb_almacen a ON na.tb_almacen_id=a.tb_almacen_id
	INNER JOIN tb_tipoperacion tp ON na.tb_tipoperacion_id = tp.tb_tipoperacion_id
	INNER JOIN tb_documento d ON na.tb_documento_id=d.tb_documento_id 
	WHERE na.tb_empresa_id = $emp_id AND tb_kardex_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($alm_id>0)$sql.=" AND na.tb_almacen_id = $alm_id ";
	if($tip!="")$sql.=" AND tb_kardex_tip = '$tip' ";
	if($tipope>0)$sql.=" AND na.tb_tipoperacion_id = $tipope ";
	if($man>0)$sql.=" AND tb_tipoperacion_man = $man ";
	
	$sql.=" ORDER BY tb_kardex_fec, tb_almacen_nom, tb_kardex_tip, tb_tipoperacion_nom, tb_kardex_cod ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_kardex t
	INNER JOIN tb_almacen a ON t.tb_almacen_id=a.tb_almacen_id
	WHERE tb_kardex_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_codigo(){
	$sql="SELECT MAX(tb_kardex_id) as numero 
	FROM tb_kardex;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_kardex_detalle($notalm_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_kardexdetalle td ON ct.tb_catalogo_id = td.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE td.tb_kardex_id=$notalm_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $fec, $des){
	$sql = "UPDATE tb_kardex SET  
	`tb_kardex_fec` =  '$fec',
	`tb_kardex_des` =  '$des' 
	WHERE  tb_kardex_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_codigo($id, $cod){
	$sql = "UPDATE tb_kardex SET  
	`tb_kardex_cod` =  '$cod' 
	WHERE  tb_kardex_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function consultar_existencia_saldo_inicial($cat_id,$alm_id){
		$sql="SELECT * 
		FROM tb_producto p        
		INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
		INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id        
		INNER JOIN tb_kardexdetalle td ON ct.tb_catalogo_id = td.tb_catalogo_id
		INNER JOIN tb_kardex na ON na.tb_kardex_id = td.tb_kardex_id        
		WHERE td.tb_catalogo_id=$cat_id 
		AND na.tb_tipoperacion_id = 9 
		AND na.tb_almacen_id = $alm_id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function actualizar_salini($kardet_id, $can){
		$sql = "UPDATE tb_kardexdetalle SET  
		`tb_kardexdetalle_can` =  '$can' 
		WHERE tb_kardexdetalle_id =$kardet_id;"; 
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
	function consulta_eliminar($tiporeg,$tipo,$documento_id,$tipoperacion_id,$operacion_id){
	$sql="SELECT * FROM tb_kardex 
	WHERE tb_kardex_tipreg = $tiporeg
	AND tb_kardex_tip = $tipo
	AND tb_documento_id = $documento_id
	AND tb_tipoperacion_id = $tipoperacion_id
	AND tb_operacion_id = $operacion_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_kardex($notalm_id){
	$sql="DELETE FROM tb_kardex WHERE tb_kardex_id=$notalm_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_kardexdetalle($notalm_id){
	$sql="DELETE FROM tb_kardexdetalle WHERE tb_kardex_id=$notalm_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function consulta_por_operacion_si($tipoperacion_id,$operacion_id){
		$sql="SELECT * 
		FROM tb_kardex k
		INNER JOIN tb_kardexdetalle kd ON k.tb_kardex_id=kd.tb_kardex_id
		WHERE tb_tipoperacion_id = $tipoperacion_id
		AND tb_operacion_id = $operacion_id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	
   ///////////////////////////////////////
   function mostrar_kardex_detalle2($notalm_id,$alm_id){
	$sql="SELECT * 
	FROM tb_kardex n 
	INNER JOIN tb_kardexdetalle td ON n.tb_kardex_id = td.tb_kardex_id
	INNER JOIN tb_catalogo ct ON td.tb_catalogo_id = ct.tb_catalogo_id
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE ";
//	$sql.= "n.tb_kardex_id=$notalm_id 
//	AND";
	$sql.=" tb_kardex_tip=1
	AND tb_tipoperacion_id=1
	AND tb_almacen_id=$alm_id
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_catalogo($id){
	$sql="SELECT * 
	FROM tb_catalogo2
	WHERE tb_catalogo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_detalle_na($id, $cos, $pre){
	$sql = "UPDATE tb_kardexdetalle SET  
	`tb_kardexdetalle_cos` =  '$cos',
	`tb_kardexdetalle_pre` =  '$pre' 
	WHERE  tb_kardexdetalle_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_kardex_por_producto($cat_id, $alm_id,$fecini,$fecfin){
	$sql="SELECT *
	FROM tb_kardex k
	INNER JOIN tb_kardexdetalle kd ON k.tb_kardex_id = kd.tb_kardex_id
	LEFT JOIN tb_documento d ON k.tb_documento_id = d.tb_documento_id
	WHERE tb_kardex_xac = 1
	AND kd.tb_catalogo_id = $cat_id 
	AND k.tb_almacen_id = $alm_id ";
	
	if($fecini!="")$sql.=" AND tb_kardex_fec>='$fecini' ";
	if($fecfin!="")$sql.=" AND tb_kardex_fec<='$fecfin' ";
	
	$sql.=" ORDER BY tb_kardex_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}
    function mostrar_kardex_por_producto_total($cat_id, $emp_id,$fecini,$fecfin){
        $sql="SELECT *
	FROM tb_kardex k
	INNER JOIN tb_kardexdetalle kd ON k.tb_kardex_id = kd.tb_kardex_id
	LEFT JOIN tb_documento d ON k.tb_documento_id = d.tb_documento_id
	WHERE tb_kardex_xac = 1
	AND kd.tb_catalogo_id = $cat_id 
	AND k.tb_empresa_id = $emp_id ";

        if($fecini!="")$sql.=" AND tb_kardex_fec>='$fecini' ";
        if($fecfin!="")$sql.=" AND tb_kardex_fec<='$fecfin' ";

        $sql.=" ORDER BY tb_kardex_fec";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_kardex_total_almacen($cat_id, $emp_id,$alm_id,$fecini,$fecfin){
        $sql="SELECT *
	FROM tb_kardex k
	INNER JOIN tb_kardexdetalle kd ON k.tb_kardex_id = kd.tb_kardex_id
	LEFT JOIN tb_documento d ON k.tb_documento_id = d.tb_documento_id
	WHERE tb_kardex_xac = 1
	AND kd.tb_catalogo_id = $cat_id 
	AND k.tb_empresa_id = $emp_id";

        if($alm_id>0)$sql.=" AND k.tb_almacen_id = $alm_id ";
        if($fecini!="")$sql.=" AND tb_kardex_fec>='$fecini' ";
        if($fecfin!="")$sql.=" AND tb_kardex_fec<='$fecfin' ";

        $sql.=" ORDER BY tb_kardex_fec";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrar_kardex_tipoperacion_por_producto($cat_id, $alm_id, $tipope_id){
	$sql="SELECT *
	FROM tb_kardex n
	INNER JOIN tb_kardexdetalle nd ON n.tb_kardex_id = nd.tb_kardex_id
	INNER JOIN tb_almacen a ON n.tb_almacen_id = a.tb_almacen_id
	INNER JOIN tb_documento d ON n.tb_documento_id = d.tb_documento_id
	INNER JOIN tb_tipoperacion tp ON n.tb_tipoperacion_id = tp.tb_tipoperacion_id
	
	WHERE nd.tb_catalogo_id = $cat_id 
	AND n.tb_almacen_id = $alm_id
	AND n.tb_tipoperacion_id = $tipope_id
	ORDER BY n.tb_kardex_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		
	}


    function mostrar_kardex_tipoperacion_por_producto_fechas($cat_id, $alm_id, $tipope_id, $fecini, $fecfin)
    {
        $sql = "SELECT *
        FROM tb_kardex n
        INNER JOIN tb_kardexdetalle nd ON n.tb_kardex_id = nd.tb_kardex_id
        WHERE nd.tb_catalogo_id = $cat_id 
        AND n.tb_tipoperacion_id = $tipope_id";

        if ($alm_id > 0) $sql .= " AND n.tb_almacen_id = $alm_id ";
        if ($fecini != "") $sql .= " AND tb_kardex_fec>='$fecini' ";
        if ($fecfin != "") $sql .= " AND tb_kardex_fec<='$fecfin' ";
        $sql .= "ORDER BY n.tb_kardex_fec";
        $oCado = new Cado();
        $rst = $oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_kardex_tipoperacion_por_producto_fechas_reg($cat_id, $alm_id, $tipope_id, $fecini, $fecfin)
    {
        $sql = "SELECT *
        FROM tb_kardex n
        INNER JOIN tb_kardexdetalle nd ON n.tb_kardex_id = nd.tb_kardex_id
        WHERE nd.tb_catalogo_id = $cat_id 
        AND n.tb_tipoperacion_id = $tipope_id";

        if ($alm_id > 0) $sql .= " AND n.tb_almacen_id = $alm_id ";
        if ($fecini != "") $sql .= " AND tb_kardex_reg>='$fecini' ";
        if ($fecfin != "") $sql .= " AND tb_kardex_reg<='$fecfin' ";
        $sql .= "ORDER BY n.tb_kardex_reg";
        $oCado = new Cado();
        $rst = $oCado->ejecute_sql($sql);
        return $rst;
    }
	
	function inventario_tipo_por_producto($cat_id,$alm_id,$tip,$fecini,$fecfin,$emp_id){
		$sql="SELECT SUM( tb_kardexdetalle_can ) AS cantidad
		FROM tb_kardex n
		INNER JOIN tb_kardexdetalle nd ON n.tb_kardex_id = nd.tb_kardex_id

		WHERE tb_kardex_xac=1
		AND n.tb_empresa_id = $emp_id
		AND nd.tb_catalogo_id = $cat_id 
		AND n.tb_kardex_tip = $tip ";
		
		if($alm_id>0)$sql.=" AND n.tb_almacen_id = $alm_id ";
		if($fecini!="")$sql.=" AND n.tb_kardex_fec>='$fecini' ";
		if($fecfin!="")$sql.=" AND n.tb_kardex_fec<='$fecfin' ";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;		
		}

    function inventario_tipo_por_producto_fecha_reg($cat_id,$alm_id,$tip,$fecini,$fecfin,$emp_id){
        $sql="SELECT SUM( tb_kardexdetalle_can ) AS cantidad
		FROM tb_kardex n
		INNER JOIN tb_kardexdetalle nd ON n.tb_kardex_id = nd.tb_kardex_id

		WHERE tb_kardex_xac=1
		AND n.tb_empresa_id = $emp_id
		AND nd.tb_catalogo_id = $cat_id 
		AND n.tb_kardex_tip = $tip ";

        if($alm_id>0)$sql.=" AND n.tb_almacen_id = $alm_id ";
        if($fecini!="")$sql.=" AND n.tb_kardex_reg>='$fecini' ";
        if($fecfin!="")$sql.=" AND n.tb_kardex_reg<='$fecfin' ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrar_datos_producto($id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id = s.tb_presentacion_id
	INNER JOIN tb_almacen a ON a.tb_almacen_id = s.tb_almacen_id
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	LEFT JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	WHERE ct.tb_catalogo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function presentacion_buscar_unidad_base($pre_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE tb_catalogo_unibas =1
	AND pr.tb_presentacion_id = $pre_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>