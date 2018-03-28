<?php
session_start();
/**

 */
if($_SESSION['usuariogrupo_id']==2)require('cotizacion_vista_adm.php');
if($_SESSION['usuariogrupo_id']==3)require('cotizacion_vista.php');

?>