<?php
class cCatalogo{
	function mostrar_todos(){
       $sql="SELECT *
       FROM tb_producto p
       INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
       INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
       INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
       INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
       INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
       ";
       $oCado = new Cado();
       $rst=$oCado->ejecute_sql($sql);
       return $rst;
    }
	function catalogo_compra_filtro($nom,$cod,$cat,$mar,$est,$limit){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE ct.tb_catalogo_vercom=1
	AND tb_producto_est LIKE '%$est%' ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	$sql.=" ORDER BY tb_producto_nom ";
	
	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function catalogo_compra_filtro_descuento($proid,$proveid){
        $sql="SELECT * 
        FROM tb_producto p
        INNER JOIN tb_productoproveedor pp ON p.tb_producto_id=pp.tb_producto_id
        WHERE p.tb_producto_id=$proid AND pp.tb_proveedor_id=$proveid";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	
	function catalogo_guia_filtro($nom,$cod,$cat,$mar,$est){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE ct.tb_catalogo_vercom=1
	AND tb_producto_est LIKE '%$est%' ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	$sql.=" ORDER BY tb_producto_nom ";
	
	$sql.=" LIMIT 0,25 ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function catalogo_venta_filtro($alm_ven,$nom,$cod,$cat,$mar,$est,$limit){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE ct.tb_catalogo_verven=1
	AND tb_producto_est LIKE '%$est%' ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	$sql.=" ORDER BY tb_producto_nom ";
	
	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function catalogo_traspaso_filtro($nom,$cod,$cat,$mar,$est,$alm_id,$verven,$vercom,$unibas,$limit){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id
	WHERE s.tb_almacen_id=$alm_id
	AND tb_producto_est LIKE '%$est%' ";

	if($verven==1 and $vercom==1)
	{
		$sql.=" AND (ct.tb_catalogo_verven=1 OR ct.tb_catalogo_vercom=1)";
	}
	
	if($verven==1 and $vercom==0)
	{
		$sql.=" AND ct.tb_catalogo_verven=1 ";
	}
	
	if($verven==0 and $vercom==1)
	{
		$sql.=" AND ct.tb_catalogo_vercom=1 ";
	}
	
	if($verven==0 and $vercom==0)
	{
		$sql.=" AND (ct.tb_catalogo_verven=0 AND ct.tb_catalogo_vercom=0)";
	}
	
	if($unibas==1)$sql.=" AND ct.tb_catalogo_unibas =1 ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";

	$sql.=" ORDER BY tb_producto_nom ";

	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function catalogo_notalmacen_filtro_salida($nom,$cod,$cat,$mar,$est,$alm_id,$verven,$vercom,$unibas,$limit){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id
	WHERE s.tb_almacen_id=$alm_id
	AND tb_producto_est LIKE '%$est%' ";
	
	if($verven==1 and $vercom==1)
	{
		$sql.=" AND (ct.tb_catalogo_verven=1 OR ct.tb_catalogo_vercom=1)";
	}
	
	if($verven==1 and $vercom==0)
	{
		$sql.=" AND ct.tb_catalogo_verven=1 ";
	}
	
	if($verven==0 and $vercom==1)
	{
		$sql.=" AND ct.tb_catalogo_vercom=1 ";
	}
	
	if($verven==0 and $vercom==0)
	{
		$sql.=" AND (ct.tb_catalogo_verven=0 AND ct.tb_catalogo_vercom=0)";
	}
	
	if($unibas==1)$sql.=" AND ct.tb_catalogo_unibas =1 ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";

	$sql.=" ORDER BY tb_producto_nom ";

	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function catalogo_notalmacen_filtro_entrada($nom,$cod,$cat,$mar,$est,$verven,$vercom,$unibas,$limit){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE tb_producto_est LIKE '%$est%' ";
	
	if($verven==1 and $vercom==1)
	{
		$sql.=" AND (ct.tb_catalogo_verven=1 OR ct.tb_catalogo_vercom=1)";
	}
	
	if($verven==1 and $vercom==0)
	{
		$sql.=" AND ct.tb_catalogo_verven=1 ";
	}
	
	if($verven==0 and $vercom==1)
	{
		$sql.=" AND ct.tb_catalogo_vercom=1 ";
	}
	
	if($verven==0 and $vercom==0)
	{
		$sql.=" AND (ct.tb_catalogo_verven=0 AND ct.tb_catalogo_vercom=0)";
	}
	
	if($unibas==1)$sql.=" AND ct.tb_catalogo_unibas =1 ";

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";

	$sql.=" ORDER BY tb_producto_nom ";

	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function catalogo_filtro($nom,$cod,$cat,$mar,$est,$alm_id,$atr_ids,$verven,$vercom,$unibas){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id ";
	
	if($atr_ids!="")$sql.=" INNER JOIN tb_tag t ON pr.tb_presentacion_id=t.tb_presentacion_id ";
	
	$sql.=" WHERE s.tb_almacen_id=$alm_id
	AND tb_producto_est LIKE '%$est%' ";

	if($atr_ids!="")$sql.=" AND tb_atributo_id IN ($atr_ids) ";

	if($verven==1 and $vercom==1)
	{
		$sql.=" AND (ct.tb_catalogo_verven=1 OR ct.tb_catalogo_vercom=1)";
	}
	
	if($verven==1 and $vercom==0)
	{
		$sql.=" AND ct.tb_catalogo_verven=1 ";
	}
	
	if($verven==0 and $vercom==1)
	{
		$sql.=" AND ct.tb_catalogo_vercom=1 ";
	}
	
	if($verven==0 and $vercom==0)
	{
		$sql.=" AND (ct.tb_catalogo_verven=0 AND ct.tb_catalogo_vercom=0)";
	}

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	if($unibas==1)$sql.=" AND ct.tb_catalogo_unibas =1 ";
	
	if($atr_ids!="")$sql.=" GROUP BY ct.tb_catalogo_id ";
	
	$sql.=" GROUP BY p.tb_producto_id ORDER BY c.tb_categoria_nom, m.tb_marca_nom";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function catalogo_filtro_stock($nom,$cod,$cat,$mar,$est,$atr_ids,$verven,$vercom,$unibas,$limit){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id ";
	
	if($atr_ids!="")$sql.=" INNER JOIN tb_tag t ON pr.tb_presentacion_id=t.tb_presentacion_id ";



	$sql.=" WHERE tb_producto_est LIKE '%$est%' ";


	if($atr_ids!="")$sql.=" AND tb_atributo_id IN ($atr_ids) ";

	if($verven==1 and $vercom==1)
	{
		$sql.=" AND (ct.tb_catalogo_verven=1 OR ct.tb_catalogo_vercom=1)";
	}
	
	if($verven==1 and $vercom==0)
	{
		$sql.=" AND ct.tb_catalogo_verven=1 ";
	}
	
	if($verven==0 and $vercom==1)
	{
		$sql.=" AND ct.tb_catalogo_vercom=1 ";
	}
	
	if($verven==0 and $vercom==0)
	{
		$sql.=" AND (ct.tb_catalogo_verven=0 AND ct.tb_catalogo_vercom=0)";
	}

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	if($unibas==1)$sql.=" AND ct.tb_catalogo_unibas =1 ";

	
	if($atr_ids!="")$sql.=" GROUP BY ct.tb_catalogo_id ";
	
	$sql.=" ORDER BY c.tb_categoria_nom, m.tb_marca_nom ";
	if($limit!="")$sql.=" LIMIT 0,$limit ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	
	function catalogo_filtro_atributos($nom,$cod,$cat,$mar,$est,$alm_id,$verven,$vercom,$unibas, $atributos){
	$atributos_array = explode(",", $atributos);
	
	$sql="SELECT p.tb_producto_id, p.tb_producto_nom, p.tb_producto_des, p.tb_producto_mod, p.tb_producto_est, p.tb_categoria_id, c.tb_categoria_nom, c.tb_categoria_idp, m.tb_marca_id, m.tb_marca_nom, pr.tb_presentacion_id, pr.tb_presentacion_nom, pr.tb_presentacion_cod, pr.tb_presentacion_stomin, pr.tb_presentacion_est, t.tb_tag_id, t.tb_atributo_id, a.tb_atributo_nom, ct.tb_catalogo_id, ct.tb_catalogo_mod, ct.tb_catalogo_mul, ct.tb_catalogo_preunicom, ct.tb_catalogo_precos, ct.tb_catalogo_igvcom, ct.tb_catalogo_uti, ct.tb_catalogo_preven, ct.tb_catalogo_igvven, ct.tb_catalogo_verven, ct.tb_catalogo_vercom, ct.tb_catalogo_est, ct.tb_catalogo_unibas, u.tb_unidad_id, u.tb_unidad_abr, u.tb_unidad_nom, u.tb_unidad_tip, s.tb_stock_id, s.tb_stock_num
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_tag t ON t.tb_presentacion_id = pr.tb_presentacion_id
	INNER JOIN tb_atributo a ON t.tb_atributo_id = a.tb_atributo_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	INNER JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id
	WHERE s.tb_almacen_id=$alm_id ";
	
	for($i = 1; $i < sizeof($atributos_array); $i++){
		$sql .= " AND t.tb_atributo_id = ".trim($atributos_array[$i])." ";
	}
	$sql .="
	AND tb_producto_est LIKE '%$est%' ";

	if($verven==1 and $vercom==1)
	{
		$sql.=" AND (ct.tb_catalogo_verven=1 OR ct.tb_catalogo_vercom=1) ";
	}
	
	if($verven==1 and $vercom==0)
	{
		$sql.=" AND ct.tb_catalogo_verven=1 ";
	}
	
	if($verven==0 and $vercom==1)
	{
		$sql.=" AND ct.tb_catalogo_vercom=1 ";
	}
	
	if($verven==0 and $vercom==0)
	{
		$sql.=" AND (ct.tb_catalogo_verven=0 AND ct.tb_catalogo_vercom=0) ";
	}

	if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
	if($cod!="")$sql.=" AND tb_presentacion_cod LIKE '%$cod%' ";
	if($cat!="")$sql.=" AND p.tb_categoria_id IN ($cat) ";
	if($mar!="")$sql.=" AND p.tb_marca_id=$mar ";
	
	if($unibas==1)$sql.=" AND ct.tb_catalogo_unibas =1 ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	//para actualizar datos borrar
	function consulta_costo($cat_id){
       $sql="SELECT *
       FROM tb_costo
       WHERE tb_catalogo_id =$cat_id;
       ";
       $oCado = new Cado();
       $rst=$oCado->ejecute_sql($sql);
       return $rst;
    }

	function copia_dato_cospro($cat_id,$precos,$precosdol){
       $sql="UPDATE tb_catalogo SET  
       `tb_catalogo_precos` =  '$precos',
       `tb_catalogo_precosdol` =  '$precosdol' 
       WHERE  tb_catalogo_id =$cat_id;
       ";
       $oCado = new Cado();
       $rst=$oCado->ejecute_sql($sql);
       return $rst;
    }

    function actualizar_cambio($cam){
       $sql="UPDATE tb_catalogo SET  
       `tb_catalogo_tipcam` =  '$cam'
       WHERE  tb_catalogo_tipcam>0;
       ";
       $oCado = new Cado();
       $rst=$oCado->ejecute_sql($sql);
       return $rst;
    }

    //--------fin
}
?>