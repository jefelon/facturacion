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
    #for_fil_contable{
        width: 60%;
        margin: 0 auto;
    }
    .center{
        width: 50%;
        text-align: center;
        margin: 0 auto;
    }
    #for_fil_contable label {
        display:inline-block;
        width: 140px;
        padding: 5px;
    }
    #for_fil_contable input[type="text"]{
        width: 180px;
    }
    #for_fil_contable select{
        width: 180px;
    }
</style>

<form name="for_fil_contable" id="for_fil_contable" target="_blank" action="venta_reporte.php" method="post">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla_garantia.php">

    <input name="hdd_action" id="hdd_action" type="hidden" value="">

<div style="width: 100%;margin: 0 auto">

    <fieldset style="width: 100%;float: left"><legend>Descargar PLE</legend>
        <label for="cmb_fil_anio" align="right">Año:</label>
        <select name="cmb_fil_anio" id="cmb_fil_anio">
            <option value="2018">2018</option>
            <option value="2018">2017</option>
        </select>

        <label for="cmb_fil_mes" align="right">Mes:</label>
        <select name="cmb_fil_mes" id="cmb_fil_mes">
            <option value="01">Enero</option>
            <option value="02">Febrero</option>
            <option value="03">Marzo</option>
            <option value="04">Abril</option>
            <option value="05">Mayo</option>
            <option value="06">Junio</option>
            <option value="07">Julio</option>
            <option value="08">Agosto</option>
            <option value="09">Septiembre</option>
            <option value="10">Octubre</option>
            <option value="11">Noviembre</option>
            <option value="12">Diciembre</option>
        </select>

        <br/>

        <label for="cmb_fil_ven_doc" align="right">Libro o Registro:</label>
        <select name="cmb_fil_librople" id="cmb_fil_librople">
            <option value="-">Seleccionar Libro</option>
            <option value="1">PLE Registro de Compras 080100 - COMPLETO</option>
            <option value="1">PLE Registro de Compras 080200 - NO DOMICILIADO</option>
            <option value="1">PLE Registro de Ventas 140100 - COMPLETO</option>
            <option value="1">PLE Diario de Formato Simplificado 050200</option>
            <option value="1">PLE Diario de Formato Simplificado - PLAN CONTABLE</option>
        </select>
        <br/>

        <a href="#" onClick="test_txt()" id="btn_filtrar" class="center">DESCARGAR</a>
    </fieldset>
</div>


</form>