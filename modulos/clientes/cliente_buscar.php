<?php
/**
 * Created by PhpStorm.
 * User: AZETASOFT
 * Date: 05/10/2018
 * Time: 16:14
 */

session_start();
require_once ("../../config/Cado.php");
require_once ("cCliente.php");
$oCliente = new cCliente();

if(!empty($_POST['txt_cli_doc']))
{
    $cst1 = $oCliente->verifica_cliente_doc($_POST['txt_cli_doc'],0);
    $rst1= mysql_num_rows($cst1);

    if($rst1>0)
    {
        $dt = mysql_fetch_array($cst1);
        $cli_id=$dt['tb_cliente_id'];
        $cli_nombre=$dt['tb_cliente_nom'];


        mysql_free_result($cst1);

        $data['cli_id']=$cli_id;
        $data['cli_nombre']=$cli_nombre;

        echo json_encode($data);
    }

}
else
{
    echo 'Cliente no registrado, Intentelo nuevamente.';
}

?>