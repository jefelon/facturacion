<?php

session_start();

?>
<script type="text/javascript">
	$('#btn_filtrar').button({
		icons: {primary: "ui-icon-search"},
	});
	$('#btn_resfil').button({
        icons: {primary: "ui-icon-arrowrefresh-1-w"},

    });
    $('#btn_filtrardni').button({
        icons: {primary: "ui-icon-search"},
    });
    $('#btn_resfildni').button({
        icons: {primary: "ui-icon-arrowrefresh-1-w"},

    });

function test(){
	venta_tabla();
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

	cmb_ven_doc('<?php echo $_POST['doc']?>');

    $('#cmb_fil_ven_doc').bind('input', function() {
        if($(this).val()!='' || $('#txt_fil_numdoc').val()!=''){
            $('#txt_fil_serial').prop('disabled', true);
            $('#txt_fil_serial').css('background', 'silver');
            $('#txt_fil_serial').attr('placeholder', '');
            $('#hdd_action').val('filtro_doc');
        }else{
            $('#txt_fil_serial').prop('disabled', false);
            $('#txt_fil_serial').css('background', '#fff');
            $('#txt_fil_serial').attr('placeholder', 'Ingrese Serial');
            $('#hdd_action').val('filtro_serial');
        }
    });

    $('#txt_fil_numdoc').bind('input', function() {
        if($(this).val()!=''|| $('#cmb_fil_ven_doc').val()!=''){
            $('#txt_fil_serial').prop('disabled', true);
            $('#txt_fil_serial').css('background', 'silver');
            $('#txt_fil_serial').attr('placeholder', '');
            $('#hdd_action').val('filtro_doc');
        }else{
            $('#txt_fil_serial').prop('disabled', false);
            $('#txt_fil_serial').css('background', '#fff');
            $('#txt_fil_serial').attr('placeholder', 'Ingrese Serial');
            $('#hdd_action').val('filtro_serial');
        }
    });
    $('#txt_fil_serial').bind('input', function() {
        if($(this).val()!=''){
            $( "#txt_fil_numdoc, #cmb_fil_ven_doc" ).prop('disabled', true);
            $( "#txt_fil_numdoc, #cmb_fil_ven_doc" ).css('background', 'silver');
            $( "#txt_fil_numdoc, #cmb_fil_ven_doc" ).attr('placeholder', '');
            $( "#hdd_action" ).val('filtro_serial');
        }else{
            $( "#txt_fil_numdoc, #cmb_fil_ven_doc" ).prop('disabled', false);
            $( "#txt_fil_numdoc, #cmb_fil_ven_doc" ).css('background', '#fff');
            $( "#hdd_action" ).val('filtro_doc');
        }
    });


});
</script>

<style>
#for_fil_ven label {
	display:inline-block;
    width: 140px;
    padding: 5px;
}
#for_fil_ven input[type="text"]{
	width: 180px;
}
#for_fil_ven select{
	width: 180px;
}
</style>

<form name="for_fil_ven" id="for_fil_ven" target="_blank" action="venta_reporte.php" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla_serial.php">

    <input name="hdd_action" id="hdd_action" type="hidden" value="filtro_doc">

<div style="width: 80%;margin: 0 auto">

    <fieldset style="width: 40%;float: left"><legend>Buscar por N° de Comprobante</legend>
        <label for="cmb_fil_ven_doc" align="left">Tipo de Documento:</label>
        <select name="cmb_fil_ven_doc" id="cmb_fil_ven_doc"></select>

        <br/>

        <label for="txt_fil_numdoc" align="left">Número de Comprobante:</label>
        <input type="text" id="txt_fil_numdoc" name="txt_fil_numdoc" size="20" placeholder="Ejemplo: F001-00566" value="<?php echo $_POST['numdoc']?>" />

        <br/>
    <!--
        <label for="txt_fil_serial" align="left">Serial:</label>
        <input type="text" id="txt_fil_serial" name="txt_fil_serial" size="20" placeholder="Ingrese Serial" maxlength="8" value="<?php echo $_POST['serial']?>" />
    -->
        <br/>

        <a href="#" onClick="test()" id="btn_filtrar">Buscar Documento</a>
        <a href="#" onClick="venta_filtro()" id="btn_resfil">Restablecer</a>
    </fieldset>

    <fieldset style="width: 40%;float: right"><legend>Buscar por DNI/RUC</legend>
        <label for="txt_fil_numdoc" align="left">Número de RUC/DNI:</label>
        <input type="text" id="txt_fil_numdni" name="txt_fil_numdni" size="20" placeholder="" value="<?php echo $_POST['numdni']?>" />

        <br/>
        <br/>
        <a href="#" onClick="test()" id="btn_filtrardni">Buscar Documento</a>
        <a href="#" onClick="venta_filtro()" id="btn_resfildni">Restablecer</a>
    </fieldset>

</div>


</form>