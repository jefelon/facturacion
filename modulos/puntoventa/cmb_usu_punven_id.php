<?php
session_start();
require_once ("../../config/Cado.php");
require_once ("cPuntoventa.php");
$oPuntoventa = new cPuntoventa();

?>
	<option value="">-</option>

<?php
	$dts1=$oPuntoventa->mostrar_puntoventa_por_usuario($_SESSION['usuario_id']);
	while($dt1 = mysql_fetch_array($dts1))
	{
?>
	<option value="<?php echo $dt1['tb_puntoventa_id']?>" <?php if($dt1['tb_puntoventa_id']==$_POST['punven_id'])echo 'selected'?>><?php echo $dt1['tb_empresa_razsoc'].' | '.$dt1['tb_puntoventa_nom']?></option>
<?php
	}
	mysql_free_result($dts1);
?>