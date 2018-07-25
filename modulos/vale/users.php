<?php
require_once ("../../config/Cado.php");
require_once ("cVale.php");
$oUsuario = new cUsuario();

$request = trim(strtolower($_REQUEST['txt_use']));
//sleep(2);
usleep(150000);

$valid = 'true';

$dts1=$oUsuario->verificaUsuario(strtolower($request));
while($dt1 = mysql_fetch_array($dts1)){
	if( strtolower($dt1['tb_usuario_use']) == $request ){
		$valid = 'false';
	}
}
mysql_free_result($dts1);

echo $valid;
?>