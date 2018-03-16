<?php
require_once ("../../config/Cado.php");
require_once ("../declaracion/cDeclaracion.php");
$oDeclaracion = new cDeclaracion();
require_once("../formatos/formato.php");

//CONSULTA CRONOGRAMA FECHA

if($_POST['guitip']==1)
{
  $cro_id=1; // por defecto el cronograma de vencimiento de igv

  if($_POST['pag']=='4')$cro_id=28; // cronograma fraccionamiento
}
else
{
  $cro_id=1; // por defecto el cronograma de vencimiento de igv
}


$rws=$oDeclaracion->cronograma_fecha($cro_id,$_POST['eje_id'],$_POST['per_id'],$_POST['cli_ultdig']);
$rw = mysql_fetch_array($rws);
  $crofec_id  =$rw['tb_cronogramafecha_id'];
  $crofec_fec1=$rw['tb_cronogramafecha_fec1'];
mysql_free_result($rws);

//$data['fecven']=mostrarFecha($crofec_fec1);
//$data['fecpag']=mostrarFecha($crofec_fec1);
$fecven=mostrarFecha($crofec_fec1);
$fecpag=mostrarFecha($crofec_fec1);
//$data['fecpag']=$_POST['pag'];

//echo json_encode($data);
?>
<script type="text/javascript">
$(function() {
	<?php if($crofec_fec1==""){?>
		$("#txt_guipag_fecven").datepicker({
			minDate: "<?php echo $fecven;?>", 
			//maxDate:"+0D",
			yearRange: 'c-1:c+1',
			changeMonth: true,
			changeYear: true,
			dateFormat: 'dd-mm-yy',
			//altField: fecha,
			//altFormat: 'yy-mm-dd',
			showOn: "button",
			buttonImage: "../../images/calendar.gif",
			buttonImageOnly: true,
			onSelect: function( selectedDate ) {
				calculo();
				$("#txt_guipag_fecpag").val($("#txt_guipag_fecven").val());
			}
		});
	<?php }?>
});
</script>
<table border="0" cellspacing="0" cellpadding="1" >
  	<tr>
		<td><label for="txt_guipag_fecven">Fecha de Vencimiento:</label></td>
      	<td><input name="txt_guipag_fecven" type="text" class="fecha" id="txt_guipag_fecven" value="<?php echo $fecven?>" size="10" maxlength="10" readonly></td>
    </tr>
    <tr>
		<td><label for="txt_guipag_fecpag">Fecha de Act/Pago:</label></td>
      	<td><input name="txt_guipag_fecpag" type="text" class="fecha" id="txt_guipag_fecpag" value="<?php echo $fecpag?>" size="10" maxlength="10" readonly><?php if($_POST['action']=='insertar_actualizacion')echo "<span style='color:red;'><= Seleccione Fecha</span>";?></td>
    </tr>

    <tr>
      <td valign="middle"><label for="txt_guipag_imppagbas">Importe Sin Intereses:</label></td>
      <td><input type="text" name="txt_guipag_imppagbas" id="txt_guipag_imppagbas" maxlength="10" size="10" style="font-size:11pt; text-align:right;" value="<?php echo $imppagbas?>" readonly /></td>
    </tr>

</table>