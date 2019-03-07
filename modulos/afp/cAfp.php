<?php
class cAfp{
	function insertar($id_cliente,$fec_decl,$fec_ven, $fec_envio,$estado_correo,$afp_nodeclarados, $afp_estadopago,
                      $afp_deudas, $persdecl_id,$obs){
	$sql = "INSERT 	tb_declaraciondocumentos (
		`tb_cliente_id`,`tb_fecha_declaracion`,`tb_fecha_vencimiento`,`tb_fecha_envio`,`tb_estado_correo`,`tb_afp_nodeclarados`,
		`tb_afp_estadopago`,`tb_afp_deudas`,`tb_persdecl_id`,`tb_observaciones`
		)
		VALUES (
		 '$id_cliente','$fec_decl','$fec_ven','$fec_envio','$estado_correo','$afp_nodeclarados','$afp_estadopago','$afp_deudas',
		 '$persdecl_id','$obs'
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
	$sql="SELECT dd.tb_declaraciondocumentos_id, dd.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_dir AS tb_cliente_dir, dd.tb_fecha_declaracion, dd.tb_fecha_vencimiento, dd.tb_fecha_envio, 
    dd.tb_afp_nodeclarados, dd.tb_afp_estadopago, dd.tb_afp_deudas, dd.tb_observaciones,
    dd.tb_persdecl_id, pe.tb_cliente_nom AS tb_persdecl_nom, pe.tb_cliente_doc AS tb_persdecl_doc
	FROM tb_declaraciondocumentos dd
	INNER JOIN tb_cliente cd ON dd.tb_cliente_id = cd.tb_cliente_id
	INNER JOIN tb_cliente pe ON dd.tb_persdecl_id = pe.tb_cliente_id
	WHERE dd.tb_fecha_declaracion BETWEEN '$fec1' AND '$fec2' 
	ORDER BY dd.tb_fecha_declaracion";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT dd.tb_declaraciondocumentos_id, dd.tb_cliente_id, cd.tb_cliente_nom AS tb_cliente_nom, 
    cd.tb_cliente_doc AS tb_cliente_doc, dd.tb_fecha_declaracion, dd.tb_fecha_vencimiento, dd.tb_fecha_envio, 
    dd.tb_estado_correo,
    dd.tb_afp_nodeclarados, dd.tb_afp_estadopago, dd.tb_afp_deudas, dd.tb_observaciones,
    dd.tb_persdecl_id, pe.tb_cliente_nom AS tb_persdecl_nom, pe.tb_cliente_doc AS tb_persdecl_doc
	FROM tb_declaraciondocumentos dd
	INNER JOIN tb_cliente cd ON dd.tb_cliente_id = cd.tb_cliente_id
	INNER JOIN tb_cliente pe ON dd.tb_persdecl_id = pe.tb_cliente_id
	WHERE tb_declaraciondocumentos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $id_cliente,$fec_decl,$fec_ven, $fec_envio,$estado_correo,$afp_nodeclarados, $afp_estadopago,
                       $afp_deudas, $persdecl_id,$obs){
	$sql = "UPDATE tb_declaraciondocumentos SET  
    `tb_cliente_id` =  '$id_cliente',
	`tb_fecha_declaracion` =  '$fec_decl',
	`tb_fecha_vencimiento` =  '$fec_ven',
	`tb_fecha_envio` =  '$fec_envio',
	`tb_estado_correo` =  '$estado_correo',
	`tb_afp_nodeclarados` =  '$afp_nodeclarados',
	`tb_afp_estadopago` =  '$afp_estadopago',
	`tb_afp_deudas` =  '$afp_deudas',
	`tb_persdecl_id` =  '$persdecl_id',
	`tb_observaciones` =  '$obs'
	WHERE  tb_declaraciondocumentos_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_afp_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_producto_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_declaraciondocumentos WHERE tb_declaraciondocumentos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>