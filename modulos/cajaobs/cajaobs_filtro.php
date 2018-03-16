<?php
session_start();
require_once ("../../config/Cado.php");

$y=date('Y');
$m=date('m');
$d=date('d');

$fec="$d-$m-$y";

//$d=ultimoDia($m,$y);
$fec2="$d-$m-$y";
//$fec2="$d-$m-$y";

$est=1;

$caja_id=$_SESSION['caja_id'];
?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
		text: false
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
		text: false
	});
function cmb_fil_caj_id(ids)
{	
	$.ajax({
		type: "POST",
		url: "../caja/cmb_caj_id.php",
		async:false,
		dataType: "html",                      
		data: ({
			caj_id: ids
		}),
		beforeSend: function() {
			$('#cmb_fil_caj_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_caj_id').html(html);
		}
	});
}	

$("#txt_fil_cajobs_fec").datepicker({
	//minDate: "-1M", 
	//maxDate:"+0D",
	yearRange: 'c-0:c+0',
	changeMonth: true,
	changeYear: true,
	dateFormat: 'dd-mm-yy',
	//altField: fecha,
	//altFormat: 'yy-mm-dd',
	showOn: "button",
	buttonImage: "../../images/calendar.gif",
	buttonImageOnly: true
});

$(function() {

	cmb_fil_caj_id('<?php echo $caja_id?>');

	$("#cmb_fil_caj_id,#txt_fil_cajobs_fec").change(function()
	{
		cajaobs_tabla();
	});
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_cajobs" id="for_fil_cajobs" target="_blank" action="" method="post">
<fieldset><legend>Filtro</legend>
 
    <label for="cmb_fil_caj_id">Caja:</label>
    <select name="cmb_fil_caj_id" id="cmb_fil_caj_id">
    </select>

    <label for="txt_fil_cajobs_fec">Fecha:</label>
    <input name="txt_fil_cajobs_fec" type="text" class="fecha" id="txt_fil_cajobs_fec" value="<?php echo $fec?>" size="10" maxlength="10" readonly>
    
	<a href="#" onClick="cajaobs_tabla()" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="cajaobs_filtro()" id="btn_resfil">Restablecer</a>
</fieldset>
</form>