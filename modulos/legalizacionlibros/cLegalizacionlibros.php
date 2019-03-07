<?php
class cLegalizacionlibros{
	function insertar($id_cliente,$domicilio_fiscal,$fecha_recepcion,$notaria,$fecha_legalizacion,$fecha_recojo,$numdoc,
                      $regimen,$cant_libros,$id_responsable,$libros_legalizados,$lib_nolegalizados,$pendiente_cobro,$obs){
	$sql = "INSERT tb_legalizacionlibros (
		`tb_cliente_id`,`tb_domicilio_fiscal`,`tb_fecha_recepcion`,`tb_notaria`,`tb_fecha_legalizacion`,`tb_fecha_recojo`,
		`tb_numdoc`,`tb_regimen_tributario`,`tb_cantidad_libros`,`tb_responsable_id`,`tb_libros_legalizados`,
		`tb_libros_nolegalizados`,`tb_pendiente_cobro`,`tb_observaciones`
		)
		VALUES (
		 '$id_cliente','$domicilio_fiscal','$fecha_recepcion','$notaria','$fecha_legalizacion','$fecha_recojo',
		 '$numdoc','$regimen','$cant_libros','$id_responsable','$libros_legalizados','$lib_nolegalizados',
		 '$pendiente_cobro','$obs'
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
	function mostrar_filtro($fec1,$fec2){
	$sql="SELECT ll.tb_legalizacionlibros_id, ep.tb_cliente_nom, ll.tb_domicilio_fiscal,ll.tb_fecha_recepcion,
    ll.tb_notaria, ll.tb_fecha_legalizacion, ll.tb_fecha_recojo,ll.tb_numdoc,ll.tb_regimen_tributario,
    ll.tb_cantidad_libros, pr.tb_cliente_nom AS tb_responsable_nom, ll.tb_libros_legalizados, ll.tb_libros_nolegalizados,
    ll.tb_pendiente_cobro, ll.tb_observaciones
	FROM tb_legalizacionlibros ll
	INNER JOIN tb_cliente ep ON ep.tb_cliente_id = ll.tb_cliente_id
	INNER JOIN tb_cliente pr ON pr.tb_cliente_id = ll.tb_responsable_id
    WHERE tb_fecha_recepcion BETWEEN '$fec1' AND '$fec2' 
	ORDER BY tb_fecha_recepcion";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT ll.tb_legalizacionlibros_id, ll.tb_cliente_id, ep.tb_cliente_nom,ep.tb_cliente_doc, ll.tb_domicilio_fiscal,ll.tb_fecha_recepcion,
    ll.tb_notaria, ll.tb_fecha_legalizacion, ll.tb_fecha_recojo,ll.tb_numdoc,ll.tb_regimen_tributario,
    ll.tb_cantidad_libros,ll.tb_responsable_id, pr.tb_cliente_nom AS tb_responsable_nom,
    pr.tb_cliente_doc AS tb_responsable_doc, ll.tb_libros_legalizados, ll.tb_libros_nolegalizados,
    ll.tb_pendiente_cobro, ll.tb_observaciones
	FROM tb_legalizacionlibros ll
	INNER JOIN tb_cliente ep ON ep.tb_cliente_id = ll.tb_cliente_id
	INNER JOIN tb_cliente pr ON pr.tb_cliente_id = ll.tb_responsable_id
	WHERE tb_legalizacionlibros_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$id_cliente,$domicilio_fiscal,$fecha_recepcion,$notaria,$fecha_legalizacion,$fecha_recojo,$numdoc,
                       $regimen,$cant_libros,$id_responsable,$libros_legalizados,$lib_nolegalizados,$pendiente_cobro,$obs){
	$sql = "UPDATE tb_legalizacionlibros SET  
	`tb_cliente_id` =  '$id_cliente',
	`tb_domicilio_fiscal` =  '$domicilio_fiscal',
	`tb_fecha_recepcion` =  '$fecha_recepcion',
	`tb_notaria` =  '$notaria',
	`tb_fecha_legalizacion` =  '$fecha_legalizacion',
	`tb_fecha_recojo` =  '$fecha_recojo',
	`tb_numdoc` =  '$numdoc',
	`tb_regimen_tributario` =  '$regimen',
	`tb_cantidad_libros` =  '$cant_libros',
	`tb_responsable_id` =  '$id_responsable',
	`tb_libros_legalizados` =  '$libros_legalizados',
	`tb_libros_nolegalizados` =  '$lib_nolegalizados',
	`tb_pendiente_cobro` =  '$pendiente_cobro',
	`tb_observaciones` =  '$obs'
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