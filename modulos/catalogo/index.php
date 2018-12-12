<?php
session_start();
/**

 */
if($_SESSION['usuariogrupo_id']==2)require('catalogo_vista.php');
if($_SESSION['usuariogrupo_id']==3)
{
	if($_SESSION['usuario_id']==8)
	{
		require('catalogo_vista_eje.php');
	}
	else
	{
		require('catalogo_vista_ven.php');
	}
}
if($_SESSION['usuariogrupo_id']==4)require('catalogo_vista_eje.php');

?>