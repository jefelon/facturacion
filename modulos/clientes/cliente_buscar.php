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

if(!empty($_POST['txt_cli_cod']))
{
    $cst1 = $oCliente->busca_cliente_cod($_POST['txt_cli_cod']);
    $rst1= mysql_num_rows($cst1);

    if($rst1>0)
    {
        $dt = mysql_fetch_array($cst1);
        $cli_id=$dt['tb_cliente_id'];
        $cli_tip=$dt['tb_cliente_tip'];
        $cli_doc=$dt['tb_cliente_doc'];
        $cli_nombre=$dt['tb_cliente_nom'];
        $cli_dir=$dt['tb_cliente_dir'];


        mysql_free_result($cst1);

        $data['cli_id']=$cli_id;
        $data['cli_tip']=$cli_tip;
        $data['cli_doc']=$cli_doc;
        $data['cli_nombre']=$cli_nombre;
        $data['cli_dir']=$cli_dir;
        $data['msj']="Encontrado";

        echo json_encode($data);
    }

}
else
{
    echo 'Cliente no registrado, Intentelo nuevamente.';
}

?>