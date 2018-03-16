<?php
session_start();
require_once ("../../config/Cado.php");
require_once("cEntfinanciera.php");
$oEntfinanciera = new cEntfinanciera();

if($_POST['btn_enviar'])
{
	if($_GET['action']=="insertar")
	{
		if(!empty($_POST['txt_des']))
		{
			$oEntfinanciera->insertar($_POST['txt_des']);
			
			if($_GET['vista']=='form'){
				echo '<script type="text/javascript">
					window.opener.location.reload();
					window.close();
					</script>';
			}
			else
			{
				$_SESSION['alerta']=1;
				header("Location: manEntfinanciera.php");
			}
		}
		else
		{
			$_SESSION['alerta']=4;
			header("Location: manEntfinanciera.php");
		}
	}
	
	if($_GET['action']=="editar")
	{
		if(!empty($_POST['txt_des']))
		{
			$oEntfinanciera->modificar($_POST['hdd_id'],$_POST['txt_des']);
			
			if($_GET['vista']=='form'){
				echo '<script type="text/javascript">
					window.opener.location.reload();
					window.close();
					</script>';
			}
			else
			{
				$_SESSION['alerta']=2;
				header("Location: manEntfinanciera.php");
			}
		}
		else
		{
			$_SESSION['alerta']=4;
			header("Location: manEntfinanciera.php");
		}
	}
}

if($_POST['hdd_ide'])
{
	if($_GET['action']=="eliminar")
	{
		$rws=$oEntfinanciera->eliminar($_POST['hdd_ide']);
		$_SESSION['alerta']=3;
		header("Location: manEntfinanciera.php?vista=".$_GET['vista']."");
	}
}
?>