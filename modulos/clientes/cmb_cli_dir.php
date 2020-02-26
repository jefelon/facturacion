<?php
require_once ("../../config/Cado.php");
require_once ("cCliente.php");
$oCliente = new cCliente();

?>
<!--<option value="">-</option>-->
<?php
$dts=$oCliente->mostrarDireccionesTodos($_POST['cli_id']);
while($dt = mysql_fetch_array($dts))
{
	?>
	<option value="<?php echo $dt['tb_clientedireccion_dir']?>"><?php echo $dt['tb_clientedireccion_dir']?></option>
    <?php
}
mysql_free_result($dts);
?>