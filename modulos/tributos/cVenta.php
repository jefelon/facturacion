<?php
class cVenta{
    function mostrar_filtro_por_mes_anio($mes_id,$anio_id,$emp_id){
        $sql="SELECT * 
	FROM tb_compra c
	INNER JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
	INNER JOIN tb_documento d ON c.tb_documento_id=d.tb_documento_id
	INNER JOIN tb_almacen a ON c.tb_almacen_id=a.tb_almacen_id
	WHERE c.tb_empresa_id = $emp_id";

        if($mes_id!="")$sql.=" AND MONTH(tb_compra_fec) = '$mes_id' ";
        if($anio_id!="")$sql.=" AND YEAR(tb_compra_fec) = '$anio_id' ";
        $sql.=" ORDER BY tb_compra_fec ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>