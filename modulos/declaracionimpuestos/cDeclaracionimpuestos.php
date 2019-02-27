<?php
class cDeclaracionimpuestos{
	function insertar($fec,$id_cliente,$perspentrega_id,$persrecepcion_id,$persrecoge_id,$pendiente,$obs){
	$sql = "INSERT tb_declaracionimpuestos (
		`tb_declaracionimpuestos_fecha`,`tb_cliente_id`,`tb_persentrega_id`,`tb_persrecepcion_id`,`tb_persrecoge_id`,`tb_declaracionimpuestos_pendientes`
		,`tb_declaracionimpuestos_observacion`
		)
		VALUES (
		 '$fec','$id_cliente','$perspentrega_id','$persrecepcion_id','$persrecoge_id','$pendiente','$obs'
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
	$sql="SELECT di.tb_declaracionimpuestos_id, di.tb_cliente_id, di.tb_observaciones, di.tb_declaracionimpuestos_fecha, 
    di.tb_declaracionimpuestos_pendientes, di.tb_cliente_id, di.tb_persentrega_id, di.tb_persrecepcion_id, di.tb_persrecoge_id, 
    cr.tb_cliente_nom AS tb_cliente_nom, cr.tb_cliente_dir AS tb_cliente_dir, cr.tb_cliente_tel AS tb_cliente_tel, pe.tb_cliente_nom AS tb_persentrega_nom, pr.tb_cliente_nom AS tb_persrecepcion_nom,
    pg.tb_cliente_nom AS tb_persrecoge_nom, cr.tb_cliente_doc AS tb_cliente_doc, pe.tb_cliente_doc AS tb_persentrega_doc,
    pr.tb_cliente_doc AS tb_persrecepcion_doc, pg.tb_cliente_doc AS tb_persrecoge_doc
	FROM tb_declaracionimpuestos di
	INNER JOIN tb_cliente  ON di.tb_cliente_id = cr.tb_cliente_id
	INNER JOIN tb_cliente pe ON di.tb_persentrega_id = pe.tb_cliente_id
	INNER JOIN tb_cliente pr ON di.tb_persrecepcion_id = pr.tb_cliente_id
	INNER JOIN tb_cliente pg ON di.tb_persrecoge_id = pg.tb_cliente_id
	ORDER BY tb_declaracionimpuestos_fecha";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT di.tb_declaracionimpuestos_id, di.tb_declaracionimpuestos_observacion, di.tb_declaracionimpuestos_fecha, 
    di.tb_declaracionimpuestos_pendientes, di.tb_cliente_id, di.tb_persentrega_id, di.tb_persrecepcion_id, di.tb_persrecoge_id, 
    cr.tb_cliente_nom AS tb_cliente_nom, pe.tb_cliente_nom AS tb_persentrega_nom, pr.tb_cliente_nom AS tb_persrecepcion_nom,
    pg.tb_cliente_nom AS tb_persrecoge_nom, cr.tb_cliente_doc AS tb_cliente_doc, pe.tb_cliente_doc AS tb_persentrega_doc,
    pr.tb_cliente_doc AS tb_persrecepcion_doc, pg.tb_cliente_doc AS tb_persrecoge_doc
	FROM tb_declaracionimpuestos r
	INNER JOIN tb_cliente cr ON di.tb_cliente_id = cr.tb_cliente_id
	INNER JOIN tb_cliente pe ON di.tb_persentrega_id = pe.tb_cliente_id
	INNER JOIN tb_cliente pr ON di.tb_persrecepcion_id = pr.tb_cliente_id
	INNER JOIN tb_cliente pg ON di.tb_persrecoge_id = pg.tb_cliente_id
	WHERE tb_declaracionimpuestos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$fec,$id_cliente,$perspentrega_id,$persrecepcion_id,$persrecoge_id,$pendiente,$obs){
	$sql = "UPDATE tb_declaracionimpuestos SET  
	`tb_declaracionimpuestos_fecha` =  '$fec',
	`tb_cliente_id` =  '$id_cliente',
	`tb_persentrega_id` =  '$perspentrega_id',
	`tb_persrecepcion_id` =  '$persrecepcion_id',
	`tb_persrecoge_id` =  '$persrecoge_id',
	`tb_declaracionimpuestos_pendientes` =  '$pendiente',
	`tb_declaracionimpuestos_observacion` =  '$obs'
	WHERE  tb_declaracionimpuestos_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_recepciondocumentos_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_declaracionimpuestos_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_declaracionimpuestos WHERE tb_declaracionimpuestos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>