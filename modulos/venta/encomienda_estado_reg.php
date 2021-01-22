<?php
session_start();
require_once ("../../config/Cado.php");
require_once("../venta/cVenta.php");
$oVenta = new cVenta();

if($_POST['action']=="actualizar_estado")
{
	if(!empty($_POST['enc_id']))
	{
        $ees=$oVenta->mostrar_estado_enc($_POST['enc_id'],$_POST['clave']);
        $nro_rows = mysql_num_rows($ees);

        $clave=$_SESSION['usuario_clave'];

        if ($nro_rows>0){
            $dts=$oVenta->modificar_estado_enc($_POST['enc_id'],$_POST['clave']);
            $dt = mysql_fetch_array($dts);
            mysql_free_result($dts);
            $data['enc_msj']='Se actualizo estado correctamente.';
        }

        else if(md5($_POST['clave'])== $clave &&  $_SESSION['usuario_grupo']==2){
            $dts=$oVenta->modificar_estadoadmin_enc($_POST['enc_id'],$clave);
            $dt = mysql_fetch_array($dts);
            mysql_free_result($dts);
            $data['enc_msj']='Se actualizo estado correctamente, con clave del administrador.';
        }
        else{
            $data['enc_msj']='Clave incorrecta.';
        }

		echo json_encode($data);
	}
	else
	{
		echo 'Intentelo nuevamente';
	}
}

?>