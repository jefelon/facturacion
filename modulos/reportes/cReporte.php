<?php
class cReporte{

    function producto_mas_vendido($fec1,$fec2,$emp_id,$pun_vent,$filas){
        $sql="SELECT ct.tb_catalogo_id,p.tb_producto_id, p.tb_producto_nom, pr.tb_presentacion_id, pr.tb_presentacion_nom, u.tb_unidad_id, u.tb_unidad_abr, ct.tb_catalogo_mul,  COUNT(*) AS numero
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id = c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id = m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_ventadetalle dt ON ct.tb_catalogo_id = dt.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	INNER JOIN tb_venta op ON dt.tb_venta_id=op.tb_venta_id
	WHERE op.tb_empresa_id = $emp_id    
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2'";
    if($pun_vent>0)$sql.=" AND op.tb_puntoventa_id = $pun_vent ";
    $sql.="
	GROUP BY p.tb_producto_id, pr.tb_presentacion_id, u.tb_unidad_id
	ORDER BY numero DESC, ct.tb_catalogo_mul DESC
	LIMIT 0,$filas ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function total_ope($fec1,$fec2,$cat_id,$est,$emp_id){
        $sql="SELECT SUM(dt.tb_ventadetalle_can*dt.tb_ventadetalle_preuni) as total
	FROM tb_producto p
	INNER JOIN tb_presentacion pr ON p.tb_producto_id = pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id = ct.tb_presentacion_id
	INNER JOIN tb_ventadetalle dt ON ct.tb_catalogo_id = dt.tb_catalogo_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ = u.tb_unidad_id
	INNER JOIN tb_venta op ON dt.tb_venta_id=op.tb_venta_id
	WHERE op.tb_empresa_id = $emp_id
	AND tb_venta_fec BETWEEN '$fec1' AND '$fec2'
	AND ct.tb_catalogo_id = $cat_id
    AND tb_venta_est LIKE '$est'";

       // print $sql;
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>