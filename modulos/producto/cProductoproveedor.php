<?php
class cProductoproveedor{
    function insertar_producto_proveedor($prod_id,$prov_id, $cant_min, $desc, $fec_ini, $fec_fin){
        $sql = "INSERT INTO tb_productoproveedor(
	`tb_producto_id` ,
	`tb_proveedor_id` ,
	`tb_productoproveedor_cantmin` ,
	`tb_productoproveedor_desc`,
	`tb_productoproveedor_fechaini` ,
	`tb_productoproveedor_fechafin`
	)
	VALUES (
      '$prod_id',  '$prov_id',  '$cant_min',  '$desc',  '$fec_ini', '$fec_fin'
	);";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function eliminar_por_productoID($id){
        $sql="DELETE FROM tb_productoproveedor WHERE tb_producto_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function eliminar($id){
        $sql="DELETE FROM tb_productoproveedor WHERE tb_productoproveedor_id=$id";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}