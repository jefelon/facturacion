<?php
class cTraspaso{
	function insertar($fec,$doc_id,$cod,$alm_ori,$alm_des,$ref,$usu_id,$emp_id,$act){
	$sql = "INSERT INTO tb_traspaso(
	`tb_traspaso_reg` ,
	`tb_traspaso_fec` ,
	`tb_documento_id` ,
	`tb_traspaso_cod` ,
	`tb_almacen_id_ori` ,
	`tb_almacen_id_des` ,
	`tb_traspaso_ref` ,
	`tb_usuario_id`,
	`tb_empresa_id`,
	`tb_traspaso_act`
	)
	VALUES (
	NOW( ) ,  '$fec', '$doc_id', '$cod',  '$alm_ori',  '$alm_des', '$ref',  '$usu_id', '$emp_id','$act'
	);"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function insertar_detalle($cat_id,$can,$tra_id){
	$sql = "INSERT INTO tb_traspasodetalle(
	`tb_catalogo_id` ,
	`tb_traspasodetalle_can` ,
	`tb_traspaso_id`
	)
	VALUES (
	'$cat_id',  '$can',  '$tra_id'
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
	function mostrar_filtro($fec1,$fec2,$alm_ori,$alm_des,$emp_id,$act){
	$sql="SELECT tb_traspaso_id, tb_traspaso_fec, tb_documento_id, tb_traspaso_cod, ao.tb_almacen_nom as almacen_ori, ad.tb_almacen_nom as almacen_des, tb_traspaso_ref
	FROM tb_traspaso t
	INNER JOIN tb_almacen ao ON t.tb_almacen_id_ori=ao.tb_almacen_id
	INNER JOIN tb_almacen ad ON t.tb_almacen_id_des=ad.tb_almacen_id
	WHERE t.tb_empresa_id = $emp_id AND tb_traspaso_fec BETWEEN '$fec1' AND '$fec2' ";
	
	if($alm_ori>0)$sql.=" AND ao.tb_almacen_id = $alm_ori ";
	if($alm_des>0)$sql.=" AND ad.tb_almacen_id = $alm_des ";
	if($act>0)$sql.=" AND t.tb_traspaso_act = '$act' ";
	
	$sql.=" ORDER BY tb_traspaso_fec ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT tb_traspaso_id, tb_traspaso_reg, tb_traspaso_fec, tb_documento_id, tb_traspaso_cod,t.tb_almacen_id_ori, ao.tb_almacen_nom as almacen_ori,t.tb_almacen_id_des, ad.tb_almacen_nom as almacen_des, tb_traspaso_ref, tb_usuario_id
	FROM tb_traspaso t
	INNER JOIN tb_almacen ao ON t.tb_almacen_id_ori=ao.tb_almacen_id
	INNER JOIN tb_almacen ad ON t.tb_almacen_id_des=ad.tb_almacen_id
	WHERE tb_traspaso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_codigo(){
	$sql="SELECT MAX(tb_traspaso_id) as numero 
	FROM tb_traspaso;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_traspaso_detalle($tra_id){
	$sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_traspasodetalle td ON ct.tb_catalogo_id = td.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	WHERE td.tb_traspaso_id=$tra_id ";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id, $fec, $ref){
	$sql = "UPDATE tb_traspaso SET  
	`tb_traspaso_fec` =  '$fec',
	`tb_traspaso_ref` =  '$ref' 
	WHERE  tb_traspaso_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function modificar_act($id, $act){
	$sql = "UPDATE tb_traspaso SET  
	`tb_traspaso_act` =  '$act' 
	WHERE  tb_traspaso_id =$id;"; 
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
	$sql="DELETE FROM tb_traspaso WHERE tb_traspaso_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

	function mostrar_todos_por_empresa_almacen_destino($emp_id, $alm_id){
	$sql="SELECT *
	FROM tb_traspaso t 
	WHERE t.tb_empresa_id = $emp_id 
	AND t.tb_almacen_id_des = $alm_id 
	ORDER BY t.tb_traspaso_fec DESC";
       $oCado = new Cado();
       $rst=$oCado->ejecute_sql($sql);
       return $rst;
       }
	function mostrar_todos_por_empresa_almacen_origen($emp_id, $alm_id){
    $sql="SELECT *
	FROM tb_traspaso t 
	WHERE t.tb_empresa_id = $emp_id 
	AND t.tb_almacen_id_ori = $alm_id 
	ORDER BY t.tb_traspaso_fec DESC";
       $oCado = new Cado();
       $rst=$oCado->ejecute_sql($sql);
       return $rst;
       }
}
?>