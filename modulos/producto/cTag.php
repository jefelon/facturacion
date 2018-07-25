<?php
class cTag{
	function insertar($pre_id,$atr_id){
	$sql = "INSERT INTO tb_tag(
	`tb_presentacion_id` ,
	`tb_atributo_id`
	)
	VALUES (
	'$pre_id',  '$atr_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_atributo_valor_por_presentacion($pre_id){
	$sql="SELECT tb_tag_id, ap.tb_atributo_nom AS atributo, a.tb_atributo_nom AS valor, a.tb_atributo_id, a.tb_atributo_idp, ap.tb_categoria_id
	FROM tb_tag t 
	INNER JOIN tb_atributo a ON t.tb_atributo_id = a.tb_atributo_id
	INNER JOIN tb_atributo ap ON a.tb_atributo_idp=ap.tb_atributo_id
	INNER JOIN tb_categoria c ON ap.tb_categoria_id = c.tb_categoria_id
	WHERE t.tb_presentacion_id=$pre_id
	ORDER BY ap.tb_atributo_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($tag_id){
	$sql="DELETE FROM tb_tag WHERE tb_tag_id=$tag_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_por_presentacion($pre_id){
	$sql="DELETE FROM tb_tag WHERE tb_presentacion_id=$pre_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>