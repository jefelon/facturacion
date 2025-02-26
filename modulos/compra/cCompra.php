<?php
class cCompra{
	function insertar($fec,$fecven,$doc_id,$numdoc,$mon,$tipcam,$tipcam2,$pro_id,$subtot,$des,$descal,$fle,$tipfle,$ajupos,$ajuneg,$valven,$opexo,$opegrav,$igv,$tot,$tipper,$per,$alm_id,$est,$usu_id,$emp_id){
	$sql = "INSERT INTO tb_compra(
	`tb_compra_reg` ,
	`tb_compra_mod` ,
	`tb_compra_fec` ,
	`tb_compra_fecven` ,
	`tb_documento_id` ,
	`tb_compra_numdoc` ,
	`tb_compra_mon` ,
	`tb_compra_tipcam` ,
	`tb_compra_tipcam2` ,
	`tb_proveedor_id` ,
	`tb_compra_subtot` ,
	`tb_compra_des` ,
	`tb_compra_descal` ,
	`tb_compra_fle` ,
	`tb_compra_tipfle` ,
	`tb_compra_ajupos` ,
	`tb_compra_ajuneg` ,
	`tb_compra_valven` ,
	`tb_compra_exo` ,
	`tb_compra_gra` ,
	`tb_compra_igv` ,
	`tb_compra_tot` ,
	`tb_compra_tipper` ,
	`tb_compra_per` ,
	`tb_almacen_id` ,
	`tb_compra_est` ,
	`tb_usuario_id` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$fec', '$fecven',  '$doc_id',  '$numdoc', '$mon', '$tipcam', '$tipcam2', '$pro_id',  '$subtot',  '$des',  '$descal',  '$fle',  '$tipfle',  '$ajupos',  '$ajuneg',  '$valven', '$opexo', '$opegrav', '$igv',  '$tot', '$tipper', '$per',  '$alm_id',  '$est',  '$usu_id',  '$emp_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function insertar_detalle($cat_id,$can,$preuni,$des, $imp, $igv,$tipo_afec, $fle, $per, $cosuni, $com_id){
	$sql = "INSERT INTO tb_compradetalle(
	`tb_catalogo_id` ,
	`tb_compradetalle_can` ,
	`tb_compradetalle_preuni` ,
	`tb_compradetalle_des` ,
	`tb_compradetalle_imp` ,
	`cs_tipoafectacionigv_id` ,
	`tb_compradetalle_igv` ,
	`tb_compradetalle_fle` ,
	`tb_compradetalle_per` ,
	`tb_compradetalle_cosuni` ,
	`tb_compra_id`
	)
	VALUES (
	'$cat_id',  '$can',  '$preuni', '$des',  '$imp',  '$igv', '$tipo_afec', '$fle', '$per',  '$cosuni', '$com_id'
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
	function mostrar_filtro($fec1,$fec2,$mon,$pro_id,$est,$emp_id){
	$sql="SELECT * 
	FROM tb_compra c
	INNER JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_almacen a ON c.tb_almacen_id=a.tb_almacen_id
	WHERE c.tb_empresa_id = $emp_id AND tb_compra_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($mon>0)$sql.=" AND tb_compra_mon = $mon ";
	if($pro_id>0)$sql.=" AND c.tb_proveedor_id = $pro_id ";
	if($est!="")$sql.=" AND tb_compra_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_compra_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_filtro_por_mes_anio($mes_id,$anio_id,$emp_id){
        $sql="SELECT * 
	FROM tb_compra c
	INNER JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_almacen a ON c.tb_almacen_id=a.tb_almacen_id
	WHERE c.tb_empresa_id = $emp_id";

        if($mes_id!="")$sql.=" AND MONTH(tb_compra_fec) = '$mes_id' ";
        if($anio_id!="")$sql.=" AND YEAR(tb_compra_fec) = '$anio_id' ";
        $sql.=" ORDER BY tb_compra_fec ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function mostrar_filtro_detalle($fec1,$fec2,$mon,$pro_id,$est,$emp_id){
	$sql="SELECT * 
	FROM tb_compra c
	INNER JOIN tb_proveedor pv ON c.tb_proveedor_id=pv.tb_proveedor_id
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_almacen a ON c.tb_almacen_id=a.tb_almacen_id
	
	INNER JOIN tb_compradetalle cd ON c.tb_compra_id = cd.tb_compra_id
	INNER JOIN tb_catalogo ct ON cd.tb_catalogo_id = ct.tb_catalogo_id
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	INNER JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id
	
	WHERE c.tb_empresa_id = $emp_id 
	AND tb_compra_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($mon>0)$sql.=" AND tb_compra_mon = $mon ";
	if($pro_id>0)$sql.=" AND c.tb_proveedor_id = $pro_id ";
	if($est!="")$sql.=" AND tb_compra_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_compra_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_compra c
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
	WHERE tb_compra_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_compra_detalle($com_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_compradetalle cd ON ct.tb_catalogo_id = cd.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE cd.tb_compra_id=$com_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_duplicidad($doc,$numdoc,$pro_id,$est,$emp_id){
	$sql="SELECT * 
	FROM tb_compra c
	INNER JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	WHERE c.tb_empresa_id = $emp_id 
	AND c.tb_documento_id=$doc
	AND tb_compra_numdoc= '$numdoc' ";
	
	if($pro_id>0)$sql.=" AND c.tb_proveedor_id = $pro_id ";
	if($est!="")$sql.=" AND tb_compra_est IN ($est) ";
	
	$sql.=" ORDER BY tb_compra_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $fec, $fecven, $doc_id, $numdoc, $pro_id, $est){
	$sql = "UPDATE tb_compra SET  
	`tb_compra_fec` =  '$fec',
	`tb_compra_fecven` =  '$fecven',
	`tb_documento_id` =  '$doc_id',
	`tb_compra_numdoc` =  '$numdoc',
	`tb_proveedor_id` =  '$pro_id' ,
	`tb_compra_est` =  '$est' 
	WHERE tb_compra_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_estado($id, $est){
	$sql = "UPDATE tb_compra SET  
	`tb_compra_est` =  '$est' 
	WHERE tb_compra_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_cambio2($id, $tipcam){
	$sql = "UPDATE tb_compra SET  
	`tb_compra_tipcam2` =  '$tipcam' 
	WHERE tb_compra_id =$id;"; 
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
	$sql="DELETE FROM tb_compra WHERE tb_compra_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosCompra(){
	$sql="SELECT DISTINCT (
	YEAR( tb_compra_fec )) AS anio
	FROM  `tb_compra` 
	ORDER BY tb_compra_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_todos(){
	$sql="SELECT * 
	FROM tb_compra 
	WHERE tb_compra_est IN ('CANCELADA', 'EMITIDA')     
	ORDER BY tb_compra_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>