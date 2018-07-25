<?php
class cEncarte{
	function insertar($fecini,$fecfin,$des,$despor,$est,$usu_id,$emp_id){
	$sql = "INSERT INTO tb_encarte(
	`tb_encarte_reg` ,
	`tb_encarte_mod` ,
	`tb_encarte_fecini` ,
	`tb_encarte_fecfin` ,
	`tb_encarte_des` ,
	`tb_encarte_despor` ,
	`tb_encarte_est` ,
	`tb_usuario_id` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$fecini',  '$fecfin',  '$des',  '$despor',  '$est',  '$usu_id',  '$emp_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function insertar_detalle($cat_id,$cos,$despor,$uti1,$preven1, $uti2, $preven2, $enc_id){
	$sql = "INSERT INTO  tb_encartedetalle(
	`tb_catalogo_id` ,
	`tb_encartedetalle_cos` ,
	`tb_encartedetalle_despor` ,
	`tb_encartedetalle_uti1` ,
	`tb_encartedetalle_preven1` ,
	`tb_encartedetalle_uti2` ,
	`tb_encartedetalle_preven2` ,
	`tb_encarte_id`
	)
	VALUES (
	'$cat_id', '$cos',  '$despor',  '$uti1',  '$preven1',  '$uti2',  '$preven2',  '$enc_id'
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
	function mostrar_todos($est){
	$sql="SELECT * 
	FROM tb_encarte 
	WHERE tb_encarte_est = '$est'     
	ORDER BY tb_encarte_fecini";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($fec1,$fec2,$est,$emp_id){
	$sql="SELECT * 
	FROM tb_encarte e
	WHERE e.tb_empresa_id = $emp_id 
	AND tb_encarte_fecini BETWEEN '$fec1' AND '$fec2' ";
	
	if($est!="")$sql.=" AND tb_encarte_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_encarte_fecini ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro_detalle($fec1,$fec2,$mon,$pro_id,$est,$emp_id){
	$sql="SELECT * 
	FROM tb_encarte c
	INNER JOIN tb_proveedor pv ON c.tb_proveedor_id=pv.tb_proveedor_id
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_almacen a ON c.tb_almacen_id=a.tb_almacen_id
	
	INNER JOIN tb_encartedetalle cd ON c.tb_encarte_id = cd.tb_encarte_id
	INNER JOIN tb_catalogo ct ON cd.tb_catalogo_id = ct.tb_catalogo_id
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_categoria cg ON p.tb_categoria_id = cg.tb_categoria_id
	INNER JOIN tb_unidad un ON ct.tb_unidad_id_bas = un.tb_unidad_id
	
	WHERE c.tb_empresa_id = $emp_id 
	AND tb_encarte_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($mon>0)$sql.=" AND tb_encarte_mon = $mon ";
	if($pro_id>0)$sql.=" AND c.tb_proveedor_id = $pro_id ";
	if($est!="")$sql.=" AND tb_encarte_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_encarte_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_encarte c
	WHERE tb_encarte_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_encarte_detalle($enc_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_encartedetalle cd ON ct.tb_catalogo_id = cd.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE cd.tb_encarte_id=$enc_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $des){
	$sql = "UPDATE  tb_encarte SET
	`tb_encarte_des` =  '$des' 
	WHERE tb_encarte_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_estado($id, $est){
	$sql = "UPDATE tb_encarte SET  
	`tb_encarte_est` =  '$est' 
	WHERE tb_encarte_id =$id;"; 
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
	$sql="DELETE FROM tb_encarte WHERE tb_encarte_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>