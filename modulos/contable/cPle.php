<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 08/09/2018
 * Time: 19:19
 */
class cPle
{

    function mostrar_compras($anio,$mes){
        $sql="SELECT DATE_FORMAT(tb_compra_fec,'%d/%m/%Y') AS  tb_compra_fec, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_compra_numdoc,p.tb_proveedor_tip,
              tb_proveedor_doc,tb_proveedor_nom,tb_compra_gra,tb_compra_igv,tb_compra_exo,tb_compra_isc,tb_compra_tot,tb_compra_tipcam,
              m.cs_tipomoneda_cod, (SELECT tb_tipocambio_dolsun FROM tb_tipocambio tcm WHERE tcm.tb_tipocambio_fec = tb_compra_fec) as tc,
              DATE_FORMAT(c.tb_compra_fec_nota,'%d/%m/%Y') AS tb_compra_fec_nota,c.tb_compra_ser_nota,c.tb_compra_num_nota
              
        	FROM tb_compra c
            LEFT JOIN cs_tipodocumento td ON c.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
            INNER JOIN cs_tipomoneda m ON c.tb_compra_mon=m.cs_tipomoneda_id
            WHERE YEAR(c.tb_compra_fec) = '$anio' AND MONTH(c.tb_compra_fec) ='$mes' AND td.cs_tipodocumento_cod NOT IN ('91','97','98')
            ORDER BY tb_compra_fec ASC 
        ";
        //if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
            $oCado = new Cado();
            $rst=$oCado->ejecute_sql($sql);
            return $rst;
    }
    function mostrar_ventas($anio,$mes){
        $sql="SELECT DATE_FORMAT(tb_venta_fec,'%d/%m/%Y') AS tb_venta_fec, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              tb_cliente_doc,tb_cliente_nom,tb_venta_gra,tb_venta_des,tb_venta_igv,tb_venta_exo,tb_venta_ina,tb_venta_isc,tb_venta_otrcar,tb_venta_tot,
              m.cs_tipomoneda_cod, (SELECT tb_tipocambio_dolsun FROM tb_tipocambio tc WHERE tc.tb_tipocambio_fec = tb_venta_fec) as tc,
             '' as tb_venta_vennumdoc,'' as tb_venta_ventipdoc
              
        	FROM tb_venta v
            LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
            INNER JOIN cs_tipomoneda m ON v.cs_tipomoneda_id=m.cs_tipomoneda_id
            WHERE YEAR(v.tb_venta_fec) = '$anio' AND MONTH(v.tb_venta_fec) ='$mes'
            
        UNION ALL 
        
              SELECT DATE_FORMAT(tb_venta_fec,'%d/%m/%Y') AS tb_venta_fec,td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              c.tb_cliente_doc,c.tb_cliente_nom,tb_venta_gra,'' as tb_venta_des, tb_venta_igv,tb_venta_exo,tb_venta_ina,tb_venta_isc,tb_venta_otrcar,tb_venta_tot,
              m.cs_tipomoneda_cod,(SELECT tb_tipocambio_dolsun FROM tb_tipocambio tc WHERE tc.tb_tipocambio_fec = tb_venta_fec) as tc,
              tb_venta_vennumdoc, tb_venta_ventipdoc
              
            FROM tb_notacredito nc
            LEFT JOIN cs_tipodocumento td ON nc.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON nc.tb_cliente_id=c.tb_cliente_id
            INNER JOIN cs_tipomoneda m ON nc.cs_tipomoneda_id=m.cs_tipomoneda_id
            WHERE YEAR(nc.tb_venta_fec) = '$anio'  AND MONTH(nc.tb_venta_fec) ='$mes'
            ORDER BY tb_venta_fec ASC 
        ";
//            if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }

    function mostrar_tipo_doc($numdoc){
        $sql="SELECT * 
        FROM tb_compra c
        LEFT JOIN cs_tipodocumento td ON c.cs_tipodocumento_id=td.cs_tipodocumento_id
        WHERE c.tb_compra_numdoc = '$numdoc'";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_fec_doc($numdoc,$tipo){
        $sql="SELECT *
        FROM tb_venta v
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        WHERE v.tb_venta_numdoc = '$numdoc' AND td.cs_tipodocumento_cod = '$tipo' ";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>