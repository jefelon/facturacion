<?php
session_start();
class cProveedor{
	function insertar($tip,$nom,$doc,$dir,$con,$tel,$ema){
	$sql = "INSERT tb_proveedor(
	`tb_proveedor_tip` ,
	`tb_proveedor_nom` ,
	`tb_proveedor_doc` ,
	`tb_proveedor_dir` ,
	`tb_proveedor_con` ,
	`tb_proveedor_tel` ,
	`tb_proveedor_ema` ,
	`tb_empresa_id`
	
	)
	VALUES (
	'$tip',  '$nom',  '$doc',  '$dir', '$con',  '$tel', '$ema', '{$_SESSION['empresa_id']}'
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
	$sql="SELECT * FROM tb_proveedor WHERE tb_empresa_id ='{$_SESSION['empresa_id']}' ORDER BY tb_proveedor_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_proveedor 
	WHERE tb_proveedor_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$tip,$nom,$doc,$dir,$con,$tel,$ema){
	$sql = "UPDATE tb_proveedor SET  
	`tb_proveedor_tip` =  '$tip',
	`tb_proveedor_nom` =  '$nom',
	`tb_proveedor_doc` =  '$doc',
	`tb_proveedor_dir` =  '$dir',
	`tb_proveedor_con` =  '$con',
	`tb_proveedor_tel` =  '$tel',
	`tb_proveedor_ema` =  '$ema'
	WHERE tb_proveedor_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_proveedor_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_proveedor_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_proveedor_doc($doc,$pro_id){
	$sql="SELECT * 
	FROM tb_proveedor
	WHERE tb_proveedor_doc LIKE '$doc' AND tb_empresa_id='{$_SESSION['empresa_id']}'";
	if($pro_id>0)$sql.= " AND tb_proveedor_id <> $pro_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_proveedor WHERE tb_proveedor_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function complete_nom($dato){
	$sql="SELECT *
		FROM tb_proveedor
		WHERE tb_proveedor_nom LIKE '%$dato%' OR tb_proveedor_doc LIKE '%$dato%' AND tb_empresa_id='{$_SESSION['empresa_id']}'
		GROUP BY tb_proveedor_nom
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrar_filtro($pro_id){
	$sql="SELECT * 
	FROM tb_proveedor	
	";	
	if($pro_id>0)$sql.=" WHERE tb_proveedor_id = $pro_id";		
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_compras_por_proveedor($fec1,$fec2,$pro_id){		
	$sql="SELECT * 
	FROM tb_compra c
	INNER JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON c.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_almacen a ON c.tb_almacen_id = a.tb_almacen_id
	WHERE tb_compra_fec BETWEEN '$fec1' AND '$fec2' ";		
	if($pro_id>0)$sql.=" AND c.tb_proveedor_id = ".$pro_id;
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>