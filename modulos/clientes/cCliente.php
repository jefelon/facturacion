<?php
class cCliente{
	function insertar($tip,$nom,$doc,$dir,$con,$tel,$ema,$est,$empresa,$precio,$retiene,$cui){
	$sql = "INSERT tb_cliente(
	`tb_cliente_tip` ,
	`tb_cliente_nom` ,
	`tb_cliente_doc` ,
	`tb_cliente_dir` ,
	`tb_cliente_con` ,
	`tb_cliente_tel` ,
	`tb_cliente_ema` ,
	`tb_cliente_est`,
	`tb_empresa_id`,
	`tb_precio_id`,
	`tb_cliente_retiene`,
	`tb_cliente_cui`

	)
	VALUES (
	'$tip',  '$nom',  '$doc',  '$dir', '$con',  '$tel', '$ema', '$est', '$empresa', '$precio','$retiene','$cui');";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function insertar_direccion($dir,$id_cliente){
        $sql = "INSERT tb_clientedireccion(
        `tb_clientedireccion_dir` ,
        `tb_cliente_id` 
        )
        VALUES (
        '$dir',  '$id_cliente'
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
	function mostrarTodos($fil){
	$sql="SELECT * FROM tb_cliente c
	LEFT JOIN tb_precio p ON c.tb_precio_id=p.tb_precio_id
	ORDER BY c.tb_cliente_nom
	";
	if($fil!="")$sql.=" LIMIT 0,$fil ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function mostrarDireccionesTodos($cli_id){
        $sql="SELECT * FROM tb_clientedireccion d";
        if($cli_id>0)$sql.=" WHERE tb_cliente_id = $cli_id";
        "ORDER BY d.tb_clientedireccion_id
        ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function mostrar_filtro($cli_id){
		$sql="SELECT * 
		FROM tb_cliente	";	
		if($cli_id>0)$sql.=" WHERE tb_cliente_id = $cli_id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_cliente 
	WHERE tb_cliente_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function mostrarUnoDoc($doc){
        $sql="SELECT * 
	FROM tb_cliente 
	WHERE tb_cliente_doc=$doc";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function modificar($id,$tip,$nom,$doc,$dir,$con,$tel,$ema,$est,$empresa,$precio,$retiene,$cui){
	$sql = "UPDATE tb_cliente SET  
	`tb_cliente_tip` =  '$tip',
	`tb_cliente_nom` =  '$nom',
	`tb_cliente_doc` =  '$doc',
	`tb_cliente_dir` =  '$dir',
	`tb_cliente_con` =  '$con',
	`tb_cliente_tel` =  '$tel',
	`tb_cliente_ema` =  '$ema',
	`tb_cliente_est` =  '$est',
	`tb_empresa_id` =  '$empresa',
	`tb_precio_id` =  '$precio',
	`tb_cliente_retiene` =  '$retiene',
	`tb_cliente_cui` =  '$cui'
	
	WHERE tb_cliente_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_cliente_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_cliente_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function verifica_cliente_doc($doc,$cli_id){
	$sql="SELECT * 
	FROM tb_cliente 
	WHERE tb_cliente_doc LIKE '$doc' ";
	if($cli_id>0)$sql.= " AND tb_cliente_id <> $cli_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function verifica_cliente_nombre($doc,$cli_id){
        $sql="SELECT * 
	FROM tb_cliente 
	WHERE tb_cliente_doc LIKE '$doc' ";
        if($cli_id>0)$sql.= " AND tb_cliente_id <> $cli_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function actualizar_nombre($id,$nom){
        $sql = "UPDATE tb_cliente SET  
	`tb_cliente_nom` =  '$nom'
	WHERE tb_cliente_id =$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function eliminar($id){
	$sql="DELETE FROM tb_cliente WHERE tb_cliente_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function complete_nom($dato){
	$sql="SELECT *
		FROM tb_cliente
		WHERE tb_cliente_nom LIKE '%$dato%' OR tb_cliente_doc LIKE '%$dato%'
		GROUP BY tb_cliente_nom
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}

    function complete_cod($dato){
        $sql="SELECT *
		FROM tb_cliente
		WHERE tb_cliente_cui LIKE '%$dato%' OR tb_cliente_nom LIKE '%$dato%' OR tb_cliente_doc LIKE '%$dato%'
		GROUP BY tb_cliente_nom
		LIMIT 0,12
		";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function mostrar_ventas_por_cliente($fec1,$fec2,$cli_id){		
	$sql="SELECT * 
	FROM tb_venta v
	INNER JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
	INNER JOIN tb_documento d ON v.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_usuario u ON v.tb_usuario_id=u.tb_usuario_id
	INNER JOIN tb_puntoventa pv ON v.tb_puntoventa_id=pv.tb_puntoventa_id
	WHERE tb_venta_fec BETWEEN '$fec1' AND '$fec2' ";		
	if($cli_id>0)$sql.=" AND v.tb_cliente_id = ".$cli_id;
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>