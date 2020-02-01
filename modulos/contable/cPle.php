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
        $sql="SELECT tb_compra_id,DATE_FORMAT(c.tb_compra_reg,'%d/%m/%Y') AS  tb_compra_reg, DATE_FORMAT(c.tb_compra_fec,'%d/%m/%Y') AS  tb_compra_fec, DATE_FORMAT(c.tb_compra_fecven,'%d/%m/%Y') AS tb_compra_fecven, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_compra_numdoc,p.tb_proveedor_tip,
              tb_proveedor_doc,tb_proveedor_nom,tb_compra_gra,tb_compra_igv,tb_compra_exo,tb_compra_isc,tb_compra_tot,tb_compra_tipcam,
              m.cs_tipomoneda_cod, (SELECT tb_tipocambio_dolsunv FROM tb_tipocambio tcm WHERE tcm.tb_tipocambio_fec = tb_compra_fec) as tc,
              DATE_FORMAT(c.tb_compra_fec_nota,'%d/%m/%Y') AS tb_compra_fec_nota,c.tb_compra_ser_nota,c.tb_compra_num_nota,tb_compra_baseimp_tip,tb_compra_valven
              
        	FROM tb_compra c
            LEFT JOIN cs_tipodocumento td ON c.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
            INNER JOIN cs_tipomoneda m ON c.tb_compra_mon=m.cs_tipomoneda_id
            WHERE YEAR(c.tb_compra_reg) = '$anio' AND MONTH(c.tb_compra_reg) ='$mes' AND td.cs_tipodocumento_cod NOT IN ('91','97','98') AND c.tb_compra_est NOT IN ('ANULADA')
            ORDER BY tb_compra_reg ASC 
        ";
        //if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
            $oCado = new Cado();
            $rst=$oCado->ejecute_sql($sql);
            return $rst;
    }
    function mostrar_comprasnd($anio,$mes){
        $sql="SELECT tb_compra_id,DATE_FORMAT(c.tb_compra_reg,'%d/%m/%Y') AS  tb_compra_reg, DATE_FORMAT(c.tb_compra_fec,'%d/%m/%Y') AS  tb_compra_fec, DATE_FORMAT(c.tb_compra_fecven,'%d/%m/%Y') AS tb_compra_fecven, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_compra_numdoc,p.tb_proveedor_tip,
              tb_proveedor_doc,tb_proveedor_nom,tb_compra_gra,tb_compra_igv,tb_compra_exo,tb_compra_isc,tb_compra_tot,tb_compra_tipcam,
              m.cs_tipomoneda_cod, (SELECT tb_tipocambio_dolsunv FROM tb_tipocambio tcm WHERE tcm.tb_tipocambio_fec = tb_compra_fec) as tc,
              DATE_FORMAT(c.tb_compra_fec_nota,'%d/%m/%Y') AS tb_compra_fec_nota,c.tb_compra_ser_nota,c.tb_compra_num_nota,tr.tb_tiporenta_cod
              
        	FROM tb_compra c
            LEFT JOIN cs_tipodocumento td ON c.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
            LEFT JOIN cs_codigopais cp ON p.cs_codigopais_id=cp.cs_codigopais_id
            LEFT JOIN tb_tiporenta tr ON c.tb_tiporenta_id=tr.tb_tiporenta_id
            INNER JOIN cs_tipomoneda m ON c.tb_compra_mon=m.cs_tipomoneda_id
            WHERE YEAR(c.tb_compra_reg) = '$anio' AND MONTH(c.tb_compra_reg) ='$mes' AND td.cs_tipodocumento_cod IN ('00','91','97','98') AND c.tb_compra_est NOT IN ('ANULADA')
            ORDER BY tb_compra_reg ASC 
        ";
        //if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
    function mostrar_ventas($anio,$mes){
        $sql="SELECT tb_venta_id,DATE_FORMAT(v.tb_venta_reg,'%d/%m/%Y') AS  tb_venta_reg, DATE_FORMAT(tb_venta_fec,'%d/%m/%Y') AS tb_venta_fec, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              tb_cliente_doc,tb_cliente_nom,tb_venta_gra,tb_venta_des,tb_venta_igv,tb_venta_exo,tb_venta_ina,tb_venta_isc,tb_venta_otrcar,tb_venta_tot,
              m.cs_tipomoneda_cod, (SELECT tb_tipocambio_dolsunv FROM tb_tipocambio tc WHERE tc.tb_tipocambio_fec = tb_venta_fec) as tc,
             '' as tb_venta_vennumdoc,'' as tb_venta_ventipdoc, tb_venta_est
              
        	FROM tb_venta v
            LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
            INNER JOIN tb_documento td2 ON v.tb_documento_id=td2.tb_documento_id
            INNER JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
            INNER JOIN cs_tipomoneda m ON v.cs_tipomoneda_id=m.cs_tipomoneda_id 
            WHERE YEAR(v.tb_venta_reg) = '$anio' AND MONTH(v.tb_venta_reg) ='$mes' AND cs_tipodocumento_cod <> ''
            
        UNION ALL 
        
              SELECT tb_venta_id,DATE_FORMAT(nc.tb_venta_reg,'%d/%m/%Y') AS  tb_venta_reg,DATE_FORMAT(tb_venta_fec,'%d/%m/%Y') AS tb_venta_fec,td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              c.tb_cliente_doc,c.tb_cliente_nom,tb_venta_gra,'' as tb_venta_des, tb_venta_igv,tb_venta_exo,tb_venta_ina,tb_venta_isc,tb_venta_otrcar,tb_venta_tot,
              m.cs_tipomoneda_cod,(SELECT tb_tipocambio_dolsunv FROM tb_tipocambio tc WHERE tc.tb_tipocambio_fec = tb_venta_fec) as tc,
              tb_venta_vennumdoc, tb_venta_ventipdoc, tb_venta_est
              
            FROM tb_notacredito nc
            LEFT JOIN cs_tipodocumento td ON nc.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON nc.tb_cliente_id=c.tb_cliente_id
            INNER JOIN cs_tipomoneda m ON nc.cs_tipomoneda_id=m.cs_tipomoneda_id
            WHERE YEAR(nc.tb_venta_reg) = '$anio'  AND MONTH(nc.tb_venta_reg) ='$mes'
         
        UNION ALL   
         
        SELECT tb_venta_id,DATE_FORMAT(nd.tb_venta_reg,'%d/%m/%Y') AS  tb_venta_reg,DATE_FORMAT(tb_venta_fec,'%d/%m/%Y') AS tb_venta_fec,td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              c.tb_cliente_doc,c.tb_cliente_nom,tb_venta_gra,'' as tb_venta_des, tb_venta_igv,tb_venta_exo,tb_venta_ina,tb_venta_isc,tb_venta_otrcar,tb_venta_tot,
              m.cs_tipomoneda_cod,(SELECT tb_tipocambio_dolsunv FROM tb_tipocambio tc WHERE tc.tb_tipocambio_fec = tb_venta_fec) as tc,
              tb_venta_vennumdoc, tb_venta_ventipdoc, tb_venta_est
              
            FROM tb_notadebito nd
            LEFT JOIN cs_tipodocumento td ON nd.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON nd.tb_cliente_id=c.tb_cliente_id
            INNER JOIN cs_tipomoneda m ON nd.cs_tipomoneda_id=m.cs_tipomoneda_id
            WHERE YEAR(nd.tb_venta_reg) = '$anio'  AND MONTH(nd.tb_venta_reg) ='$mes'
            
            ORDER BY tb_venta_reg ASC 
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
    function mostrar_doc_mod($numdoc,$tipo){
        $sql="SELECT DATE_FORMAT(tb_venta_fec,'%d/%m/%Y') AS tb_venta_fec,cs_tipodocumento_cod,tb_venta_ser, tb_venta_num
        FROM tb_venta v
        LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
        WHERE v.tb_venta_numdoc = '$numdoc' AND td.cs_tipodocumento_cod = '$tipo' ";

        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>