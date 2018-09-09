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
        $sql="SELECT * 
        FROM tb_compra ";
            if($documento_id>0)$sql.= " WHERE tb_documento_id = $documento_id ";
            $oCado = new Cado();
            $rst=$oCado->ejecute_sql($sql);
            return $rst;
    }
}
?>