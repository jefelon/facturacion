<?php
class cStock{
	function insertar($alm_id,$pre_id,$sto){
	$sql = "INSERT INTO tb_stock(
	`tb_stock_mod` ,
	`tb_almacen_id` ,
	`tb_presentacion_id` ,
	`tb_stock_num`
	)
	VALUES (
	NOW( ) ,  '$alm_id',  '$pre_id',  '$sto'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function stock_por_presentacion($pre_id,$alm_id){
	$sql="SELECT * 
	FROM tb_presentacion p
	LEFT JOIN tb_stock s ON p.tb_presentacion_id=s.tb_presentacion_id
	WHERE p.tb_presentacion_id=$pre_id
	AND s.tb_almacen_id=$alm_id" ;
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$num){
	$sql = "UPDATE tb_stock SET  
	`tb_stock_mod` = NOW( ) ,
	`tb_stock_num` =  '$num' 
	WHERE tb_stock_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificar_presentacion_res($tar_id){
	$sql="SELECT * 
	FROM tb_presentacion
	WHERE tb_presentacion_idr=$tar_id
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_stock WHERE tb_presentacion_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>