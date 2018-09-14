<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 08/09/2018
 * Time: 19:19
 */
class cPle
{

    function mostrar_compras($anio){
        $sql="SELECT tb_compra_fec, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_compra_numdoc,p.tb_proveedor_tip,
              tb_proveedor_doc,tb_proveedor_nom,tb_compra_gra,tb_compra_igv,tb_compra_exo,tb_compra_isc,tb_compra_tot,tb_compra_tipcam,
              m.cs_tipomoneda_cod, (SELECT tb_tipocambio_dolsun FROM tb_tipocambio tcm WHERE tcm.tb_tipocambio_fec = tb_compra_fec) as tc
              
        	FROM tb_compra c
            LEFT JOIN cs_tipodocumento td ON c.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_proveedor p ON c.tb_proveedor_id=p.tb_proveedor_id
            INNER JOIN cs_tipomoneda m ON c.tb_compra_mon=m.cs_tipomoneda_id
        ";
//            if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
            $oCado = new Cado();
            $rst=$oCado->ejecute_sql($sql);
            return $rst;
    }
    function mostrar_ventas($anio){
        $sql="SELECT tb_venta_fec, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              tb_cliente_doc,tb_cliente_nom,tb_venta_gra,tb_venta_igv,tb_venta_exo,tb_venta_isc,tb_venta_otrcar,tb_venta_tot,
              m.cs_tipomoneda_cod, (SELECT tb_tipocambio_dolsun FROM tb_tipocambio tc WHERE tc.tb_tipocambio_fec = tb_venta_fec) as tc
              
        	FROM tb_venta v
            LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
            INNER JOIN cs_tipomoneda m ON v.cs_tipomoneda_id=m.cs_tipomoneda_id
            
        UNION ALL 
        
              SELECT tb_venta_fec,td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              c.tb_cliente_doc,c.tb_cliente_nom,tb_venta_gra,tb_venta_igv,tb_venta_exo,tb_venta_isc,tb_venta_otrcar,tb_venta_tot,
              m.cs_tipomoneda_cod,(SELECT tb_tipocambio_dolsun FROM tb_tipocambio tc WHERE tc.tb_tipocambio_fec = tb_venta_fec) as tc
              
            FROM tb_notacredito nc
            LEFT JOIN cs_tipodocumento td ON nc.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON nc.tb_cliente_id=c.tb_cliente_id
            INNER JOIN cs_tipomoneda m ON nc.cs_tipomoneda_id=m.cs_tipomoneda_id
            ORDER BY tb_venta_fec ASC 
        ";
//            if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
        $oCado = new Cado();
        $rst=$oCado->ejecute_sql($sql);
        return $rst;
    }
}
?>