<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 08/09/2018
 * Time: 19:19
 */
class cPle
{

    function mostrar_filtro($anio,$documento_id){
        $sql="SELECT tb_venta_fec, td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              tb_cliente_doc,tb_cliente_nom,tb_venta_gra
              
        	FROM tb_venta v
            LEFT JOIN cs_tipodocumento td ON v.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON v.tb_cliente_id=c.tb_cliente_id
            
        UNION ALL 
        
              SELECT tb_venta_fec,td.cs_tipodocumento_cod,td.cs_tipodocumento_des,tb_venta_ser,tb_venta_num,c.tb_cliente_tip,
              c.tb_cliente_doc,c.tb_cliente_nom,tb_venta_gra
              
            FROM tb_notacredito nc
            LEFT JOIN cs_tipodocumento td ON nc.cs_tipodocumento_id=td.cs_tipodocumento_id
            LEFT JOIN tb_cliente c ON nc.tb_cliente_id=c.tb_cliente_id
            ORDER BY tb_venta_fec ASC 
        ";
//            if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
            $oCado = new Cado();
            $rst=$oCado->ejecute_sql($sql);
            return $rst;
    }
}
?>