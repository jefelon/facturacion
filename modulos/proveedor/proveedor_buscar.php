<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 05/10/2018
 * Time: 16:14
 */

session_start();
require_once ("../../config/Cado.php");
require_once ("cProveedor.php");
$oProveedor = new cProveedor();

if(!empty($_POST['txt_prov_cod']))
{
    $cst1 = $oProveedor->busca_proveedor_cod($_POST['txt_prov_cod']);
    $rst1= mysql_num_rows($cst1);

    if($rst1>0)
    {
        $dt = mysql_fetch_array($cst1);
        $prov_id=$dt['tb_proveedor_id'];
        $prov_tip=$dt['tb_proveedor_tip'];
        $prov_doc=$dt['tb_proveedor_doc'];
        $prov_nombre=$dt['tb_proveedor_nom'];
        $prov_dir=$dt['tb_proveedor_dir'];
        $prov_tel=$dt['tb_proveedor_tel'];
        $prov_con=$dt['tb_proveedor_con'];
        $prov_ema=$dt['tb_proveedor_ema'];


        mysql_free_result($cst1);

        $data['prov_id']=$prov_id;
        $data['prov_tip']=$prov_tip;
        $data['prov_doc']=$prov_doc;
        $data['prov_nombre']=$prov_nombre;
        $data['prov_dir']=$prov_dir;
        $data['prov_tel']=$prov_tel;
        $data['prov_con']=$prov_con;
        $data['prov_ema']=$prov_ema;
        $data['msj']="Encontrado";

        echo json_encode($data);
    }
    else
    {
        $data['msj']= '';
        echo json_encode($data);
    }

}
else
{
    echo 'Ingrese un código válido';
}

?>