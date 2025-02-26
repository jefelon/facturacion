<?php
class cCliente{
	function insertar($tip,$nom,$doc,$dir,$con,$tel,$ema,$est){
	$sql = "INSERT tb_cliente(
	`tb_cliente_tip` ,
	`tb_cliente_nom` ,
	`tb_cliente_doc` ,
	`tb_cliente_dir` ,
	`tb_cliente_con` ,
	`tb_cliente_tel` ,
	`tb_cliente_ema` ,
	`tb_cliente_est`
	)
	VALUES (
	'$tip',  '$nom',  '$doc',  '$dir', '$con',  '$tel', '$ema', '$est'
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
	$sql="SELECT * FROM tb_cliente ORDER BY tb_cliente_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro($cli_id){
		$sql="SELECT * 
		FROM tb_cliente	";	
		if($cli_id>0)$sql.=" WHERE tb_cliente_id = $cli_id";
				
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_cliente 
	WHERE tb_cliente_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$tip,$nom,$doc,$dir,$con,$tel,$ema,$est){
	$sql = "UPDATE tb_cliente SET  
	`tb_cliente_tip` =  '$tip',
	`tb_cliente_nom` =  '$nom',
	`tb_cliente_doc` =  '$doc',
	`tb_cliente_dir` =  '$dir',
	`tb_cliente_con` =  '$con',
	`tb_cliente_tel` =  '$tel',
	`tb_cliente_ema` =  '$ema',
	`tb_cliente_est` =  '$est'
	WHERE tb_cliente_id =$id"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_cliente_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_cliente_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_cliente_doc($doc,$cli_id){
	$sql="SELECT * 
	FROM tb_cliente 
	WHERE tb_cliente_doc LIKE '$doc' ";
	if($cli_id>0)$sql.= " AND tb_cliente_id <> $cli_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_cliente WHERE tb_cliente_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function complete_nom($dato){
	$sql="SELECT *
		FROM tb_cliente
		WHERE tb_cliente_nom LIKE '%$dato%' OR tb_cliente_doc LIKE '%$dato%'
		GROUP BY tb_cliente_nom
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function mostrar_ventas_por_cliente($fec1,$fec2,$cli_id){		
	$sql="SELECT * 
	FROM tb_venta v
	INNER JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	WHERE tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";		
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = ".$cli_id;
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>