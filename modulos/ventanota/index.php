<?php
session_start();
/**

 */
if($_SESSION['usuariogrupo_id']==2)require('../ventanota/venta_vista_adm.php');
if($_SESSION['usuariogrupo_id']==3)require('../ventanota/venta_vista.php');

?>