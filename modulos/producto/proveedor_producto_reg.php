<?php
require_once ("../../config/Cado.php");
require_once("cProductoproveedor.php");
$oProductoproveedor = new cProductoproveedor();
require_once("../formatos/formato.php");

if($_POST['action_proveedor_producto']=="insertar"){
    if(!empty($_POST['hdd_com_prov_id']))
    {
        $oProductoproveedor->insertar_producto_proveedor(
            $_POST['hdd_com_prod_id'],
            $_POST['hdd_com_prov_id'],
            moneda_mysql($_POST['txt_cat_min']),
            moneda_mysql($_POST['txt_desc_prov']),
            fecha_mysql($_POST['txt_fecha_ini']),
            fecha_mysql($_POST['txt_fecha_fin'])
        );

        echo 'Se registró correctamente.';
    }
    else{
        echo 'Intentelo nuevamente.';
    }
}


if($_POST['action_proveedor_producto']=="eliminar")
{
    if(!empty($_POST['id']))
    {
        $oProductoproveedor->eliminar($_POST['id']);
        echo 'Se eliminó correctamente.';
    }
    else
    {
        echo 'Intentelo nuevamente.';
    }
}
?>