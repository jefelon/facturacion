<?php
session_start();
class cVentacanje{
	function insertar($vennot_id,$ven_id,$usu_id,$punven_id,$emp_id){
	$sql = "INSERT INTO tb_ventacanje(
	`tb_ventacanje_reg` ,
	`tb_ventacanje_fec` ,
	`tb_ventanota_id` ,
	`tb_venta_id` ,
	`tb_usuario_id` ,
	`tb_puntoventa_id` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) , NOW( ) ,  '$vennot_id',  '$ven_id',  '$usu_id',  '$punven_id',  '$emp_id'
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
	function mostrar_filtro($fec1,$fec2,$doc_id,$cli_id,$est,$usu_id,$punven_id){
	$sql="SELECT * 
	FROM tb_ventanota v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	WHERE tb_usuario_id = $usu_id 
	AND tb_puntoventa_id = $punven_id AND v.tb_empresa_id = '{$_SESSION['empresa_id']}'
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($doc_id>0)$sql.=" AND v.tb_documento_id = $doc_id ";
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = $cli_id ";
	if($est!="")$sql.=" AND tb_venta_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_venta_fec, tb_documento_nom, tb_venta_numdoc ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrar_filtro_adm($fec1,$fec2,$usu_id,$punven_id,$emp_id){
	$sql="SELECT tb_ventacanje_reg, tb_ventacanje_fec, vj.tb_ventanota_id, vj.tb_venta_id, d.tb_documento_abr AS doc_abr1, vn.tb_venta_numdoc AS numdoc1, dd.tb_documento_abr AS doc_abr2, v.tb_venta_numdoc AS numdoc2, tb_usuario_nom, tb_usuario_apepat, tb_usuario_apemat, tb_puntoventa_nom
	FROM tb_ventacanje vj
	INNER JOIN tb_usuario u ON vj.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON vj.tb_puntoventa_id=pv.tb_puntoventa_id
	
	INNER JOIN tb_ventanota vn ON vj.tb_ventanota_id=vn.tb_venta_id
	INNER JOIN tb_documento d ON vn.tb_documento_id=d.tb_documento_id
	
	INNER JOIN tb_venta v ON vj.tb_venta_id=v.tb_venta_id
	INNER JOIN tb_documento dd ON v.tb_documento_id=dd.tb_documento_id
	
	WHERE vj.tb_empresa_id = $emp_id 
	AND tb_ventacanje_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($usu_id>0)$sql.=" AND u.tb_usuario_id = $usu_id ";
	if($punven_id>0)$sql.=" AND vj.tb_puntoventa_id = $punven_id ";
	
	$sql.=" ORDER BY tb_ventacanje_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_ventanota v
	LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	INNER JOIN tb_almacen a ON pv.tb_almacen_id=a.tb_almacen_id
	WHERE tb_venta_id=$id";
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
	$sql="DELETE FROM tb_ventanota WHERE tb_venta_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>