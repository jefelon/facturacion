<?php
class cNotalmacendetalle{
	function ultimoInsert(){
	$sql = "SELECT last_insert_id()"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function insertar_detalle($cat_id,$can,$cos,$pre,$notalm_id){
	$sql = "INSERT INTO tb_notalmacendetalle(
	`tb_catalogo_id` ,
	`tb_notalmacendetalle_can` ,
	`tb_notalmacendetalle_cos` ,
	`tb_notalmacendetalle_pre` ,
	`tb_notalmacen_id`
	)
	VALUES (
	'$cat_id',  '$can',  '$cos',  '$pre',  '$notalm_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_notalmacendetalle t
	INNER JOIN tb_notalmacen n ON t.tb_notalmacen_id=n.tb_notalmacen_id
	INNER JOIN tb_documento d ON n.tb_documento_id=d.tb_documento_id
	WHERE t.tb_notalmacendetalle_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $can, $cos, $pre){
	$sql = "UPDATE tb_notalmacendetalle SET  
	`tb_notalmacendetalle_can` =  '$can',
	`tb_notalmacendetalle_cos` =  '$cos',
	`tb_notalmacendetalle_pre` =  '$pre' 
	WHERE  tb_notalmacendetalle_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
}
?>