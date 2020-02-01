<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cUsuario.php");
$oUsuario = new cUsuario();

?>
<option value="">-</option>
<?php
$dts=$oUsuario->mostrar_vendedor('Vendedor','',0,$_SESSION['empresa_id']);
$dt_users=$oUsuario->mostrarUno($_SESSION['usuario_id']);
$dt_user = mysql_fetch_array($dt_users);
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_usuario_id']?>" <?php if($dt['tb_usuario_id']==$_POST['use_id'])echo 'selected'?>><?php echo $dt['tb_usuario_apepat'].' '.$dt['tb_usuario_apemat'].' '.$dt['tb_usuario_nom']?></option>
    <?php
}
?>
<option value="<?php echo $dt_user['tb_usuario_id']?>" <?php if($dt_user['tb_usuario_id']==$_POST['use_id'])echo 'selected'?>><?php echo $dt_user['tb_usuario_apepat'].' '.$dt_user['tb_usuario_apemat'].' '.$dt_user['tb_usuario_nom']?></option>
<?php
    mysql_free_result($dts);
?>