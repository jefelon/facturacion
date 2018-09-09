<?php

session_start();

?>
<script type="text/javascript">
	$('#btn_descargar_excel, #btn_descargar_pdf,#btn_descargar_txt, #filtrar_consulta').button({
		icons: {primary: "ui-icon-print"},
	});

    $('#filtrar_consulta').button({
        icons: {primary: "ui-icon-arrowrefresh-1-w"},
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

$(function() {

	cmb_ven_doc('<?php echo $_POST['doc']?>');
    registro_filtro();

});
</script>

<style>
    #for_fil_contable{
        width: 60%;
        height: 100px;
        margin: 0 auto;

    }
    .center{
        width: 40%;
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

<form name="for_fil_contable" id="for_fil_contable" target="_blank" action="" method="post"">
<input name="hdd_modo" id="hdd_modo" type="hidden" value="venta_tabla_garantia.php">

    <input name="hdd_action" id="hdd_action" type="hidden" value="">
<input type="hidden" id="hdd_tabla" name="hdd_tabla" />

<div style="width: 100%;margin: 0 auto">

    <fieldset style="width: 100%;float: left; text-align: center;"><legend>Descargar Registro</legend>
        <label for="cmb_fil_ven_doc" align="right" style="font-size: 12px;">Año:</label>
        <select name="cmb_fil_anio" id="cmb_fil_anio" required>
            <option value="2018">2018</option>
            <option value="2018">2017</option>
        </select>

        <label for="cmb_fil_mes" align="right" style="font-size: 12px;">Mes:</label>
        <select name="cmb_fil_mes" id="cmb_fil_mes" required>
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

        <label for="cmb_fil_tipo_doc" align="right" style="font-size: 12px;">Registro:</label>
        <select name="cmb_fil_tipo_doc" id="cmb_fil_tipo_doc" required>
            <option value="3">Registro de Venta</option>
            <option value="1">Registro de Compra</option>
        </select>
        <br/>

        <a class="btn_descargar_excel" id="btn_descargar_excel" href="#" onClick="registro_reporte_xls()" title="Imprimir en Excel">DESCARGAR EXCEL</a>
        <a class="btn_descargar_pdf" id="btn_descargar_pdf" href="#" onClick="registro_reporte_pdf()" title="Imprimir en PDF">DESCARGAR PDF</a>
        <a class="btn_descargar_txt" id="btn_descargar_txt" href="#" onClick="registro_reporte_txt()" title="Descargar PLE TXT">DESCARGAR PLE TXT</a>
        <a class="filtrar_consulta" id="filtrar_consulta" href="#" onClick="registro_filtro()" title="Filtrar">FILTRAR</a>
    </fieldset>
</div>


</form>

<div id="div_registro_venta_tabla" class="registro_venta_tabla">
</div>
