<?php
class cProducto{
	function insertar($nom, $des, $est, $cat_id, $mar_id, $afec_id, $usu_id, $prod_img){
	$sql = "INSERT INTO tb_producto(
		`tb_producto_reg` ,
		`tb_producto_mod` ,
		`tb_producto_nom` ,
		`tb_producto_des` ,
		`tb_producto_est` ,
		`tb_categoria_id` ,
		`tb_marca_id` ,
		`tb_afectacion_id` ,
		`tb_usuario_id`,
		`tb_producto_imagen`
		)
		VALUES (
		NOW( ) , NOW( ) ,  '$nom',  '$des',  '$est',  '$cat_id', '$mar_id', '$afec_id', '$usu_id', '$prod_img'
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
	function mostrar_filtro($nom,$cat,$mar,$est,$fil,$ordby){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	WHERE tb_producto_est LIKE '%$est%' ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	$sql.=" ORDER BY $ordby ";
	
	if($fil!="")$sql.=" LIMIT 0,$fil ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_presentacion_filtro($nom,$cat,$mar,$est){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion r ON p.tb_producto_id=r.tb_producto_id
	INNER JOIN tb_unidad u ON r.tb_unidad_id=u.tb_unidad_id
	WHERE tb_producto_est LIKE '%$est%' ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id=$cat ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";


	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_presentacion($id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_presentacion r ON p.tb_producto_id=r.tb_producto_id
	INNER JOIN tb_unidad u ON r.tb_unidad_id=u.tb_unidad_id
	WHERE tb_presentacion_id=$id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function mostrar_venta_detalle($ven_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_ventadetalle vd ON pr.tb_presentacion_id=vd.tb_presentacion_id
	INNER JOIN tb_unidad u ON pr.tb_unidad_id=u.tb_unidad_id
	WHERE vd.tb_venta_id=$ven_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	LEFT JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	WHERE tb_producto_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $nom, $des, $est, $cat_id, $mar_id, $afec_id, $usu_id, $prod_img){
	$sql = "UPDATE tb_producto SET  
	`tb_producto_mod` = NOW( ) ,
	`tb_producto_nom` =  '$nom',
	`tb_producto_des` =  '$des',
	`tb_producto_est` =  '$est',
	`tb_categoria_id` =  '$cat_id',
	`tb_marca_id` =  '$mar_id',
	`tb_afectacion_id` =  '$afec_id',
	`tb_usuario_id` =  '$usu_id',
	`tb_producto_imagen` =  '$prod_img' 
	WHERE  tb_producto_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
    function complete_cod($dato,$limit){
        $sql="SELECT *
		FROM tb_producto
		WHERE tb_producto_cod LIKE '%$dato%'
		GROUP BY tb_producto_cod
		LIMIT 0,$limit
		";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function complete_nom($dato,$limit){
	$sql="SELECT *
		FROM tb_producto
		WHERE tb_producto_nom LIKE '%$dato%'
		GROUP BY tb_producto_nom
		LIMIT 0,$limit
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function verifica_producto_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_producto_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function consultar_coincidencia($pro_id,$pro_nom, $cat_id, $mar_id){
	$sql = "SELECT * 
		FROM  tb_producto
		WHERE tb_producto_nom LIKE '%$pro_nom%'
		AND tb_categoria_id = $cat_id
		AND tb_marca_id = $mar_id ";
		
	if($pro_id>0)$sql.=" AND tb_producto_id <> $pro_id ";
	
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_producto WHERE tb_producto_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_proveedor_por_producto($pro_id){
	$sql="SELECT tb_producto_nom,tb_proveedor_nom,tb_proveedor_doc,tb_proveedor_dir,tb_proveedor_tel,tb_proveedor_ema, COUNT(*) AS numero
	FROM tb_producto p
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_compradetalle cd ON ct.tb_catalogo_id = cd.tb_catalogo_id
	INNER JOIN tb_compra cp ON cd.tb_compra_id=cp.tb_compra_id
	INNER JOIN tb_proveedor pv ON cp.tb_proveedor_id=pv.tb_proveedor_id
	WHERE p.tb_producto_id=$pro_id AND tb_compra_est='CANCELADA'
	GROUP BY pv.tb_proveedor_id
	ORDER BY numero DESC ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
}
?>