<?php
require_once ("../../config/Cado.php");
require_once("../guiapagocontrol/cGuiapago.php");
$oGuiapago = new cGuiapago();
require_once("../formatos/formato.php");
require_once("../formatos/fechas.php");

$numdia=restaFechas($_POST['fecven'],$_POST['fecpag']);
$tas=0.04;
$int=$_POST['imppagbas']*$numdia*$tas/100;

$calres=$_POST['imppagbas']+$int;
//$calres=round($calres, 0);//redondear comun
$calres=ceil($calres);//redondear hacia arriba
//$calres=floor($calres);//redondear hacia abajo


?>
<script type="text/javascript">

$(function() {

	<?php if($_POST['guipagtip_id']==1){?>
		$('#txt_guipag_imppag').autoNumericSet(<?php echo $calres?>);
	<?php }?>

	<?php if($_POST['guipagtip_id']==3){?>
		$('#txt_guipag_rusimppag').autoNumericSet(<?php echo $calres?>);
	<?php }?>

});
</script>
<br>
<?php 
$int=formato_money($int);
$calres=formato_money($calres);
?>
<table border="0" cellspacing="0" cellpadding="1" >
    <tr>
    	<td colspan="2">CÁLCULO DE INTERESES</td>
    </tr>
    <tr>
      <td valign="middle"><label for="txt_guipag_numdia">N°. de Días:</label></td>
      <td><input type="text" name="txt_guipag_numdia" id="txt_guipag_numdia" maxlength="10" size="10" style="font-size:11pt; text-align:right;" value="<?php echo $numdia?>" readonly /></td>
    </tr>
    <tr>
      <td valign="middle"><label for="txt_guipag_tas">Tasa:</label></td>
      <td><input type="text" name="txt_guipag_tas" id="txt_guipag_tas" maxlength="10" size="10" style="font-size:11pt; text-align:right;" value="<?php echo $tas?>" readonly />% Diario</td>
    </tr>
    <tr>
      <td valign="middle"><label for="txt_guipag_int">Intereses:</label></td>
      <td><input type="text" name="txt_guipag_int" id="txt_guipag_int" maxlength="10" size="10" style="font-size:11pt; text-align:right;" class="moneda" value="<?php echo $int?>" readonly /></td>
    </tr>
    <tr>
      <td valign="middle"><label for="txt_guipag_monact">Monto Actualizado a Pagar:</label></td>
      <td><input type="text" name="txt_guipag_monact" id="txt_guipag_monact" maxlength="10" size="10" style="font-size:11pt; text-align:right;" value="<?php echo $calres?>" readonly /></td>
    </tr>
</table>