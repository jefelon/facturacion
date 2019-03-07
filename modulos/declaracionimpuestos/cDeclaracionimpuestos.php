<?php
class cDeclaracionimpuestos{
	function insertar($cliente_id,$fecha_declaracion,$fecha_vencimiento,$fecha_envio,$estado_correo,$pdt_nodeclarados,
                      $estadopago,$deudas,$persdecl_id,$obs){
	$sql = "INSERT tb_declaracionimpuestos (
		`tb_cliente_id`,`tb_fecha_declaracion`,`tb_fecha_vencimiento`,`tb_fecha_envio`,`tb_estado_correo`,
		`tb_pdt_nodeclarados`,`tb_estadopago`,`tb_deudas`, `tb_persdecl_id`, `tb_observaciones`
		)
		VALUES (
		 '$cliente_id','$fecha_declaracion','$fecha_vencimiento','$fecha_envio','$estado_correo','$pdt_nodeclarados',
		 '$estadopago','$deudas','$persdecl_id','$obs'
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
	$sql="SELECT di.tb_declaracionimpuestos_id, di.tb_cliente_id, ep.tb_cliente_nom AS tb_cliente_nom, 
    di.tb_fecha_declaracion, di.tb_fecha_vencimiento, di.tb_fecha_envio, di.tb_estado_correo, di.tb_pdt_nodeclarados, 
    di.tb_estadopago, di.tb_deudas, di.tb_persdecl_id, ep.tb_cliente_nom AS tb_persdecl_nom, di.tb_observaciones
    FROM tb_declaracionimpuestos di
	INNER JOIN tb_cliente ep ON di.tb_cliente_id = ep.tb_cliente_id
	INNER JOIN tb_cliente pr ON di.tb_persdecl_id = pr.tb_cliente_id
	WHERE di.tb_fecha_declaracion BETWEEN '$fec1' AND '$fec2' 
	ORDER BY di.tb_fecha_declaracion";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT di.tb_declaracionimpuestos_id, di.tb_cliente_id, ep.tb_cliente_nom AS tb_cliente_nom, 
    ep.tb_cliente_doc AS tb_cliente_doc, di.tb_fecha_declaracion, di.tb_fecha_vencimiento, 
    di.tb_fecha_envio, di.tb_estado_correo, di.tb_pdt_nodeclarados, di.tb_estadopago, di.tb_deudas, di.tb_persdecl_id,
    ep.tb_cliente_nom AS tb_persdecl_nom, ep.tb_cliente_doc AS tb_persdecl_doc, di.tb_observaciones
	FROM tb_declaracionimpuestos di
	INNER JOIN tb_cliente ep ON di.tb_cliente_id = ep.tb_cliente_id
	INNER JOIN tb_cliente pr ON di.tb_persdecl_id = pr.tb_cliente_id
	WHERE tb_declaracionimpuestos_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
    }
	function modificar($id,$cliente_id,$fecha_declaracion,$fecha_vencimiento,$fecha_envio,$estado_correo,$pdt_nodeclarados,
                       $estadopago,$deudas,$persdecl_id,$obs){
	$sql = "UPDATE tb_declaracionimpuestos SET
	`tb_cliente_id` =  '$cliente_id',
	`tb_fecha_declaracion` =  '$fecha_declaracion',
	`tb_fecha_vencimiento` =  '$fecha_vencimiento',
	`tb_fecha_envio` =  '$fecha_envio',
	`tb_estado_correo` =  '$estado_correo',
	`tb_pdt_nodeclarados` =  '$pdt_nodeclarados',
	`tb_estadopago` =  '$estadopago',
	`tb_deudas` =  '$deudas',
	`tb_persdecl_id` =  '$persdecl_id',
	`tb_observaciones` =  '$obs'
	WHERE  tb_declaracionimpuestos_id =$id;";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_declaracionimpuestos_tabla($id,$tabla){
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