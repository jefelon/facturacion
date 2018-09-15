<?php
class clote{
	function insertar($nom){
	$sql = "INSERT tb_lote (
		`tb_lote_nom`
		)
		VALUES (
		 '$nom'
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
	function mostrarTodos(){
	$sql="SELECT * 
	FROM tb_lote
	ORDER BY tb_lote_numero";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
    function mostrarLoteProducto($idPresentacion,$alm_id,$stock_id){
	$sql="SELECT * 
	FROM tb_lote l
	INNER JOIN  tb_almacen a on l.tb_almacen_id=a.tb_almacen_id
	INNER JOIN  tb_stock s on l.tb_stock_id=s.tb_stock_id
	INNER JOIN  tb_presentacion p on l.tb_presentacion_id=p.tb_presentacion_id

	WHERE p.tb_presentacion_id=$idPresentacion AND a.tb_almacen_id=$alm_id AND s.tb_stock_id=$stock_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

//    function mostrar_por_producto_cmb($pro_id){
//	$sql="SELECT *
//	FROM tb_presentacion
//	WHERE tb_producto_id=$pro_id
//	ORDER BY tb_presentacion_reg DESC";
//        $oCado = new Cado();
//        $rst=$oCado->ejecute_sql($sql);
//        return $rst;
//    }

	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_lote
	WHERE tb_lote_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function modificar($id,$nom){ 
	$sql = "UPDATE tb_lote SET  
	`tb_lote_nom` =  '$nom'
	WHERE  tb_lote_id =$id;";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_lote_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_lote_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_lote WHERE tb_lote_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>