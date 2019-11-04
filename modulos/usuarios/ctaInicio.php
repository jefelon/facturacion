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
	$result = $oUsuario->acceso($usuario,$password);
	$fila = mysql_fetch_array($result);

	if($fila['tb_usuario_id'] !="" and $fila['tb_usuario_id'] !=0)
	{
		//datos de usuario autenticado correctamente
		$dts=$oUsuario->registroAcceso($fila['tb_usuario_id']);
		$dt = mysql_fetch_array($dts);
		//verificar si esta bloqueado
		
		if($dt['tb_usuario_blo']==1){
			header("Location: login.php?errorbloqueo=1&usuario=$usuario");
		}
		else
		{
			//registro ultima visita
			$oUsuario->modificarUltimaVisita($fila['tb_usuario_id']);
			
			//datos de usuario
			session_start();
				$_SESSION['autentificado']		= "SI";
			
				$_SESSION['usuario_id']			=$dt['tb_usuario_id'];
				$_SESSION['usuario_nombre']		=$dt['tb_usuario_apepat']." ".$dt['tb_usuario_apemat']." ".$dt['tb_usuario_nom'];
				
				$_SESSION['usuariogrupo_id']	=$dt['tb_usuariogrupo_id'];
				$_SESSION['usuariogrupo_nombre']=$dt['tb_usuariogrupo_nom'];
				
				$_SESSION['usuario_empresa_id']	=$dt['tb_empresa_id'];
				
				//datos empresa sesión
				$_SESSION['empresa_id']			=$dt['tb_empresa_id'];
				$_SESSION['empresa_ruc']		=$dt['tb_empresa_ruc'];
				$_SESSION['empresa_razsoc']     =$dt['tb_empresa_razsoc'];
				$_SESSION['empresa_nomcom']     =$dt['tb_empresa_nomcom'];

                $_SESSION['empresa_certificado']  =$dt['tb_empresa_certificado'];
                $_SESSION['empresa_clave_certificado']  =$dt['tb_empresa_clave_certificado'];
                $_SESSION['empresa_usuario_sunat']=$dt['tb_empresa_usuario_sunat'];
                $_SESSION['empresa_clave_sunat']  =$dt['tb_empresa_clave_sunat'];
                $_SESSION['empresa_iddistrito']   =$dt['tb_empresa_iddistrito'];
                $_SESSION['empresa_subdivision']  =$dt['tb_empresa_subdivision'];
                $_SESSION['empresa_departamento'] =$dt['tb_empresa_departamento'];
                $_SESSION['empresa_provincia']    =$dt['tb_empresa_provincia'];
                $_SESSION['empresa_distrito']     =$dt['tb_empresa_distrito'];
                $_SESSION['empresa_direccion']     =$dt['tb_empresa_dir'];

			$url=ir_principal($dt['tb_usuariogrupo_id']);
			header("Location: $url");
		}
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