<?php

session_start();
include("../../libreriasphp/captcha/simple-php-captcha.php");
$_SESSION['captcha'] = simple_php_captcha();

$y=date('Y');
$m=date('m');
$d=date('d');

$fec1="$d-$m-$y";

if(isset($_POST['fec'])){
	$fec1 = $_POST['fec'];
}

?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
	});
	$('#btn_resfil').button({
		icons: {primary: "ui-icon-arrowrefresh-1-w"},
	});

function test(){
	if($("#txt_fil_cap").val().toUpperCase()=='<?php echo strtoupper($_SESSION['captcha']['code']) ?>' ){
		venta_tabla();
	}else{
		venta_filtro(2,$('#cmb_fil_ven_doc').val(),$('#txt_fil_ser').val(),$('#txt_fil_cor').val(),$('#txt_fil_ven_fec1').val(),$('#txt_fil_mon').val());
	}

}

function cmb_ven_doc(ids)
{
	$.ajax({
		type: "POST",
		url: "../../modulos/documento/cmb_doc_id.php",
		async:true,
		dataType: "html",
		data: ({
			doc_tip:	'2',
			doc_id: ids,
			vista:	'<?php echo $_POST['action']?>'
		}),
		beforeSend: function() {
			$('#cmb_fil_ven_doc').html('<option value="">Cargando...</option>');
        },
		success: function(html){
			$('#cmb_fil_ven_doc').html(html);
		}
	});
}
$(function() {

	$('#txt_fil_cap').change(function(e) {
        $('#msg_cap').html("&nbsp;");
    });

	var dates = $( "#txt_fil_ven_fec1" ).datepicker({
		//defaultDate: "+1w",
		maxDate:"+0D",
		changeMonth: true,
		numberOfMonths: 1,
		dateFormat: 'dd-mm-yy',
		onSelect: function( selectedDate ) {
			var option = this.id == "txt_fil_ven_fec1" ? "minDate" : "maxDate",
				instance = $( this ).data( "datepicker" ),
				date = $.datepicker.parseDate(
					instance.settings.dateFormat ||
					$.datepicker._defaults.dateFormat,
					selectedDate, instance.settings );
			dates.not( this ).datepicker( "option", option, date );
		}
	});

	//cmb_fil_cli_id();

	cmb_ven_doc('<?php echo $_POST['doc']?>');

	$('#cmb_fil_ven_doc').change(function(e) {
        venta_tabla();
    });

    $("#txt_fil_ser").keypress(function (key) {
        if ((key.charCode < 97 || key.charCode > 122)//letras mayusculas
            && (key.charCode < 65 || key.charCode > 90) //letras minusculas
            && (key.charCode < 48 || key.charCode > 57)
            && (key.charCode != 45) //retroceso
            ){
        	return false;
        }
    });

     $("#txt_fil_cor").keypress(function (key) {
     	 if ((key.charCode < 48 || key.charCode > 57) && (key.charCode != 45)){
        	return false;
        }
    });

});
</script>
<style>
#for_fil_ven label {
	display:inline-block;
    width: 120px;
    padding: 5px;
}
#for_fil_ven input[type="text"]{
	width: 120px;
}
#for_fil_ven select{
	width: 122px;
}
</style>
<form name="for_fil_ven" id="for_fil_ven" target="_blank" action="venta_reporte.php" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla.php">
<fieldset><legend>Buscar por Documentos</legend>

<center>

    <label for="cmb_fil_ven_doc" align="left">Tipo de Documento:</label>
    <select name="cmb_fil_ven_doc" id="cmb_fil_ven_doc"></select>

    <br/>

    <label for="txt_fil_ser" align="left">Serie:</label>
    <input type="text" id="txt_fil_ser" name="txt_fil_ser" size="10" maxlength="4" placeholder="Ingrese Serie" value="<?php echo $_POST['ser']?>" />

    <br/>

    <label for="txt_fil_cor" align="left">Correlativo:</label>
    <input type="text" id="txt_fil_cor" name="txt_fil_cor" size="10" placeholder="Ingrese Correlativo" maxlength="8" value="<?php echo $_POST['cor']?>" />

	<br/>

    <label for="txt_fil_ven_fec1" align="left">Fecha de Emisión:</label>
    <input name="txt_fil_ven_fec1" type="text" id="txt_fil_ven_fec1" value="<?php echo $fec1?>" size="8" value="<?php echo $_POST['fec']?>" readonly>

    <br/>

    <label for="txt_fil_mon" align="left">Monto Total:</label>
    <input type="text" id="txt_fil_mon" name="txt_fil_mon" size="12" placeholder="Ingrese Monto Total" value="<?php echo $_POST['mon']?>" />

    <br/>
    <br/>

    <img style="border:1px solid" src="<?php echo $_SESSION['captcha']['image_src'] ?>" />
    <br/>
    <input style="width: 158px;" type="text" id="txt_fil_cap" name="txt_fil_cap" maxlength="5" autocomplete="off" placeholder="Ingrese Captcha" />

    <br/>
    <?php
    	if($_POST['error']=='2'){
    		echo '<div id="msg_cap">El Captcha no Coincide</div>';
    	}else{
    		echo '<div id="msg_cap">&nbsp;</div>';
    	}
    ?>
    <br/>

  	<a href="#" onClick="test()" id="btn_filtrar">Buscar Documento</a>
    <a href="#" onClick="venta_filtro()" id="btn_resfil">Restablecer</a>

</center>

</fieldset>
</form>