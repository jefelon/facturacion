<?php
class cVentaDetalleLote{
	function insertar($ven_det_id,$fechafab, $fechaven, $st_act, $lotenum){
	$sql = "INSERT tb_ventadetalle_lote (
		`tb_ventadetalle_id`,
		`tb_fecha_fab`,
		`tb_fecha_ven`,
		`tb_ventadetalle_exisact`,
		`tb_ventadetalle_lotenum`
		)
		VALUES (
		 '$ven_det_id',
		 '$fechafab',
		 '$fechaven',
		 '$st_act',
		 '$lotenum'
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
	FROM tb_ventadetalle_lote";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrar_filtro_venta_detalle($vendet_id){
        $sql="SELECT * 
	FROM tb_ventadetalle_lote WHERE tb_ventadetalle_id=$vendet_id";

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

	WHERE p.tb_presentacion_id=$idPresentacion AND a.tb_almacen_id=$alm_id AND s.tb_stock_id=$stock_id ORDER BY tb_lote_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function sumaLoteProducto($idPresentacion,$alm_id,$stock_id){
        $sql="SELECT SUM(tb_lote_exisact) as sum_lotes  
	FROM tb_lote l
	INNER JOIN  tb_almacen a on l.tb_almacen_id=a.tb_almacen_id
	INNER JOIN  tb_stock s on l.tb_stock_id=s.tb_stock_id
	INNER JOIN  tb_presentacion p on l.tb_presentacion_id=p.tb_presentacion_id

	WHERE p.tb_presentacion_id=$idPresentacion AND a.tb_almacen_id=$alm_id AND s.tb_stock_id=$stock_id ORDER BY tb_lote_id";
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

    function mostrarUnoLoteNumero($numero, $alm_id){
        $sql="SELECT * 
        FROM tb_lote
        WHERE tb_lote_numero='$numero' AND tb_almacen_id='$alm_id';";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

	function modificar($id,$num, $fab, $vence, $stock){
	$sql = "UPDATE tb_lote SET  
        `tb_lote_numero` =  '$num',
        `tb_lote_fechafab` = '$fab',
		`tb_lote_fechavence` = '$vence',
		`tb_lote_exisact` = '$stock'
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