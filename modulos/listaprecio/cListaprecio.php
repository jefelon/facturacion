<?php
class cListaprecio{
    function insertar($prod_id, $precio_id, $precos, $preven, $uti){
        $sql = "INSERT INTO tb_detallelistaprecio (
		`tb_producto_id`,
		`tb_precio_id`,
		`tb_detallelistaprecio_precos`,
		`tb_detallelistaprecio_preven`,
		`tb_detallelistaprecio_uti`
		)
		VALUES (
		 '$prod_id',
		 '$precio_id', 
		 '$precos', 
		 '$preven', 
		 '$uti'
		);";
        $oCado = new Cado();
        $rst = $oCado->ejecute_sql($sql);
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
	FROM tb_detallelistaprecio";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function mostrarUno($id){
	$sql="SELECT * 
	FROM tb_detallelistaprecio
	WHERE tb_detallelistaprecio=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}

    function mostrarListaprecio($prod_id, $precio_id){
        $sql="SELECT * 
	FROM tb_detallelistaprecio
	WHERE tb_producto_id=$prod_id AND tb_precio_id=$precio_id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


	function modificar($id, $precos, $preven, $uti){
	$sql = "UPDATE tb_detallelistaprecio SET  
	`tb_detallelistaprecio_precos` =  '$precos',
	`tb_detallelistaprecio_preven` =  '$preven',
	`tb_detallelistaprecio_uti` =  '$uti'
	WHERE  tb_detallelistaprecio_id = $id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;	
	}
	function verifica_precio_tabla($id,$tabla){
	$sql = "SELECT * 
		FROM  $tabla 
		WHERE tb_precio_id =$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
	function eliminar($id){
	$sql="DELETE FROM tb_detallelistaprecio WHERE tb_detallelistaprecio_id=$id";
	$oCado = new Cado();
	$rst=$oCado->ejecute_sql($sql);
	return $rst;
	}
}
?>