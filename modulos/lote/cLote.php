<?php
class clote{
	function insertar($num, $cat_id, $fechafab, $fechaven, $st_act, $est, $alm_id){
	$sql = "INSERT tb_lote (
		`tb_lote_numero`,
		`tb_catalogo_id`,
		`tb_lote_fechafab`,
		`tb_lote_fechavence`,
		`tb_lote_exisact`,
		`tb_lote_estado`,
		`tb_almacen_id`
		)
		VALUES (
		 '$num',
		 '$cat_id',
		 '$fechafab',
		 '$fechaven',
		 '$st_act',
		 '$est',
		 '$alm_id'
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
	FROM tb_lote ORDER BY tb_lote_id";
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

    function mostrarLoteCatalogo($cat_id,$alm_id){
        $sql="SELECT * 
	FROM tb_lote l
	INNER JOIN  tb_almacen a on l.tb_almacen_id=a.tb_almacen_id
	WHERE l.tb_catalogo_id='$cat_id' AND l.tb_almacen_id='$alm_id'";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function complete_nom($dato, $alm_id, $cat_id){
        $sql="SELECT *
		FROM tb_lote
		WHERE tb_lote_numero LIKE '%$dato%' AND tb_almacen_id='$alm_id' AND tb_catalogo_id= '$cat_id'
		ORDER BY tb_lote_fechavence ASC 
		LIMIT 0,12
		";
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

    function mostrarUnoLoteNumero($cat_id, $numero, $alm_id){
        $sql="SELECT * 
        FROM tb_lote
        WHERE tb_catalogo_id ='$cat_id' AND tb_lote_numero='$numero' AND tb_almacen_id='$alm_id';";
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

    function modificar_stock($cat_id, $lote_num,$alm_id, $stock){
        $sql = "UPDATE tb_lote SET  
		`tb_lote_exisact` = '$stock'
	WHERE tb_catalogo_id ='$cat_id' AND tb_lote_numero ='$lote_num' AND tb_almacen_id = '$alm_id';";
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