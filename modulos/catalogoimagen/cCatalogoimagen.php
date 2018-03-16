<?php 
class cCatalogoimagen{
	// Funciones para tb_catalogoimagen
	function insertar($tit,$des){
		$sql="INSERT INTO `tb_catalogoimagen`(
		`tb_catalogoimagen_tit`, 
		`tb_catalogoimagen_des`
		) 
		VALUES ('$tit','$des')";

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
	function mostrar_todo(){
		$sql="SELECT * FROM `tb_catalogoimagen` 
		ORDER BY tb_catalogoimagen_id DESC;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function mostrarUno($id){
		$sql="SELECT * FROM `tb_catalogoimagen` 
		WHERE tb_catalogoimagen_id=$id;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function  mostrar_imagenfile($catima_id){		
		$sql="SELECT * FROM `tb_catalogoimagenfile` 
		WHERE `tb_catalogoimagen_id`=$catima_id;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function  modificar_catalogoimg($id,$tit,$des){		
		$sql="UPDATE `tb_catalogoimagen` SET 		
		`tb_catalogoimagen_tit`='$tit',
		`tb_catalogoimagen_des`='$des' 
		WHERE `tb_catalogoimagen_id`=$id;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function eliminar($id){
		$sql="DELETE FROM `tb_catalogoimagen`
		WHERE `tb_catalogoimagen_id`=$id;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}



	//Funciones para tb_imagen
	function insertar_img($catimg_id,$url){
		$sql="INSERT INTO `tb_catalogoimagenfile`(		 
		`tb_catalogoimagen_id`, 
		`tb_catalogoimagenfile_url`
		) 
		VALUES ('$catimg_id','$url')";

		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function ultimoInsert_img(){
	$sql = "SELECT last_insert_id()"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_url($id,$url){ 
	$sql = "UPDATE tb_catalogoimagenfile SET  
	tb_catalogoimagenfile_url =  '$url'
	WHERE tb_catalogoimagenfile_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrarUno_imagenfile($id){
		$sql="SELECT * FROM `tb_catalogoimagenfile` 
		WHERE tb_catalogoimagenfile_id=$id";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function eliminar_file($id){ 
	$sql = "DELETE FROM tb_catalogoimagenfile 	
	WHERE tb_catalogoimagenfile_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}



	// Funciones para tb_catalogoiamgendetalle
	function insertar_det($catimg_id,$cat_id){
		$sql="INSERT INTO `tb_catalogoimagendetalle`(
		`tb_catalogoimagen_id`,
		`tb_catalogo_id`
		) 
		VALUES ('$catimg_id','$cat_id')";

		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;	
	}
	function mostrar_todo_det($catimg_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_catalogoimagendetalle ctimg ON ctimg.tb_catalogo_id=ct.tb_catalogo_id
	WHERE ctimg.tb_catalogoimagen_id=$catimg_id	
	AND tb_producto_est LIKE 'Activo' ";

	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_det($id){
		$sql="DELETE FROM `tb_catalogoimagendetalle`
		WHERE `tb_catalogoimagendetalle_id`=$id;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}


	// Funcion para catalogo_venta_catalogoimagen donde se a ha mostrar el Slider de las imagenes 
	function mostrar_slaider($cat_id){
		$sql="SELECT * FROM `tb_catalogoimagendetalle` cd
		INNER JOIN tb_catalogoimagen ci ON ci.tb_catalogoimagen_id=cd.tb_catalogoimagen_id
		INNER JOIN tb_catalogo ct ON ct.tb_catalogo_id=cd.tb_catalogo_id
		WHERE cd.tb_catalogo_id=$cat_id;";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
	// para que no se vuelva a registrar el mismo producto
	function registroAcceso($cat_id){
		$sql="SELECT * FROM tb_catalogoimagendetalle WHERE tb_catalogo_id='$cat_id'";
		$oCado = new Cado();
		$rst=$oCado->ejecute_sql($sql);
		return $rst;
	}
}
?>