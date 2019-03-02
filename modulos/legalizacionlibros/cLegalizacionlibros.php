<?php
class cLegalizacionlibros{
	function insertar($fec,$id_cliente,$perspentrega_id,$persrecepcion_id,$persrecoge_id,$pendiente,$obs){
	$sql = "INSERT tb_legalizacionlibros (
		`tb_legalizacionlibros_fecha`,`tb_cliente_id`,`tb_persentrega_id`,`tb_persrecepcion_id`,`tb_persrecoge_id`,`tb_legalizacionlibros_pendientes`
		,`tb_legalizacionlibros_observacion`
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
	$sql="SELECT r.tb_legalizacionlibros_id, r.tb_legalizacionlibros_observacion, r.tb_legalizacionlibros_fecha, 
    r.tb_legalizacionlibros_pendientes, r.tb_cliente_id, r.tb_persentrega_id, r.tb_persrecepcion_id, r.tb_persrecoge_id, 
    cr.tb_cliente_nom AS tb_cliente_nom, cr.tb_cliente_dir AS tb_cliente_dir, cr.tb_cliente_tel AS tb_cliente_tel, pe.tb_cliente_nom AS tb_persentrega_nom, pr.tb_cliente_nom AS tb_persrecepcion_nom,
    pg.tb_cliente_nom AS tb_persrecoge_nom, cr.tb_cliente_doc AS tb_cliente_doc, pe.tb_cliente_doc AS tb_persentrega_doc,
    pr.tb_cliente_doc AS tb_persrecepcion_doc, pg.tb_cliente_doc AS tb_persrecoge_doc
	FROM tb_legalizacionlibros r
	INNER JOIN tb_cliente cr ON r.tb_cliente_id = cr.tb_cliente_id
	INNER JOIN tb_cliente pe ON r.tb_persentrega_id = pe.tb_cliente_id
	INNER JOIN tb_cliente pr ON r.tb_persrecepcion_id = pr.tb_cliente_id
	INNER JOIN tb_cliente pg ON r.tb_persrecoge_id = pg.tb_cliente_id
	ORDER BY tb_legalizacionlibros_fecha";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT r.tb_legalizacionlibros_id, r.tb_legalizacionlibros_observacion, r.tb_legalizacionlibros_fecha, 
    r.tb_legalizacionlibros_pendientes, r.tb_cliente_id, r.tb_persentrega_id, r.tb_persrecepcion_id, r.tb_persrecoge_id, 
    cr.tb_cliente_nom AS tb_cliente_nom, pe.tb_cliente_nom AS tb_persentrega_nom, pr.tb_cliente_nom AS tb_persrecepcion_nom,
    pg.tb_cliente_nom AS tb_persrecoge_nom, cr.tb_cliente_doc AS tb_cliente_doc, pe.tb_cliente_doc AS tb_persentrega_doc,
    pr.tb_cliente_doc AS tb_persrecepcion_doc, pg.tb_cliente_doc AS tb_persrecoge_doc
	FROM tb_legalizacionlibros r
	INNER JOIN tb_cliente cr ON r.tb_cliente_id = cr.tb_cliente_id
	INNER JOIN tb_cliente pe ON r.tb_persentrega_id = pe.tb_cliente_id
	INNER JOIN tb_cliente pr ON r.tb_persrecepcion_id = pr.tb_cliente_id
	INNER JOIN tb_cliente pg ON r.tb_persrecoge_id = pg.tb_cliente_id
	WHERE tb_legalizacionlibros_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$fec,$id_cliente,$perspentrega_id,$persrecepcion_id,$persrecoge_id,$pendiente,$obs){
	$sql = "UPDATE tb_legalizacionlibros SET  
	`tb_legalizacionlibros_fecha` =  '$fec',
	`tb_cliente_id` =  '$id_cliente',
	`tb_persentrega_id` =  '$perspentrega_id',
	`tb_persrecepcion_id` =  '$persrecepcion_id',
	`tb_persrecoge_id` =  '$persrecoge_id',
	`tb_legalizacionlibros_pendientes` =  '$pendiente',
	`tb_legalizacionlibros_observacion` =  '$obs'
	WHERE  tb_legalizacionlibros_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_legalizacionlibros_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_legalizacionlibros_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_legalizacionlibros WHERE tb_legalizacionlibros_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>