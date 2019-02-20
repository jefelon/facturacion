<?php
class cCatalogo
{
    function filtrar($nom,$codbar,$est,$alm_id, $limit)
    {
        $sql="SELECT * 
		FROM tb_producto p
		INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
		INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
		INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
		INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
		INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id 
		LEFT JOIN tb_stock s ON pr.tb_presentacion_id=s.tb_presentacion_id
		WHERE ct.tb_catalogo_verven=1
		";

        if($nom!="") $sql .= " AND tb_producto_nom LIKE '$nom' ";
        if($codbar!="") $sql .= " AND tb_presentacion_cod = '$codbar' ";
        if($est!="") $sql .= " AND tb_producto_est = '$est' ";
        if($alm_id>0)$sql.=" AND s.tb_almacen_id = $alm_id ";

        //$sql.=" ORDER BY tb_unidad_tip, tb_producto_nom ";
        $sql.=" GROUP BY tb_producto_nom ";
        if($limit>0)$sql.=" LIMIT 0,$limit ";
        //echo $sql;exit;
        print $sql;
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }


    function filtrar_unidades($nom,$codbar,$est,$alm_id, $limit)
    {
        $sql="SELECT * 
	FROM tb_producto p
	INNER JOIN tb_categoria c ON p.tb_categoria_id=c.tb_categoria_id
	INNER JOIN tb_marca m ON p.tb_marca_id=m.tb_marca_id
	INNER JOIN tb_presentacion pr ON p.tb_producto_id=pr.tb_producto_id
	INNER JOIN tb_catalogo ct ON pr.tb_presentacion_id=ct.tb_presentacion_id
	INNER JOIN tb_unidad u ON ct.tb_unidad_id_equ=u.tb_unidad_id
	WHERE ct.tb_catalogo_verven=1
	AND tb_producto_est LIKE '%$est%' ";

        if($nom!="")$sql.=" AND tb_producto_nom LIKE '%$nom%' ";
        $sql.=" ORDER BY tb_producto_nom ";

        if($limit!="")$sql.=" LIMIT 0,$limit ";
        //echo $sql;exit;
//        print $sql;
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>