<?php
require_once ("../../config/Cado.php");
require_once ("cTipoperacion.php");
$oTipoperacion = new cTipoperacion();

?>
<option value="">-</option>
<?php
$dts=$oTipoperacion->mostrar_por_tipo($_POST['tip_id'],$_POST['tipope_man']);
while($dt = mysql_fetch_array($dts))
{	
	?>
	<option value="<?php echo $dt['tb_tipoperacion_id']?>" <?php if($dt['tb_tipoperacion_id']==$_POST['tipope_id'])echo 'selected'?>><?php echo $dt['tb_tipoperacion_nom']?></option>
    <?php
}
mysql_free_result($dts);
?>