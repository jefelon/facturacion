<?php
class cServicio{
	function insertar($nom, $des, $pre, $est, $cat_id, $aut){
	$sql = "INSERT INTO tb_servicio(		
		`tb_servicio_nom` ,
		`tb_servicio_des` ,
		`tb_servicio_pre` ,
		`tb_servicio_est` ,
		`tb_categoria_id` ,
		`tb_servicio_aut`
		)
		VALUES (
		'$nom',  '$des', '$pre', '$est',  '$cat_id',  '$aut'
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
	function mostrar_filtro($nom,$cat,$est,$limit){
	$sql="SELECT * 
	FROM tb_servicio p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id	
	WHERE tb_servicio_est LIKE '%$est%' ";

	if($nom!="")$sql.=" AND tb_servicio_nom LIKE '%$nom%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";	

	$sql.=" ORDER BY tb_servicio_nom ";
	
	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_filtro_2($nom,$est){
	$sql="SELECT * 
	FROM tb_servicio p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id	
	WHERE tb_servicio_est LIKE '$est' AND tb_servicio_nom LIKE '$nom' ";
	$sql.=" ORDER BY tb_servicio_nom ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_filtro_3($nom){
        $sql="SELECT * 
        FROM tb_servicio p	
        WHERE UPPER(tb_servicio_nom) = '$nom' AND tb_servicio_est='Activo'";
        $sql.=" ORDER BY tb_servicio_nom ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	
	function mostrar_venta_detalle($ven_id){
	$sql="SELECT * 
	FROM tb_servicio p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_servicio_id=pr.tb_servicio_id
	INNER JOIN tb_ventadetalle vd ON pr.tb_presentacion_id=vd.tb_presentacion_id
	INNER JOIN tb_unidad u ON pr.tb_unidad_id=u.tb_unidad_id
	WHERE vd.tb_venta_id=$ven_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_servicio s
	INNER JOIN tb_categoria c ON s.tb_categoria_id=c.tb_categoria_id	
	WHERE tb_servicio_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $nom, $des, $pre, $est, $cat_id){
	$sql = "UPDATE tb_servicio SET  	
	`tb_servicio_nom` =  '$nom',
	`tb_servicio_des` =  '$des',
	`tb_servicio_pre` =  '$pre',
	`tb_servicio_est` =  '$est',
	`tb_categoria_id` =  '$cat_id'
	WHERE  tb_servicio_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function complete_nom($dato){
	$sql="SELECT *
		FROM tb_servicio
		WHERE tb_servicio_nom LIKE '%$dato%'
		GROUP BY tb_servicio_nom
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function verifica_servicio_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_servicio_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_servicio WHERE tb_servicio_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_proveedor_por_servicio($pro_id){
	$sql="SELECT tb_servicio_nom,tb_proveedor_nom,tb_proveedor_doc,tb_proveedor_dir,tb_proveedor_tel,tb_proveedor_ema, COUNT(*) AS numero
	FROM tb_servicio p
	INNER JOIN tb_presentacion pr ON p.tb_servicio_id = pr.tb_servicio_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_compradetalle cd ON ct.tb_catalogo_id = cd.tb_catalogo_id
	INNER JOIN tb_compra cp ON cd.tb_compra_id=cp.tb_compra_id
	INNER JOIN tb_proveedor pv ON cp.tb_proveedor_id=pv.tb_proveedor_id
	WHERE p.tb_servicio_id=$pro_id AND tb_compra_est='CANCELADA'
	GROUP BY pv.tb_proveedor_id
	ORDER BY numero DESC ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_por_ids($ids){
	$sql="SELECT * 
	FROM tb_categoria
	WHERE tb_categoria_idp=$ids
	ORDER BY tb_categoria_nom";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
}
?>