<?php
session_start();
require_once ("../../config/Cado.php");
//require_once ("../puntoventa/cPuntoventa.php");
//$oPuntoventa = new cPuntoventa();
require_once ("../form/cForm.php");
$oForm = new cForm();
	$y=date('Y');
	$m=date('m');
	$d=date('d');
	
	$fec1="$d-$m-$y";
	
	//$d=ultimoDia($m,$y);
	$fec2="$d-$m-$y";
	//$fec2="$d-$m-$y";
	
//caja
/*
if($_SESSION['puntoventa_id']>0)
{
	$dts=$oPuntoventa->mostrarUno($_SESSION['puntoventa_id']);
	$dt = mysql_fetch_array($dts);
		$caj_id		=$dt['tb_caja_id'];
	mysql_free_result($dts);
}
*/
$punven_id=$_SESSION['puntoventa_id'];
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

function cmb_fil_punven_id()
{	
	$.ajax({
		type: "POST",
		url: "../puntoventa/cmb_punven_id.php",
		async:false,
		dataType: "html",                      
		data: ({
			punven_id: "<?php echo $punven_id?>"
		}),
		beforeSend: function() {
			$('#cmb_fil_punven_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_punven_id').html(html);
		}
	});
}

function cmb_fil_doc_id()
{	
	$.ajax({
		type: "POST",
		url: "../documento/cmb_doc_id.php",
		async:true,
		dataType: "html",                      
		data: ({
			doc_tip:	'2',
			doc_id: '<?php echo $doc_id?>',
			vista:	'<?php //echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_fil_doc_id').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_doc_id').html(html);
		}
	});
}

$(function() {
	
	cmb_fil_punven_id(<?php echo $punven_id?>);
	
	$("#cmb_fil_punven_id").change(function(){
		talonario_tabla();
	});
	
});
</script>
<style>
/*label {
	display:inline-block;
    width: 150px; 
}*/
</style>
<form name="for_fil_tal" id="for_fil_tal" target="_blank" action="<?php echo $_POST['act']?>" method="post">
<fieldset><legend>Filtro de Caja</legend>
  <label for="cmb_fil_punven_id">Punto de Venta:</label>
    <select name="cmb_fil_punven_id" id="cmb_fil_punven_id">
    </select>
	<a href="#" onClick="talonario_tabla();" id="btn_filtrar">Filtrar</a>
    <a href="#" onClick="talonario_filtro();" id="btn_resfil">Restablecer</a>
</fieldset>
</form>