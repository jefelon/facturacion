<?php
class cCatalogoproducto{
	function insertar($uni_id_bas, $uni_id_equ,$mul,$tipcam,$precosdol,$preunicom,$precos,$uti,$preven, $vercom, $verven,$igvcom, $igvven, $est, $unibas, $pre_id){
	$sql = "INSERT INTO  tb_catalogo(
		`tb_catalogo_reg` ,
		`tb_catalogo_mod` ,
		`tb_unidad_id_bas` ,
		`tb_unidad_id_equ` ,
		`tb_catalogo_mul` ,
		`tb_catalogo_tipcam` ,
		`tb_catalogo_precosdol` ,
		`tb_catalogo_preunicom` ,
		`tb_catalogo_precos` ,
		`tb_catalogo_uti` ,
		`tb_catalogo_preven` ,
		`tb_catalogo_vercom` ,
		`tb_catalogo_verven` ,
		`tb_catalogo_igvcom` ,
		`tb_catalogo_igvven` ,
		`tb_catalogo_est` ,
		`tb_catalogo_unibas` ,
		`tb_presentacion_id`
		)
		VALUES (
		NOW( ) , NOW( ) ,  '$uni_id_bas',  '$uni_id_equ',  '$mul', '$tipcam', '$precosdol',  '$preunicom', '$precos', '$uti',  '$preven',  '$vercom',  '$verven', '$igvcom',  '$igvven',  '$est',  '$unibas',  '$pre_id'
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
	function modificar($id,$uni_id_bas, $uni_id_equ,$mul,$tipcam,$precosdol,$precos, $uti, $preven, $vercom, $verven, $igvcom, $igvven, $est, $unibas){
	$sql = "UPDATE tb_catalogo SET  
	`tb_catalogo_mod` = NOW( ) ,
	`tb_unidad_id_bas` =  '$uni_id_bas',
	`tb_unidad_id_equ` =  '$uni_id_equ',
	`tb_catalogo_mul` =  '$mul',
	`tb_catalogo_tipcam` =  '$tipcam',
	`tb_catalogo_precosdol` =  '$precosdol',
	`tb_catalogo_precos` =  '$precos',
	`tb_catalogo_uti` =  '$uti',
	`tb_catalogo_preven` =  '$preven',
	`tb_catalogo_vercom` =  '$vercom',
	`tb_catalogo_verven` =  '$verven',
	`tb_catalogo_igvcom` =  '$igvcom',
	`tb_catalogo_igvven` =  '$igvven',
	`tb_catalogo_est` =  '$est',
	`tb_catalogo_unibas` =  '$unibas'
	WHERE tb_catalogo_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_unidad_de_presentacion($pre_id){
	$sql="SELECT c.tb_catalogo_id as cat_id, c.tb_unidad_id_bas as ub_id, ue.tb_unidad_nom as ue_nom, ub.tb_unidad_nom as ub_nom, ue.tb_unidad_abr as ue_abr, ub.tb_unidad_abr as ub_abr,tb_catalogo_tipcam,tb_catalogo_precosdol, tb_catalogo_preunicom as preunicom, tb_catalogo_precos as precos, tb_catalogo_uti as uti, tb_catalogo_preven as preven, tb_catalogo_vercom as vercom, tb_catalogo_verven as verven, tb_catalogo_igvcom as igvcom, tb_catalogo_igvven as igvven, tb_catalogo_mul as mul, tb_catalogo_unibas as unibas, tb_catalogo_est as est
	FROM tb_catalogo c
	INNER JOIN tb_unidad ue ON c.tb_unidad_id_equ=ue.tb_unidad_id
	INNER JOIN tb_unidad ub ON c.tb_unidad_id_bas=ub.tb_unidad_id
	WHERE tb_presentacion_id=$pre_id
	ORDER BY c.tb_catalogo_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
		
	function presentacion_catalogo_producto($pro_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE p.tb_producto_id=$pro_id
	AND (ct.tb_catalogo_verven=1 OR ct.tb_catalogo_vercom=1)
	";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	if($unibas==1)$sql.=" AND ct.tb_catalogo_unibas =1 ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function presentacion_catalogo($cat_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE tb_catalogo_id = $cat_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function presentacion_unidad_base($pre_id){
	$sql="SELECT * 
	FROM tb_catalogo ct
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_bas=u.tb_unidad_id
	WHERE tb_presentacion_id = $pre_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function presentacion_catalogo_stock_almacen($cat_id,$alm_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id
	WHERE tb_catalogo_id = $cat_id 
	AND s.tb_almacen_id = $alm_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_catalogo
	WHERE tb_catalogo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function actualizar_precio_compra($id,$preunicom,$precos){
	$sql = "UPDATE  tb_catalogo SET  
	`tb_catalogo_mod` = NOW( ) ,
	`tb_catalogo_preunicom` =  '$preunicom',
	`tb_catalogo_precos` =  '$precos'
	 WHERE tb_catalogo_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function actualizar_precio_compra_dolar($id,$tipcam,$precosdol){
	$sql = "UPDATE  tb_catalogo SET  
	`tb_catalogo_mod` = NOW( ) ,
	`tb_catalogo_tipcam` =  '$tipcam',
	`tb_catalogo_precosdol` =  '$precosdol'
	 WHERE tb_catalogo_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function actualizar_precio_costo($id,$precos){
	$sql = "UPDATE  tb_catalogo SET  
	`tb_catalogo_mod` = NOW( ) ,
	`tb_catalogo_precos` =  '$precos'
	 WHERE tb_catalogo_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function actualizar_precio_venta($cat_id,$uti,$preven){
	$sql = "UPDATE  tb_catalogo SET  
	`tb_catalogo_mod` = NOW( ) ,
	`tb_catalogo_uti` =  '$uti',
	`tb_catalogo_preven` =  '$preven'
	 WHERE tb_catalogo_id =$cat_id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_catalogo_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_catalogo_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_catalogo WHERE tb_catalogo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>