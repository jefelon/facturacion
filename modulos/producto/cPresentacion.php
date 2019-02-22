<?php
class cPresentacion{
	function insertar($nom,$cod,$stomin, $est, $pro_id,$codigemid){
	$sql = "INSERT INTO tb_presentacion(
		`tb_presentacion_reg` ,
		`tb_presentacion_mod` ,
		`tb_presentacion_nom` ,
		`tb_presentacion_cod` ,
		`tb_presentacion_stomin` ,
		`tb_presentacion_est` ,
		`tb_producto_id`,
		`tb_presentacion_codigemid`
		)
		VALUES (
		NOW( ) , NOW( ) ,  '$nom', '$cod',  '$stomin', '$est',  '$pro_id',  '$codigemid'
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
	function mostrar_por_producto($pro_id){
	$sql="SELECT * 
	FROM tb_presentacion pr
	WHERE tb_producto_id=$pro_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_producto_res($pro_id){
	$sql="SELECT * 
	FROM tb_presentacion
	WHERE tb_producto_id=$pro_id
	AND tb_presentacion_idr=0
	";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_producto_cmb($pro_id){
	$sql="SELECT * 
	FROM tb_presentacion
	WHERE tb_producto_id=$pro_id
	ORDER BY tb_presentacion_reg DESC";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_producto_cmb_res($pro_id){
	$sql="SELECT * 
	FROM tb_presentacion
	WHERE tb_producto_id=$pro_id
	AND tb_presentacion_res=1
	ORDER BY tb_presentacion_reg DESC";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrar_por_presentacion($tar_id){
	$sql="SELECT * 
	FROM tb_presentacion
	WHERE tb_presentacion_idr=$tar_id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_presentacion
	WHERE tb_presentacion_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function complete_nom($dato){
	$sql="SELECT *
		FROM tb_presentacion
		WHERE tb_presentacion_nom LIKE '%$dato%'
		GROUP BY tb_presentacion_nom
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function complete_cod($dato){
	$sql="SELECT *
		FROM tb_presentacion
		WHERE tb_presentacion_cod LIKE '%$dato%'
		GROUP BY tb_presentacion_cod
		LIMIT 0,12
		";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;		  
	}
	function modificar($id,$nom,$cod, $stomin, $est,$codigemid){
	$sql = "UPDATE  tb_presentacion SET  
	`tb_presentacion_mod` = NOW( ) ,
	`tb_presentacion_nom` =  '$nom',
	`tb_presentacion_cod` =  '$cod',
	`tb_presentacion_stomin` =  '$stomin',
	`tb_presentacion_est` =  '$est',
	`tb_presentacion_codigemid` =  '$codigemid'
	 WHERE tb_presentacion_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
    function modificar2($id,$nom){
        $sql = "UPDATE  tb_presentacion SET  
	`tb_presentacion_mod` = NOW( ) ,
	`tb_presentacion_nom` =  '$nom'
	 WHERE tb_presentacion_id =$id;";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
	function actualizar_stock($id,$sto){
	$sql = "UPDATE  tb_presentacion SET  
	`tb_presentacion_mod` = NOW( ) ,
	`tb_presentacion_sto` =  '$sto'
	 WHERE tb_presentacion_id =$id;"; 
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_presentacion_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_presentacion_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_presentacion WHERE tb_presentacion_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>