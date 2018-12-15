<?php
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();

require_once ("../../modulos/menu/acceso.php");

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
				$_SESSION['autentificado']		= "SI";
			
				$_SESSION['usuario_id']			=$dt['tb_cliente_id'];
				//$_SESSION['usuario_nombre']		=$dt['tb_usuario_apepat']." ".$dt['tb_usuario_apemat']." ".$dt['tb_usuario_nom'];
				
				$_SESSION['usuario_empresa_id']	=$dt['tb_empresa_id'];
				
				//datos empresa sesión
				$_SESSION['empresa_id']			=$dt['tb_empresa_id'];
				$_SESSION['empresa_nombre']		=$dt['tb_empresa_razsoc'];
			
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