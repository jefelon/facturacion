<?php
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();

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
	$result = $oUsuario->acceso($usuario,$password);
	$fila = mysql_fetch_array($result);

	if($fila['tb_cliente_id'] !="" and $fila['tb_cliente_id'] !=0)
	{
		//datos de usuario autenticado correctamente
		$dts=$oUsuario->registroAcceso($fila['tb_cliente_id']);
		$dt = mysql_fetch_array($dts);
		//verificar si esta bloqueado

			//registro ultima visita
			$oUsuario->modificarUltimaVisita($fila['tb_cliente_id']);
			
			//datos de usuario
			session_start();
				$_SESSION['autentificado2']		= "SI";
			
				$_SESSION['cliente_id']			=$dt['tb_cliente_id'];
                $_SESSION['cliente_cui']			=$dt['tb_cliente_cui'];
				$_SESSION['cliente_nombre']		=$dt['tb_usuario_apepat']." ".$dt['tb_usuario_apemat']." ".$dt['tb_usuario_nom'];
				
				//datos empresa sesión
				$_SESSION['cliente_empresa_id']			=$dt['tb_empresa_id'];
			
			$url="../venta/";
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