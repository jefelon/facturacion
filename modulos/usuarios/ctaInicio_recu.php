<?php
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();

require_once ("../menu/acceso.php");

$usuario="";
$password="";

$boton = $_POST['btn_ingresar'];
$usuario = $_POST['txt_use'];
$password =$_POST['txt_pas'];

if(empty($usuario))
{
	header("Location: login.php?errorusuario=1");
}
else
{
	if(empty($password))
	{
		header("Location: login.php?errorclave=1&usuario=$usuario");
	}
}

if($usuario!="" and $password!="")
{
	$result = $oUsuario->acceso_recu($usuario,$password);
	$fila = mysql_fetch_array($result);

	if($fila['tb_cliente_id'] !="" and $fila['tb_cliente_id'] !=0)
	{

		//verificar si esta bloqueado
		

			//registro ultima visita
			
			//datos de usuario
			session_start();
				$_SESSION['autentificado']		= "SI";

				$_SESSION['cliente_id']			=$dt['tb_cliente_id'];

			$url=ir_principal(5);
			header("Location: $url");

		//mysql_free_result($dts);
	}	
	else
	{
		header("Location: login.php?erroracceso=1&usuario=$usuario");
		//echo "<html><head></head>"."<body onload=\"javascript:history.back()\">"."</body></html>";
		//exit;
	}
	//mysql_free_result($result);
}
?>