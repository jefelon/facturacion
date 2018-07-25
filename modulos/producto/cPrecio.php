<?php
class cPrecio{
	function insertar_preciodetalle($pre_id,$cat_id,$val){
	$sql = "INSERT INTO tb_preciodetalle(
	`tb_preciodetalle_mod` ,
	`tb_precio_id` ,
	`tb_catalogo_id` ,
	`tb_preciodetalle_val`
	)
	VALUES (
	NOW( ) ,  '$pre_id',  '$cat_id',  '$val'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function consultar_precio_por_catalogo($pre_id,$cat_id){
	$sql="SELECT * 
	FROM tb_preciodetalle pd
	INNER JOIN tb_precio p ON pd.tb_precio_id=p.tb_precio_id
	INNER JOIN tb_catalogo c ON pd.tb_catalogo_id=c.tb_catalogo_id
	WHERE pd.tb_precio_id=$pre_id
	AND c.tb_catalogo_id=$cat_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_preciodetalle($id,$val){
	$sql = "UPDATE tb_preciodetalle SET  
	`tb_preciodetalle_mod` = NOW( ) ,
	`tb_preciodetalle_val` =  '$val' 
	WHERE tb_preciodetalle_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
}
?>