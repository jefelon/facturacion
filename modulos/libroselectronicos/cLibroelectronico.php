<?php
class cLibroelectronico{
	function insertar($id_cliente,$fec_decl,$fec_ven, $libros_nodeclarados,$libros_vencidos,$persdecl_id,$obs){
	$sql = "INSERT tb_libroelectronico (
		`tb_cliente_id`,`tb_fecha_declaracion`,`tb_fecha_vencimiento`,`tb_libros_nodeclarados`,`tb_libros_vencidos`,
		`tb_persdecl_id`,`tb_observaciones`
		)
		VALUES (
		 '$id_cliente','$fec_decl','$fec_ven','$libros_nodeclarados','$libros_vencidos','$persdecl_id','$obs'
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
	$sql="SELECT le.tb_libroelectronico_id, le.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, le.tb_fecha_declaracion, le.tb_fecha_vencimiento, 
    le.tb_libros_nodeclarados, le.tb_libros_vencidos, le.tb_observaciones,
    le.tb_persdecl_id, pe.tb_cliente_nom AS tb_persdecl_nom, pe.tb_cliente_doc AS tb_persdecl_doc
	FROM tb_libroelectronico le
	INNER JOIN tb_cliente cd ON le.tb_cliente_id = cd.tb_cliente_id
	INNER JOIN tb_cliente pe ON le.tb_persdecl_id = pe.tb_cliente_id
	WHERE le.tb_fecha_declaracion BETWEEN '$fec1' AND '$fec2' 
	ORDER BY le.tb_fecha_declaracion";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT le.tb_libroelectronico_id, le.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, le.tb_fecha_declaracion, le.tb_fecha_vencimiento, 
    le.tb_libros_nodeclarados, le.tb_libros_vencidos, le.tb_observaciones,
    le.tb_persdecl_id, pe.tb_cliente_nom AS tb_persdecl_nom, pe.tb_cliente_doc AS tb_persdecl_doc
	FROM tb_libroelectronico le
	INNER JOIN tb_cliente cd ON le.tb_cliente_id = cd.tb_cliente_id
	INNER JOIN tb_cliente pe ON le.tb_persdecl_id = pe.tb_cliente_id
	WHERE tb_libroelectronico_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$id_cliente,$fec_decl,$fec_ven, $libros_nodeclarados,$libros_vencidos,$persdecl_id,$obs){
	$sql = "UPDATE tb_libroelectronico SET  
	`tb_cliente_id` =  '$id_cliente',
	`tb_fecha_declaracion` =  '$fec_decl',
	`tb_fecha_vencimiento` =  '$fec_ven',
	`tb_libros_nodeclarados` =  '$libros_nodeclarados',
	`tb_libros_vencidos` =  '$libros_vencidos',
	`tb_persdecl_id` =  '$persdecl_id',
	`tb_observaciones` =  '$obs'
	WHERE  tb_libroelectronico_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_libroelectronico_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_producto_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_libroelectronico WHERE tb_libroelectronico_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>