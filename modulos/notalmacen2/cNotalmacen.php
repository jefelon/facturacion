<?php
class cNotalmacen{
	function insertar($fec,$tip,$doc_id,$numdoc,$tipope_id,$des,$alm_id,$usu_id,$emp_id){
	$sql = "INSERT INTO tb_notalmacen(
	`tb_notalmacen_reg` ,
	`tb_notalmacen_fec` ,
	`tb_notalmacen_tip` ,
	`tb_documento_id` ,
	`tb_notalmacen_numdoc` ,
	`tb_tipoperacion_id` ,
	`tb_notalmacen_des` ,
	`tb_almacen_id` ,
	`tb_usuario_id` ,
	`tb_empresa_id`
	)
	VALUES (
	NOW( ) ,  '$fec',  '$tip',  '$doc_id',  '$numdoc',  '$tipope_id',  '$des', '$alm_id',  '$usu_id',  '$emp_id'
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
	function insertar_detalle($cat_id,$can,$cos,$pre,$notalm_id){
	$sql = "INSERT INTO tb_notalmacendetalle(
	`tb_catalogo_id` ,
	`tb_notalmacendetalle_can` ,
	`tb_notalmacendetalle_cos` ,
	`tb_notalmacendetalle_pre` ,
	`tb_notalmacen_id`
	)
	VALUES (
	'$cat_id',  '$can',  '$cos',  '$pre',  '$notalm_id'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function mostrar_filtro($fec1,$fec2,$alm_id,$tip,$emp_id){
	$sql="SELECT *
	FROM tb_notalmacen na
	INNER JOIN tb_almacen a ON na.tb_almacen_id=a.tb_almacen_id
	INNER JOIN tb_tipoperacion tp ON na.tb_tipoperacion_id = tp.tb_tipoperacion_id
	INNER JOIN tb_documento d ON na.tb_documento_id=d.tb_documento_id 
	WHERE na.tb_empresa_id = $emp_id AND tb_notalmacen_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($alm_id>0)$sql.=" AND na.tb_almacen_id = $alm_id ";
	if($tip!="")$sql.=" AND tb_notalmacen_tip = '$tip' ";
	
	$sql.=" ORDER BY tb_notalmacen_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_notalmacen t
	INNER JOIN tb_almacen a ON t.tb_almacen_id=a.tb_almacen_id
	WHERE tb_notalmacen_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_codigo(){
	$sql="SELECT MAX(tb_notalmacen_id) as numero 
	FROM tb_notalmacen;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_notalmacen_detalle($notalm_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_notalmacendetalle td ON ct.tb_catalogo_id = td.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE td.tb_notalmacen_id=$notalm_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $fec, $des){
	$sql = "UPDATE tb_notalmacen SET  
	`tb_notalmacen_fec` =  '$fec',
	`tb_notalmacen_des` =  '$des' 
	WHERE  tb_notalmacen_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function actualizar_salini($notalmdet_id, $can){
	$sql = "UPDATE tb_notalmacendetalle SET  
	`tb_notalmacendetalle_can` =  '$can' 
	WHERE tb_notalmacendetalle_id =$notalmdet_id;"; 
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
	function consulta_eliminar($tiporeg,$tipo,$documento_id,$tipoperacion_id,$operacion_id){
	$sql="SELECT * FROM tb_notalmacen 
	WHERE tb_notalmacen_tipreg = $tiporeg
	AND tb_notalmacen_tip = $tipo
	AND tb_documento_id = $documento_id
	AND tb_tipoperacion_id = $tipoperacion_id
	AND tb_operacion_id = $operacion_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_notalmacen($notalm_id){
	$sql="DELETE FROM tb_notalmacen WHERE tb_notalmacen_id=$notalm_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar_notalmacendetalle($notalm_id){
	$sql="DELETE FROM tb_notalmacendetalle WHERE tb_notalmacen_id=$notalm_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function consultar_existencia_saldo_inicial($cat_id, $alm_id){
   $sql="SELECT * 
   FROM tb_producto p        
   INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
   INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id        
   INNER JOIN tb_notalmacendetalle td ON ct.tb_catalogo_id = td.tb_catalogo_id
   INNER JOIN tb_notalmacen na ON na.tb_notalmacen_id = td.tb_notalmacen_id        
   WHERE td.tb_catalogo_id=$cat_id AND na.tb_tipoperacion_id = 1 AND na.tb_almacen_id = $alm_id";
   $oCado = new Cado();
   $rst=$oCado->ejecute_sql($sql);
   return $rst;
   }
   ///////////////////////////////////////
   function mostrar_notalmacen_detalle2($notalm_id,$alm_id){
	$sql="SELECT * 
	FROM tb_notalmacen n 
	INNER JOIN tb_notalmacendetalle td ON n.tb_notalmacen_id = td.tb_notalmacen_id
	INNER JOIN tb_catalogo ct ON td.tb_catalogo_id = ct.tb_catalogo_id
	INNER JOIN tb_presentacion pr ON ct.tb_presentacion_id = pr.tb_presentacion_id
	INNER JOIN tb_producto p ON pr.tb_producto_id = p.tb_producto_id
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE ";
//	$sql.= "n.tb_notalmacen_id=$notalm_id 
//	AND";
	$sql.=" tb_notalmacen_tip=1
	AND tb_tipoperacion_id=1
	AND tb_almacen_id=$alm_id
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_catalogo($id){
	$sql="SELECT * 
	FROM tb_catalogo2
	WHERE tb_catalogo_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar_detalle_na($id, $cos, $pre){
	$sql = "UPDATE tb_notalmacendetalle SET  
	`tb_notalmacendetalle_cos` =  '$cos',
	`tb_notalmacendetalle_pre` =  '$pre' 
	WHERE  tb_notalmacendetalle_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
}
?>