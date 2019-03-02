<?php
class cGuia{
	//$num ->numero de guia
	//$com ->numero de comprobante
	//$est ->estado de la guia
	function insertar($fec, $rem, $des, $punpar, $punlle,$serie, $num, $obs, $pla, $mar, $est, $tipope, $ven_id, $tras_id, $num_doc, $con_id, $tra_id, $usu_id, $emp_id){
	$sql = "INSERT INTO tb_guia(
	`tb_guia_reg` ,
	`tb_guia_mod` ,
	`tb_guia_fec` ,
	`tb_guia_rem` ,
	`tb_guia_des` ,
	`tb_guia_punpar` ,
	`tb_guia_punlle` ,
	`tb_guia_serie` ,	
	`tb_guia_num` ,	
	`tb_guia_obs` ,
	`tb_guia_pla` ,
	`tb_guia_mar` ,
	`tb_guia_est` ,
	`tb_guia_tipope` ,
	`tb_venta_id` ,
	`tb_traspaso_id` ,
	`tb_guia_numdoc` ,
	`tb_conductor_id` ,	
	`tb_transporte_id`,
	`tb_usuario_id`,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) ,  NOW( ) , '$fec', '$rem', '$des', '$punpar', '$punlle', '$serie', '$num', '$obs', '$pla', '$mar', '$est', '$tipope', '$ven_id', '$tras_id', '$num_doc', '$con_id', '$tra_id', '$usu_id', '$emp_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function insertar_detalle($cat_id, $can, $gui_id){
	$sql = "INSERT INTO tb_guiadetalle(
	`tb_catalogo_id` ,	
	`tb_guiadetalle_can` ,	
	`tb_guia_id`
	)
	VALUES (
	'$cat_id', '$can', '$gui_id'
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
	function mostrar_filtro($fec1,$fec2,$con_id,$tra_id, $est){
	$sql="SELECT * 
	FROM tb_guia c
	INNER JOIN tb_conductor p ON c.tb_conductor_id=p.tb_conductor_id	
	INNER JOIN tb_transporte a ON c.tb_transporte_id=a.tb_transporte_id
	WHERE tb_guia_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($con_id>0)$sql.=" AND c.tb_conductor_id = $con_id ";
	if($tra_id>0)$sql.=" AND c.tb_transporte_id = $tra_id ";
	if($est!="")$sql.=" AND tb_guia_est LIKE '$est' ";
	
	$sql.=" ORDER BY tb_guia_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_guia c
	INNER JOIN tb_conductor p ON c.tb_conductor_id=p.tb_conductor_id
	INNER JOIN tb_transporte t ON t.tb_transporte_id=t.tb_transporte_id
	WHERE tb_guia_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrarGuiaUno($ven_id){
        $sql="SELECT * 
	FROM tb_guia c
	LEFT JOIN tb_conductor p ON c.tb_conductor_id=p.tb_conductor_id
	LEFT JOIN tb_transporte t ON t.tb_transporte_id=t.tb_transporte_id
	INNER JOIN tb_venta v ON v.tb_venta_id= c.tb_venta_id 
	LEFT JOIN tb_cliente cl ON v.tb_cliente_id=cl.tb_cliente_id
	WHERE v.tb_venta_id=$ven_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function mostrar_guia_detalle($gui_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_guiadetalle cd ON ct.tb_catalogo_id = cd.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE cd.tb_guia_id=$gui_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $fec, $rem, $des, $punpar, $punlle, $serie,$num, $obs, $pla, $mar, $est, $con_id, $tra_id){
	$sql = "UPDATE tb_guia SET  
	`tb_guia_mod` =  NOW(),
	`tb_guia_fec` =  '$fec',
	`tb_guia_rem` =  '$rem',
	`tb_guia_des` =  '$des',
	`tb_guia_punpar` =  '$punpar',
	`tb_guia_punlle` =  '$punlle',
	`tb_guia_serie` =  '$serie',
	`tb_guia_num` =  '$num',
	`tb_guia_obs` =  '$obs',
	`tb_guia_pla` =  '$pla',
	`tb_guia_mar` =  '$mar',
	`tb_guia_est` =  '$est',		
	`tb_conductor_id` =  '$con_id' ,
	`tb_transporte_id` =  '$tra_id'
	WHERE  tb_guia_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verificaE($id){
		$sql = "SELECT * 
FROM  `tb_usosoftware` 
WHERE tb_software_id =$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_guia WHERE tb_guia_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function aniosCompra(){
	$sql="SELECT DISTINCT (
	YEAR( tb_guia_fec )) AS anio
	FROM  `tb_guia` 
	ORDER BY tb_guia_fec";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function actual_numero_guia(){
        $sql="SELECT max(tb_guia_num) as max_guia FROM tb_guia";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>