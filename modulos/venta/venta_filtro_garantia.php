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

    function test_comp() {
        $('#hdd_action').val('filter_comp');
        venta_tabla();
    }

    function test_doc() {
        $('#hdd_action').val('filter_doc');
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
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla_garantia.php">

    <input name="hdd_action" id="hdd_action" type="hidden" value="">

<div style="width: 80%;margin: 0 auto">

    <fieldset style="width: 40%;float: left"><legend>Buscar por N° de Comprobante</legend>
        <label for="cmb_fil_ven_doc" align="left">Tipo de Documento:</label>
        <select name="cmb_fil_ven_doc" id="cmb_fil_ven_doc"></select>

        <br/>

        <label for="txt_fil_numdoc" align="left">Número de Comprobante:</label>
        <input type="text" id="txt_fil_numdoc" name="txt_fil_compdoc" size="20" placeholder="Ejemplo: F001-00566" value=""/>

        <br/>
        <br/>

        <a href="#" onClick="test_comp()" id="btn_filtrar">Buscar Documento</a>
        <a href="#" onClick="venta_filtro()" id="btn_resfil">Restablecer</a>
    </fieldset>

    <fieldset style="width: 40%;float: right"><legend>Buscar por DNI/RUC</legend>
        <label for="txt_fil_numdoc" align="left">Número de RUC/DNI:</label>
        <input type="text" id="txt_fil_numdni" name="txt_fil_numdni" size="20" placeholder="" value=""/>

        <br/>
        <br/>
        <a href="#" onClick="test_doc()" id="btn_filtrardni">Buscar Documento</a>
        <a href="#" onClick="venta_filtro()" id="btn_resfildni">Restablecer</a>
    </fieldset>

</div>


</form>